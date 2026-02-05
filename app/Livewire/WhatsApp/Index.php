<?php

namespace App\Livewire\WhatsApp;
use Livewire\Component;
use App\Models\WhatsAppSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Index extends Component
{
    public $apiResponse;
    public $qrCodeSvg;
    public $isLoading = false;
    public $currentSessionId;
    public $sessionGuardada = false;

    public function mount()
    {
        // ...existing code...
        $activeSession = WhatsAppSession::where('is_current', true)
                                        ->where('status', 'active')
                                        ->first();
        
        if ($activeSession) {
            $this->currentSessionId = $activeSession->session_id;
            $this->sessionGuardada = true;
            $this->apiResponse = "Sesion activa encontrada: {$activeSession->session_id}";
            Log::info("Sesion activa encontrada al cargar: {$activeSession->session_id}");
        } else {
            // ...existing code...
            $this->apiResponse = null;
        }
    }

    public function crearSesion()
    {
        $this->reset(['apiResponse', 'qrCodeSvg']);
        $this->isLoading = true;

        try {
            $sessionId = 'mi-sesion-' . Str::random(8);

            // Inicializar cliente en backend
            $initResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/client-initialize',
                ['sessionId' => $sessionId]
            );

            if (! $initResponse->successful()) {
                $this->apiResponse = "Error de conexion al servidor (HTTP {$initResponse->status()})";
                $this->isLoading = false;
                return;
            }

            $data = $initResponse->json();
            
            // Verificar si la respuesta es exitosa segun el formato especificado
            if (!isset($data['success']) || $data['success'] !== true) {
                $this->apiResponse = "Error al inicializar el dispositivo. Por favor, intentalo de nuevo.";
                $this->isLoading = false;
                return;
            }

            // Guardar sesion en BD solo si la inicializacion fue exitosa
            WhatsAppSession::create(['session_id' => $sessionId]);

            // Mostrar mensaje de exito
            $this->apiResponse = "{$data['message']} (Session: {$sessionId})";
            $this->currentSessionId = $sessionId; // Guardar la sesión actual

            // Esperar 7 segundos antes de pedir el QR
            sleep(8);

            // Obtener QR en SVG
            $qrResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/qr',
                ['sessionId' => $sessionId]
            );
            Log::info("Respuesta QR: " . $qrResponse);
            if ($qrResponse->successful()) {
                $svg = $qrResponse->body();
                // Codifica el SVG a Base64 y cambia el tipo MIME
                $base64_svg = base64_encode($svg);
                $this->qrCodeSvg = 'data:image/svg+xml;base64,' . $base64_svg;
                Log::info($this->qrCodeSvg);
            } else {
                $this->apiResponse .= " No se pudo obtener QR (HTTP {$qrResponse->status()})";
            }
        } catch (\Exception $e) {
            $this->apiResponse = "Error inesperado: " . $e->getMessage() . ". Por favor, intentalo de nuevo.";
            Log::error("Error en crearSesion: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function regenerarQR()
    {
        // Solo regenerar QR si ya existe una sesion
        if (!$this->currentSessionId) {
            $this->apiResponse = "No hay una sesion activa. Crea una nueva sesion primero.";
            return;
        }

        $this->reset(['qrCodeSvg']);
        $this->isLoading = true;

        try {
            $this->apiResponse = "Regenerando QR para sesion: {$this->currentSessionId}";
            
            // Esperar un poco antes de pedir el QR
            sleep(3);

            // Obtener QR en SVG usando la sesión existente
            $qrResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/qr',
                ['sessionId' => $this->currentSessionId]
            );

            if ($qrResponse->successful()) {
                $svg = $qrResponse->body();
                // Codifica el SVG a Base64 y cambia el tipo MIME
                $base64_svg = base64_encode($svg);
                $this->qrCodeSvg = 'data:image/svg+xml;base64,' . $base64_svg;
                $this->apiResponse = "Nuevo QR generado para sesion: {$this->currentSessionId}";
                Log::info('QR regenerado: ' . $this->qrCodeSvg);
            } else {
                $this->apiResponse = "No se pudo regenerar el QR (HTTP {$qrResponse->status()}). Por favor, intentalo de nuevo.";
                Log::error("Error regenerando QR", ['status' => $qrResponse->status(), 'body' => $qrResponse->body()]);
            }
        } catch (\Exception $e) {
            $this->apiResponse = "Error inesperado al regenerar QR: " . $e->getMessage() . ". Por favor, intentalo de nuevo.";
            Log::error("Excepción regenerando QR: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function guardarSesion()
    {
        if (!$this->currentSessionId) {
            $this->apiResponse = "No hay una sesion activa para guardar.";
            return;
        }

        try {
            // Primero, desactivar todas las sesiones anteriores
            WhatsAppSession::where('is_current', true)->update([
                'is_current' => false,
                'status' => 'inactive'
            ]);

            // Verificar si la sesión ya existe en la base de datos
            $existingSession = WhatsAppSession::where('session_id', $this->currentSessionId)->first();
            
            if ($existingSession) {
                // Actualizar la sesión existente
                $existingSession->update([
                    'status' => 'active',
                    'is_current' => true,
                    'last_connected_at' => now()
                ]);
                $this->apiResponse = "Sesion {$this->currentSessionId} actualizada y marcada como activa.";
            } else {
                // Crear nueva sesión con estado activo
                WhatsAppSession::create([
                    'session_id' => $this->currentSessionId,
                    'status' => 'active',
                    'is_current' => true,
                    'last_connected_at' => now()
                ]);
                $this->apiResponse = "Sesion {$this->currentSessionId} guardada y marcada como activa.";
            }
            
            // Activar el estado de sesión guardada
            $this->sessionGuardada = true;
            
            Log::info("Sesion guardada: {$this->currentSessionId}");
        } catch (\Exception $e) {
            $this->apiResponse = "Error al guardar sesion: " . $e->getMessage();
            Log::error("Error guardando sesión: " . $e->getMessage());
        }
    }

    public function enviarMensajePrueba()
    {
        if (!$this->currentSessionId) {
            $this->apiResponse = "No hay una sesion activa. Vincula WhatsApp primero.";
            return;
        }

        $this->isLoading = true;

        try {
            $this->apiResponse = "Enviando mensaje de prueba...";

            // Enviar mensaje usando form data
            $response = Http::timeout(30)->asForm()->post(
                'http://172.19.0.17/whatsapp/api/send',
                [
                    'sessionId' => $this->currentSessionId,
                    'to' => '51915141721',
                    'message' => 'Mensaje Prueba - Ignorar'
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                
                // Verificar si el envío fue exitoso
                if (isset($data['success']) && $data['success'] === true) {
                    $this->apiResponse = "Mensaje de prueba enviado exitosamente.";
                    Log::info("Mensaje enviado exitosamente", ['response' => $data]);
                } else {
                    $this->apiResponse = "Error al enviar mensaje: " . ($data['message'] ?? 'Error desconocido');
                    Log::error("Error en respuesta del mensaje", ['response' => $data]);
                }
            } else {
                $this->apiResponse = "Error de conexion al enviar mensaje (HTTP {$response->status()}). Por favor, intentalo de nuevo.";
                Log::error("Error enviando mensaje", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            $this->apiResponse = "Error inesperado al enviar mensaje: " . $e->getMessage() . ". Por favor, intentalo de nuevo.";
            Log::error("Excepción enviando mensaje: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function nuevaSesion()
    {
        // ...existing code...
        $this->isLoading = true;
        
        // ...existing code...
        if ($this->currentSessionId) {
            try {
                $this->apiResponse = "Cerrando sesion actual...";
                
                // Llamar al endpoint de logout
                $logoutResponse = Http::timeout(30)->post(
                    'http://172.19.0.17/whatsapp/api/client-logout',
                    ['sessionId' => $this->currentSessionId]
                );

                if ($logoutResponse->successful()) {
                    $data = $logoutResponse->json();
                    
                    // Verificar si el logout fue exitoso
                    if (isset($data['success']) && $data['success'] === true) {
                        $this->apiResponse = "Sesion cerrada exitosamente. Creando nueva sesion...";
                        Log::info("Logout exitoso para sesion: {$this->currentSessionId}", ['response' => $data]);
                    } else {
                        $this->apiResponse = "Advertencia al cerrar sesion: " . ($data['message'] ?? 'Respuesta inesperada') . ". Creando nueva sesion...";
                        Log::warning("Respuesta inesperada en logout", ['response' => $data]);
                    }
                } else {
                    $this->apiResponse = "Error al cerrar sesion (HTTP {$logoutResponse->status()}). Creando nueva sesion...";
                    Log::error("Error en logout", [
                        'status' => $logoutResponse->status(),
                        'body' => $logoutResponse->body()
                    ]);
                }
            } catch (\Exception $e) {
                $this->apiResponse = "Error inesperado al cerrar sesion: " . $e->getMessage() . ". Creando nueva sesion...";
                Log::error("Excepcion en logout: " . $e->getMessage());
            }
            
            // ...existing code...
            sleep(1);
        }

        // ...existing code...
        if ($this->currentSessionId) {
            try {
                WhatsAppSession::where('session_id', $this->currentSessionId)->update([
                    'status' => 'inactive',
                    'is_current' => false
                ]);
                Log::info("Sesion desactivada en BD: {$this->currentSessionId}");
            } catch (\Exception $e) {
                Log::error("Error al desactivar sesion en BD: " . $e->getMessage());
            }
        }

        // ...existing code...
        $this->qrCodeSvg = null;
        $this->currentSessionId = null;
        $this->sessionGuardada = false;
        
        // Mostrar mensaje de que esta creando nueva sesion
        $this->apiResponse = "Inicializando nueva sesion...";
        
        // Automaticamente iniciar la creacion de una nueva sesion
        $this->crearSesionInterna();
    }

    private function crearSesionInterna()
    {
        try {
            $sessionId = 'mi-sesion-' . Str::random(8);

            // Inicializar cliente en backend
            $initResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/client-initialize',
                ['sessionId' => $sessionId]
            );

            if (! $initResponse->successful()) {
                $this->apiResponse = "Error de conexion al servidor (HTTP {$initResponse->status()})";
                $this->isLoading = false;
                return;
            }

            $data = $initResponse->json();
            
            // Verificar si la respuesta es exitosa segun el formato especificado
            if (!isset($data['success']) || $data['success'] !== true) {
                $this->apiResponse = "Error al inicializar el dispositivo. Por favor, intentalo de nuevo.";
                $this->isLoading = false;
                return;
            }

            // Guardar sesion en BD solo si la inicializacion fue exitosa
            // Primero desactivar todas las sesiones anteriores
            WhatsAppSession::where('is_current', true)->update([
                'is_current' => false,
                'status' => 'inactive'
            ]);
            
            // Crear nueva sesion como pendiente (se activara cuando se guarde)
            WhatsAppSession::create([
                'session_id' => $sessionId,
                'status' => 'pending', // pendiente hasta que se escanee el QR
                'is_current' => false
            ]);

            // Mostrar mensaje de exito
            $this->apiResponse = "{$data['message']} (Session: {$sessionId})";
            $this->currentSessionId = $sessionId; // Guardar la sesión actual

            // Esperar 7 segundos antes de pedir el QR
            sleep(7);

            // Obtener QR en SVG
            $qrResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/qr',
                ['sessionId' => $sessionId]
            );
            
            if ($qrResponse->successful()) {
                $svg = $qrResponse->body();
                // Codifica el SVG a Base64 y cambia el tipo MIME
                $base64_svg = base64_encode($svg);
                $this->qrCodeSvg = 'data:image/svg+xml;base64,' . $base64_svg;
                Log::info($this->qrCodeSvg);
            } else {
                $this->apiResponse .= " No se pudo obtener QR (HTTP {$qrResponse->status()})";
            }
        } catch (\Exception $e) {
            $this->apiResponse = "Error inesperado: " . $e->getMessage() . ". Por favor, intentalo de nuevo.";
            Log::error("Error en crearSesionInterna: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.whats-app.index');
    }
}

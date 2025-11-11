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
    public $qrCodeSvg; // <- para el SVG
    public $isLoading = false;
    public $currentSessionId; // <- para guardar la sesión actual
    public $sessionGuardada = false; // <- para controlar cuando la sesión está guardada

    public function mount()
    {
        // Verificar si hay una sesión activa al cargar el componente
        $activeSession = WhatsAppSession::where('is_current', true)
                                        ->where('status', 'active')
                                        ->first();
        
        if ($activeSession) {
            $this->currentSessionId = $activeSession->session_id;
            $this->sessionGuardada = true;
            $this->apiResponse = "✅ Sesión activa encontrada: {$activeSession->session_id}";
            Log::info("Sesión activa encontrada al cargar: {$activeSession->session_id}");
        } else {
            // No asignar nada a $apiResponse para que la interfaz inicial se muestre
            $this->apiResponse = null;
        }
    }

    public function crearSesion()
    {
        $this->reset(['apiResponse', 'qrCodeSvg']);
        $this->isLoading = true;

        try {
            $sessionId = 'mi-sesion-' . Str::random(8);

            // 2️⃣ Inicializar cliente en backend
            $initResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/client-initialize',
                ['sessionId' => $sessionId]
            );

            if (! $initResponse->successful()) {
                $this->apiResponse = "❌ Error de conexión al servidor (HTTP {$initResponse->status()})";
                $this->isLoading = false;
                return;
            }

            $data = $initResponse->json();
            
            // Verificar si la respuesta es exitosa según el formato especificado
            if (!isset($data['success']) || $data['success'] !== true) {
                $this->apiResponse = "❌ Error al inicializar el dispositivo. Por favor, inténtalo de nuevo.";
                $this->isLoading = false;
                return;
            }

            // Guardar sesión en BD solo si la inicialización fue exitosa
            WhatsAppSession::create(['session_id' => $sessionId]);

            // Mostrar mensaje de éxito
            $this->apiResponse = "✅ {$data['message']} (Session: {$sessionId})";
            $this->currentSessionId = $sessionId; // Guardar la sesión actual

            // 3️⃣ Esperar 7 segundos antes de pedir el QR
            sleep(8);

            // 4️⃣ Obtener QR en SVG
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
                $this->apiResponse .= " ⚠️ No se pudo obtener QR (HTTP {$qrResponse->status()})";
            }
        } catch (\Exception $e) {
            $this->apiResponse = "🚨 Error inesperado: " . $e->getMessage() . ". Por favor, inténtalo de nuevo.";
            Log::error("Error en crearSesion: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function regenerarQR()
    {
        // Solo regenerar QR si ya existe una sesión
        if (!$this->currentSessionId) {
            $this->apiResponse = "⚠️ No hay una sesión activa. Crea una nueva sesión primero.";
            return;
        }

        $this->reset(['qrCodeSvg']);
        $this->isLoading = true;

        try {
            $this->apiResponse = "🔄 Regenerando QR para sesión: {$this->currentSessionId}";
            
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
                $this->apiResponse = "✅ Nuevo QR generado para sesión: {$this->currentSessionId}";
                Log::info('QR regenerado: ' . $this->qrCodeSvg);
            } else {
                $this->apiResponse = "❌ No se pudo regenerar el QR (HTTP {$qrResponse->status()}). Por favor, inténtalo de nuevo.";
                Log::error("Error regenerando QR", ['status' => $qrResponse->status(), 'body' => $qrResponse->body()]);
            }
        } catch (\Exception $e) {
            $this->apiResponse = "🚨 Error inesperado al regenerar QR: " . $e->getMessage() . ". Por favor, inténtalo de nuevo.";
            Log::error("Excepción regenerando QR: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function guardarSesion()
    {
        if (!$this->currentSessionId) {
            $this->apiResponse = "⚠️ No hay una sesión activa para guardar.";
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
                $this->apiResponse = "✅ Sesión {$this->currentSessionId} actualizada y marcada como activa.";
            } else {
                // Crear nueva sesión con estado activo
                WhatsAppSession::create([
                    'session_id' => $this->currentSessionId,
                    'status' => 'active',
                    'is_current' => true,
                    'last_connected_at' => now()
                ]);
                $this->apiResponse = "✅ Sesión {$this->currentSessionId} guardada y marcada como activa.";
            }
            
            // Activar el estado de sesión guardada
            $this->sessionGuardada = true;
            
            Log::info("Sesión guardada: {$this->currentSessionId}");
        } catch (\Exception $e) {
            $this->apiResponse = "🚨 Error al guardar sesión: " . $e->getMessage();
            Log::error("Error guardando sesión: " . $e->getMessage());
        }
    }

    public function enviarMensajePrueba()
    {
        if (!$this->currentSessionId) {
            $this->apiResponse = "⚠️ No hay una sesión activa. Vincula WhatsApp primero.";
            return;
        }

        $this->isLoading = true;

        try {
            $this->apiResponse = "📤 Enviando mensaje de prueba...";

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
                    $this->apiResponse = "✅ Mensaje de prueba enviado exitosamente.";
                    Log::info("Mensaje enviado exitosamente", ['response' => $data]);
                } else {
                    $this->apiResponse = "❌ Error al enviar mensaje: " . ($data['message'] ?? 'Error desconocido');
                    Log::error("Error en respuesta del mensaje", ['response' => $data]);
                }
            } else {
                $this->apiResponse = "❌ Error de conexión al enviar mensaje (HTTP {$response->status()}). Por favor, inténtalo de nuevo.";
                Log::error("Error enviando mensaje", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            $this->apiResponse = "🚨 Error inesperado al enviar mensaje: " . $e->getMessage() . ". Por favor, inténtalo de nuevo.";
            Log::error("Excepción enviando mensaje: " . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function nuevaSesion()
    {
        // Activar loading desde el inicio
        $this->isLoading = true;
        
        // Si hay una sesión activa, hacer logout primero
        if ($this->currentSessionId) {
            try {
                $this->apiResponse = "🔄 Cerrando sesión actual...";
                
                // Llamar al endpoint de logout
                $logoutResponse = Http::timeout(30)->post(
                    'http://172.19.0.17/whatsapp/api/client-logout',
                    ['sessionId' => $this->currentSessionId]
                );

                if ($logoutResponse->successful()) {
                    $data = $logoutResponse->json();
                    
                    // Verificar si el logout fue exitoso
                    if (isset($data['success']) && $data['success'] === true) {
                        $this->apiResponse = "✅ Sesión cerrada exitosamente. Creando nueva sesión...";
                        Log::info("Logout exitoso para sesión: {$this->currentSessionId}", ['response' => $data]);
                    } else {
                        $this->apiResponse = "⚠️ Advertencia al cerrar sesión: " . ($data['message'] ?? 'Respuesta inesperada') . ". Creando nueva sesión...";
                        Log::warning("Respuesta inesperada en logout", ['response' => $data]);
                    }
                } else {
                    $this->apiResponse = "⚠️ Error al cerrar sesión (HTTP {$logoutResponse->status()}). Creando nueva sesión...";
                    Log::error("Error en logout", [
                        'status' => $logoutResponse->status(),
                        'body' => $logoutResponse->body()
                    ]);
                }
            } catch (\Exception $e) {
                $this->apiResponse = "⚠️ Error inesperado al cerrar sesión: " . $e->getMessage() . ". Creando nueva sesión...";
                Log::error("Excepción en logout: " . $e->getMessage());
            }
            
            // Pequeña pausa para mostrar el mensaje
            sleep(1);
        }

        // Desactivar la sesión anterior en la base de datos
        if ($this->currentSessionId) {
            try {
                WhatsAppSession::where('session_id', $this->currentSessionId)->update([
                    'status' => 'inactive',
                    'is_current' => false
                ]);
                Log::info("Sesión desactivada en BD: {$this->currentSessionId}");
            } catch (\Exception $e) {
                Log::error("Error al desactivar sesión en BD: " . $e->getMessage());
            }
        }

        // Resetear solo las variables necesarias (manteniendo isLoading = true)
        $this->qrCodeSvg = null;
        $this->currentSessionId = null;
        $this->sessionGuardada = false;
        
        // Mostrar mensaje de que está creando nueva sesión
        $this->apiResponse = "🔄 Inicializando nueva sesión...";
        
        // Automáticamente iniciar la creación de una nueva sesión
        $this->crearSesionInterna();
    }

    private function crearSesionInterna()
    {
        try {
            $sessionId = 'mi-sesion-' . Str::random(8);

            // 2️⃣ Inicializar cliente en backend
            $initResponse = Http::timeout(30)->post(
                'http://172.19.0.17/whatsapp/api/client-initialize',
                ['sessionId' => $sessionId]
            );

            if (! $initResponse->successful()) {
                $this->apiResponse = "❌ Error de conexión al servidor (HTTP {$initResponse->status()})";
                $this->isLoading = false;
                return;
            }

            $data = $initResponse->json();
            
            // Verificar si la respuesta es exitosa según el formato especificado
            if (!isset($data['success']) || $data['success'] !== true) {
                $this->apiResponse = "❌ Error al inicializar el dispositivo. Por favor, inténtalo de nuevo.";
                $this->isLoading = false;
                return;
            }

            // Guardar sesión en BD solo si la inicialización fue exitosa
            // Primero desactivar todas las sesiones anteriores
            WhatsAppSession::where('is_current', true)->update([
                'is_current' => false,
                'status' => 'inactive'
            ]);
            
            // Crear nueva sesión como pendiente (se activará cuando se guarde)
            WhatsAppSession::create([
                'session_id' => $sessionId,
                'status' => 'pending', // pendiente hasta que se escanee el QR
                'is_current' => false
            ]);

            // Mostrar mensaje de éxito
            $this->apiResponse = "✅ {$data['message']} (Session: {$sessionId})";
            $this->currentSessionId = $sessionId; // Guardar la sesión actual

            // 3️⃣ Esperar 7 segundos antes de pedir el QR
            sleep(7);

            // 4️⃣ Obtener QR en SVG
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
                $this->apiResponse .= " ⚠️ No se pudo obtener QR (HTTP {$qrResponse->status()})";
            }
        } catch (\Exception $e) {
            $this->apiResponse = "🚨 Error inesperado: " . $e->getMessage() . ". Por favor, inténtalo de nuevo.";
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

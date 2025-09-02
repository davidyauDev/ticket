<!doctype html>
<html lang="es" style="margin:0;padding:0;">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nuevo ticket derivado</title>
  <style>
    /* Modo oscuro (respeta preferencia del usuario) */
    @media (prefers-color-scheme: dark) {
      .email-body { background:#0b1220 !important; }
      .card { background:#121a2b !important; border-color:#1d2942 !important; }
      .text { color:#e6eefc !important; }
      .muted { color:#b5c2d9 !important; }
      .divider { border-color:#2a385a !important; }
      .btn { background:#4f8cff !important; }
      .badge { background:#1e2a44 !important; color:#bcd1ff !important; border-color:#2d3e66 !important; }
    }
    /* “Mobile-first” helpers */
    @media screen and (max-width: 600px) {
      .container { width: 100% !important; padding: 0 16px !important; }
      .btn { display:block !important; width:100% !important; }
      .stack { display:block !important; width:100% !important; }
      .table-kv td { display:block !important; padding:8px 0 !important; border-bottom:1px solid #e9eef6 !important; }
      .table-kv tr:last-child td { border-bottom:none !important; }
    }
  </style>
</head>
<body class="email-body" style="margin:0;padding:0;background:#f3f6fb;">
  <!-- preheader (texto de avance en bandeja) -->
  <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
    Se derivó un nuevo ticket a tu área. Revísalo cuando puedas.
  </div>

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
    <tr>
      <td align="center" style="padding:32px;">
        <table class="container" role="presentation" width="600" cellspacing="0" cellpadding="0" style="width:600px;max-width:600px;border-collapse:collapse;">
          <!-- Header -->
          <tr>
            <td align="left" style="padding:0 0 16px 0;">
              <div style="font:700 18px/1.2 -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1a2848;">
                Mesa de Ayuda · Cechriza
              </div>
            </td>
          </tr>

          <!-- Card -->
          <tr>
            <td class="card" style="background:#ffffff;border:1px solid #e6ecf5;border-radius:12px;overflow:hidden;">
              <!-- Title strip -->
              <div style="background:#eef4ff;padding:12px 20px;border-bottom:1px solid #e0e9ff;">
                <span class="text" style="font:700 18px/1.3 'Segoe UI',Roboto,Arial,sans-serif;color:#132a5e;">
                  Nuevo ticket derivado a tu área
                </span>
              </div>

              <!-- Body -->
              <div style="padding:24px 20px;">
                <p class="text" style="margin:0 0 12px 0;font:400 15px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#33415c;">
                  Hola,
                </p>
                <p class="text" style="margin:0 0 20px 0;font:400 15px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#33415c;">
                  Desde la Mesa de Ayuda te informamos que se ha derivado un nuevo ticket a tu área en el sistema de atención interna. Por favor, revísalo cuando te sea posible.
                </p>

                <!-- Key info chips -->
                <div class="stack" style="margin:0 0 16px 0;">
                  <span class="badge" style="display:inline-block;margin:0 8px 8px 0;padding:6px 10px;border:1px solid #dfe7f5;border-radius:999px;background:#f5f8ff;color:#33415c;font:600 12px/1 'Segoe UI',Roboto,Arial,sans-serif;">
                    Código: {{ $ticket->codigo ?? '—' }}
                  </span>
                  {{-- <span class="badge" style="display:inline-block;margin:0 8px 8px 0;padding:6px 10px;border:1px solid #dfe7f5;border-radius:999px;background:#f5f8ff;color:#33415c;font:600 12px/1 'Segoe UI',Roboto,Arial,sans-serif;">
                    Estado: {{ $ticket->estado->nombre ?? 'Pendiente' }}
                  </span> --}}
                  {{-- <span class="badge" style="display:inline-block;margin:0 8px 8px 0;padding:6px 10px;border:1px solid #dfe7f5;border-radius:999px;background:#f5f8ff;color:#33415c;font:600 12px/1 'Segoe UI',Roboto,Arial,sans-serif;">
                    Tipo: {{ $ticket->tipo ?? 'Ticket' }}
                  </span> --}}
                </div>

                <!-- Details table -->
                <table class="table-kv" role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:1px solid #edf1f7;border-radius:8px;overflow:hidden;">
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;border-bottom:1px solid #edf1f7;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Motivo
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid #edf1f7;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ $ticket->motivo_derivacion ?? 'S/N' }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;border-bottom:1px solid #edf1f7;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Falla reportada
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid #edf1f7;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ $ticket->falla_reportada ?? '—' }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;border-bottom:1px solid #edf1f7;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Técnico asignado
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid #edf1f7;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ trim(($ticket->tecnico_nombres ?? '').' '.($ticket->tecnico_apellidos ?? '')) ?: '—' }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;border-bottom:1px solid #edf1f7;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Agencia / Área
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid #edf1f7;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ $ticket->agencia->nombre ?? ('ID '.$ticket->agencia_id ?? '—') }} · {{ $ticket->area->nombre ?? ('Área ID '.$ticket->area_id ?? '—') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;border-bottom:1px solid #edf1f7;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Comentario
                    </td>
                    <td style="padding:12px 14px;border-bottom:1px solid #edf1f7;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ $ticket->comentario ?? '—' }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width:160px;background:#fafbfe;padding:12px 14px;font:600 13px/1.4 'Segoe UI',Roboto,Arial,sans-serif;color:#5a6b8a;">
                      Creado
                    </td>
                    <td style="padding:12px 14px;font:400 14px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#24324a;">
                      {{ optional($ticket->created_at)->timezone('America/Lima')->format('d/m/Y H:i') ?? '—' }}
                    </td>
                  </tr>
                </table>

                <!-- Button -->
                <div style="text-align:center;margin:24px 0 8px 0;">
                  <a class="btn"
                     href="{{ $url ?? route('tickets.show',$ticket->id ?? 0) }}"
                     style="display:inline-block;text-decoration:none;background:#1a73e8;color:#ffffff;font:700 14px/1 'Segoe UI',Roboto,Arial,sans-serif;padding:14px 22px;border-radius:10px;">
                    Ver ticket asignado
                  </a>
                </div>

                <!-- Fallback link -->
                <p class="muted" style="margin:12px 0 0 0;font:400 12px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#6b7a99;text-align:center;">
                  Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
                  <span style="word-break:break-all;">
                    {{ $url ?? route('tickets.show',$ticket->id ?? 0) }}
                  </span>
                </p>
              </div>

              <!-- Footer -->
              <div style="padding:14px 20px;border-top:1px solid #edf1f7;">
                <p class="muted" style="margin:0;font:400 12px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#6b7a99;">
                  Este es un mensaje automático. Por favor, no respondas a este correo.
                </p>
              </div>
            </td>
          </tr>

          <!-- Legal -->
          <tr>
            <td align="center" style="padding:16px 8px 0 8px;">
              <p class="muted" style="margin:0 0 8px 0;font:400 11px/1.6 'Segoe UI',Roboto,Arial,sans-serif;color:#8a98b3;">
                © {{ now('America/Lima')->format('Y') }} Cechriza · Sistema de Atención Interna
              </p>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Tickets - {{ $mes }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 25px; font-size: 12px; }
        h1 { color: #1E40AF; font-size: 18px; text-align: center; }
        h2 { color: #2563EB; border-bottom: 2px solid #2563EB; padding-bottom: 3px; margin-top: 25px; }
        img { display: block; margin: 10px auto; max-width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #E0E7FF; }
        .section { page-break-inside: avoid; margin-bottom: 30px; }
    </style>
</head>
<body>
    <h1>📊 Reporte de Tickets - {{ ucfirst($mes) }}</h1>
    <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>

    @php
        $sections = [
            ['title' => 'Top Clientes', 'chart' => $chartClientes, 'data' => $topClientes],
            ['title' => 'Top Agencias', 'chart' => $chartAgencias, 'data' => $topAgencias],
            ['title' => 'Top Modelos', 'chart' => $chartModelos, 'data' => $topModelos],
            ['title' => 'Top Equipos', 'chart' => $chartEquipos, 'data' => $topEquipos],
        ];
    @endphp

    @foreach ($sections as $section)
        <div class="section">
            <h2>{{ $section['title'] }}</h2>
            @if($section['chart'])
                <img src="{{ $section['chart'] }}" alt="{{ $section['title'] }}">
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Total Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section['data'] as $item)
                        <tr>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</body>
</html>

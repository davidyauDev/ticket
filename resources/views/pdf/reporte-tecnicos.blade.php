<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Detallado de Técnicos</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #111827;
            margin: 35px;
            font-size: 11.5px;
            background-color: #fff;
        }
        h1, h2 {
            text-align: center;
            color: #1E3A8A;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 14px;
            color: #2563EB;
        }
        .section {
            margin-top: 25px;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th, td {
            border: 1px solid #E5E7EB;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #F3F4F6;
            color: #374151;
        }
        tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        img.chart {
            display: block;
            margin: 20px auto;
            width: 90%;
        }
        .tech-header {
            background: #E0E7FF;
            color: #1E3A8A;
            padding: 8px 10px;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <h1>Reporte Detallado de Técnicos</h1>
    <h2>{{ ucfirst($month) }} {{ now()->year }}</h2>

    <img src="{{ $chartUrl }}" class="chart" alt="Gráfico de técnicos">

    <!-- Sección detallada -->
    @foreach ($callsByTech as $techName => $data)
        <div class="section">
            <div class="tech-header">
                {{ $techName }} — {{ $data['total'] }} llamadas
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">Código</th>
                        <th style="width: 130px;">Fecha</th>
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['calls'] as $call)
                        <tr>
                            <td>TCK-{{ str_pad($call['id'], 7, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $call['date'] }}</td>
                            <td>{{ $call['comentario'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        Generado automáticamente el {{ now()->format('d/m/Y H:i') }} — Sistema de Soporte
    </div>
</body>
</html>

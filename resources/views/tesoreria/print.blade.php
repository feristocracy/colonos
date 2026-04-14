<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado financiero {{ $mes }}/{{ $anio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            margin: 30px;
        }

        h1, h2, p {
            margin: 0 0 10px 0;
        }

        .resumen {
            margin: 20px 0;
        }

        .resumen div {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .text-green {
            color: #059669;
            font-weight: bold;
        }

        .text-red {
            color: #dc2626;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print">Imprimir</button>

    <h1>Tesorería y estado financiero</h1>
    <p>Periodo: {{ \Carbon\Carbon::create()->month($mes)->locale('es')->monthName }} {{ $anio }}</p>

    <div class="resumen">
        <div><strong>Ingresos del mes:</strong> ${{ number_format($ingresosMes, 2) }}</div>
        <div><strong>Egresos del mes:</strong> ${{ number_format($egresosMes, 2) }}</div>
        <div><strong>Balance del mes:</strong> ${{ number_format($balanceMes, 2) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Concepto</th>
                <th>Comentarios</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($movimiento->tipo) }}</td>
                    <td>{{ $movimiento->concepto }}</td>
                    <td>{{ $movimiento->comentarios ?? '—' }}</td>
                    <td>
                        ${{ number_format($movimiento->monto, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
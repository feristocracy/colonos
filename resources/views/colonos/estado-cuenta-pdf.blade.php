<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de cuenta</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 24px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .header-table td {
            border: 0;
            padding: 0;
            vertical-align: top;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 11px;
            color: #4b5563;
        }

        .card {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .row {
            margin-bottom: 6px;
        }

        .label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .muted {
            color: #6b7280;
        }

        .footer {
            margin-top: 18px;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="vertical-align: bottom;">
                    <div class="title">Estado de cuenta</div>
                    <div class="subtitle">
                        Generado el {{ $fechaImpresion->format('d/m/Y H:i') }}
                    </div>
                </td>
                <td style="text-align: right;">
                    <img src="{{ public_path('images/logo.png') }}" alt="logo de la asociación" style="width: 100px;">
                </td>
            </tr>
        </table>
    </div>

    <div class="card">
        <div class="section-title">Datos del colono</div>

        <div class="row">
            <span class="label">Nombre:</span>
            {{ $colono->nombre_completo }}
        </div>

        <div class="row">
            <span class="label">Dirección:</span>
            {{ $colono->direccion }}
        </div>

        <div class="row">
            <span class="label">Teléfono:</span>
            {{ $colono->telefono ?: 'Sin teléfono' }}
        </div>

        <div class="row">
            <span class="label">Correo:</span>
            {{ $colono->correo ?: 'Sin correo' }}
        </div>

        <div class="row">
            <span class="label">Status:</span>
            {{ $colono->esta_al_corriente ? 'Al corriente' : 'Con adeudo' }}
        </div>

        <div class="row">
            <span class="label">Último periodo pagado:</span>
            @if($colono->ultimo_periodo_pagado)
                {{ \Carbon\Carbon::createFromFormat('Y-m', $colono->ultimo_periodo_pagado)->translatedFormat('F Y') }}
            @else
                Sin pagos registrados
            @endif
        </div>
    </div>

    <div class="card">
        <div class="section-title">Historial de pagos</div>

        @if($colono->pagos->count())
            <table>
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Meses cubiertos</th>
                        <th>Fecha de pago</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($colono->pagos as $pago)
                        <tr>
                            <td>{{ $pago->folio }}</td>
                            <td>
                                @if($pago->periodos->count())
                                    @foreach($pago->periodos as $periodo)
                                        <div>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $periodo->periodo)->translatedFormat('F Y') }}
                                        </div>
                                    @endforeach
                                @else
                                    <span class="muted">Sin periodos</span>
                                @endif
                            </td>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td class="text-right">${{ number_format($pago->monto, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="muted">Este colono no tiene pagos registrados.</div>
        @endif
    </div>

    <div class="footer">
        Documento generado desde el sistema de administración de la asociacion.
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Kartu - {{ $registration['registration_number'] }}</title>
    <style>
        :root {
            color-scheme: light;
            --card-width: 85.6mm;
            --card-height: 54mm;
            --ink: #10233d;
            --muted: #5b6b80;
            --accent: #0f766e;
            --panel: #f8fbff;
            --line: rgba(16, 35, 61, 0.12);
            --deep: #103b73;
        }

        * {
            box-sizing: border-box;
        }

        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        html,
        body {
            width: var(--card-width);
            height: var(--card-height);
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            overflow: hidden;
        }

        body {
            color: var(--ink);
        }

        .card {
            width: var(--card-width);
            height: var(--card-height);
            border: 0.35mm solid var(--line);
            background: linear-gradient(180deg, #ffffff 0%, var(--panel) 100%);
            overflow: hidden;
        }

        .body {
            display: grid;
            grid-template-rows: auto auto 1fr auto;
            gap: 2.1mm;
            height: 100%;
            padding: 3.8mm 4mm;
        }

        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 2.4mm;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 2.6mm;
            min-width: 0;
        }

        .logo-wrap {
            width: 9.8mm;
            height: 9.8mm;
            border: 0.26mm solid var(--line);
            border-radius: 2.6mm;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo {
            width: 7mm;
            height: 7mm;
            object-fit: contain;
        }

        .eyebrow {
            margin: 0;
            font-size: 1.9mm;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .school {
            margin: 0.5mm 0 0;
            font-size: 3.2mm;
            line-height: 1.12;
            font-weight: 700;
            color: var(--ink);
        }

        .meta {
            margin: 0.55mm 0 0;
            font-size: 1.95mm;
            line-height: 1.2;
            color: var(--muted);
        }

        .status {
            flex-shrink: 0;
            border: 0.26mm solid rgba(15, 118, 110, 0.18);
            border-radius: 999px;
            background: #ecfdf5;
            color: #047857;
            font-size: 1.85mm;
            line-height: 1.2;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            padding: 1mm 1.8mm;
            max-width: 22mm;
        }

        .number-box {
            border-radius: 2.2mm;
            background: linear-gradient(180deg, var(--deep) 0%, #102f5c 100%);
            padding: 2.2mm 2.6mm;
            color: #ffffff;
        }

        .label {
            margin: 0;
            font-size: 1.7mm;
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.76);
        }

        .number {
            margin: 0.6mm 0 0;
            font-size: 3.7mm;
            line-height: 1.08;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #ffffff;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8mm 2mm;
            align-content: start;
        }

        .item {
            background: #f8fafc;
            border-radius: 1.9mm;
            padding: 1.8mm 2mm;
            min-width: 0;
        }

        .item.wide {
            grid-column: 1 / -1;
        }

        .item .label {
            color: #64748b;
        }

        .value {
            margin: 0.45mm 0 0;
            font-size: 2.2mm;
            line-height: 1.24;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            gap: 2mm;
            align-items: flex-end;
            font-size: 1.85mm;
            line-height: 1.2;
            font-weight: 700;
            color: var(--muted);
        }

        .controls {
            display: none;
        }

        @media screen {
            html,
            body {
                width: auto;
                height: auto;
                min-height: 100vh;
                overflow: auto;
                background: #eef3f9;
            }

            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 16px;
                padding: 24px;
            }

            .controls {
                display: flex;
                gap: 12px;
            }

            .controls button,
            .controls a {
                border: none;
                border-radius: 999px;
                padding: 12px 18px;
                font-size: 14px;
                font-weight: 700;
                text-decoration: none;
                cursor: pointer;
            }

            .controls button {
                background: #10233d;
                color: #ffffff;
            }

            .controls a {
                background: #ffffff;
                color: #10233d;
                border: 1px solid rgba(16, 35, 61, 0.12);
            }

            .card {
                box-shadow: 0 18px 45px rgba(15, 35, 61, 0.12);
            }
        }
    </style>
</head>
<body>
    <div class="controls">
        <button type="button" onclick="window.print()">Cetak Kartu</button>
        <a href="{{ route('registration.success', $registration['registration_number']) }}">Kembali</a>
    </div>

    <article class="card">
        <div class="body">
            <div class="header">
                <div class="brand">
                    <div class="logo-wrap">
                        <img src="{{ config('spmb.school.logo_url') }}" alt="Logo {{ config('spmb.school.name') }}" class="logo" referrerpolicy="no-referrer">
                    </div>
                    <div>
                        <p class="eyebrow">Kartu Bukti Pendaftaran</p>
                        <p class="school">{{ config('spmb.school.name') }}</p>
                        <p class="meta">{{ config('spmb.school.info') }}</p>
                    </div>
                </div>
                <div class="status">{{ $registration['status_label'] }}</div>
            </div>

            <div class="number-box">
                <p class="label">Nomor Pendaftaran</p>
                <p class="number">{{ $registration['registration_number'] }}</p>
            </div>

            <div class="grid">
                <div class="item wide">
                    <p class="label">Nama Pendaftar</p>
                    <p class="value">{{ $registration['full_name'] }}</p>
                </div>
                <div class="item">
                    <p class="label">Jalur</p>
                    <p class="value">{{ $registration['path_name'] }}</p>
                </div>
                <div class="item">
                    <p class="label">Tanggal</p>
                    <p class="value">{{ $registration['submitted_at_date'] }}</p>
                </div>
            </div>

            <div class="footer">
                <span>Tahun Ajaran {{ $brand['year'] }}</span>
                <span>Simpan kartu ini sebagai bukti pendaftaran.</span>
            </div>
        </div>
    </article>

    <script>
        window.addEventListener('load', () => {
            window.print();
        });
    </script>
</body>
</html>

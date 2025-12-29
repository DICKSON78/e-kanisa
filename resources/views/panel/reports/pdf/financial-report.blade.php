<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ripoti ya Fedha' }} - {{ $settings->company_name ?? 'KKKT Makabe Agape' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 1.5cm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }

        .page-break {
            page-break-after: always;
        }

        /* Header Section */
        .report-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #360958;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 70px;
            height: 70px;
            margin-right: 15px;
        }

        .church-info {
            text-align: center;
        }

        .church-name {
            font-size: 20px;
            font-weight: bold;
            color: #360958;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .church-address {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        .church-contact {
            font-size: 9px;
            color: #888;
            margin-top: 2px;
        }

        /* Report Title */
        .report-title {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: linear-gradient(135deg, #360958 0%, #2a0745 100%);
            color: #fff;
            border-radius: 5px;
        }

        .report-title h1 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-title .period {
            font-size: 11px;
            opacity: 0.9;
        }

        .report-title .generated {
            font-size: 9px;
            opacity: 0.7;
            margin-top: 5px;
        }

        /* Summary Cards */
        .summary-section {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            gap: 15px;
        }

        .summary-card {
            flex: 1;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .summary-card.income {
            background: #e8f5e9;
            border: 1px solid #4caf50;
        }

        .summary-card.expense {
            background: #ffebee;
            border: 1px solid #f44336;
        }

        .summary-card.balance {
            background: #e3f2fd;
            border: 1px solid #2196f3;
        }

        .summary-card .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .summary-card .amount {
            font-size: 16px;
            font-weight: bold;
        }

        .summary-card.income .amount { color: #2e7d32; }
        .summary-card.expense .amount { color: #c62828; }
        .summary-card.balance .amount { color: #1565c0; }

        /* Tables */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #360958;
            margin: 25px 0 10px;
            padding: 8px 12px;
            background: #f5f5f5;
            border-left: 4px solid #360958;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        table thead {
            background: #360958;
            color: #fff;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .amount-positive {
            color: #2e7d32;
            font-weight: 600;
        }

        .amount-negative {
            color: #c62828;
            font-weight: 600;
        }

        .table-total {
            background: #f5f5f5 !important;
            font-weight: bold;
        }

        .table-total td {
            border-top: 2px solid #360958;
            padding: 12px 8px;
        }

        /* Category Section */
        .category-header {
            background: #efc120;
            color: #360958;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 11px;
            margin-top: 15px;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-title {
            font-size: 11px;
            font-weight: bold;
            color: #360958;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature-box {
            width: 30%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 8px;
        }

        .signature-name {
            font-weight: bold;
            font-size: 10px;
        }

        .signature-title-text {
            font-size: 9px;
            color: #666;
        }

        .signature-date {
            font-size: 8px;
            color: #888;
            margin-top: 3px;
        }

        /* Footer */
        .report-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 1.5cm;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #888;
            display: flex;
            justify-content: space-between;
        }

        .footer-left {
            text-align: left;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: right;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(54, 9, 88, 0.05);
            font-weight: bold;
            text-transform: uppercase;
            pointer-events: none;
            z-index: -1;
        }

        /* Print specific styles */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }

        /* Charts placeholder */
        .chart-section {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border: 1px dashed #ddd;
            text-align: center;
            border-radius: 5px;
        }

        .chart-placeholder {
            color: #999;
            font-size: 10px;
        }

        /* Notes section */
        .notes-section {
            margin-top: 25px;
            padding: 15px;
            background: #fff9e6;
            border: 1px solid #efc120;
            border-radius: 5px;
        }

        .notes-title {
            font-weight: bold;
            color: #360958;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .notes-content {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    @if($include_watermark ?? false)
    <div class="watermark">{{ $settings->company_name ?? 'KKKT' }}</div>
    @endif

    <!-- Report Header with Logo -->
    @if($include_header ?? true)
    <div class="report-header">
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="width: 80px; border: none; vertical-align: middle; padding: 0;">
                    @if($include_logo ?? true)
                    <img src="{{ public_path('images/kkkt_logo.png') }}" alt="Logo" class="logo" style="width: 70px; height: 70px;">
                    @endif
                </td>
                <td style="border: none; vertical-align: middle; padding: 0;">
                    <div class="church-info">
                        <div class="church-name">{{ $settings->company_name ?? 'KKKT Makabe Agape' }}</div>
                        <div class="church-address">{{ $settings->address ?? 'Dar es Salaam, Tanzania' }}</div>
                        <div class="church-contact">
                            Simu: {{ $settings->phone ?? '+255 XXX XXX XXX' }} |
                            Email: {{ $settings->email ?? 'info@kkktagape.or.tz' }}
                        </div>
                    </div>
                </td>
                <td style="width: 80px; border: none; padding: 0;"></td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Report Title -->
    <div class="report-title">
        <h1>{{ $title ?? 'Ripoti ya Mapato na Matumizi' }}</h1>
        <div class="period">{{ $period_text ?? 'Kipindi: ' . ($start_date ?? '') . ' - ' . ($end_date ?? '') }}</div>
        <div class="generated">Imetengenezwa: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Summary Section -->
    @if($include_summary ?? true)
    <table style="width: 100%; border: none; margin: 20px 0;">
        <tr>
            <td style="width: 33%; border: none; padding: 5px;">
                <div class="summary-card income">
                    <div class="label">Jumla ya Mapato</div>
                    <div class="amount">TZS {{ number_format($total_income ?? 0, 2) }}</div>
                </div>
            </td>
            <td style="width: 33%; border: none; padding: 5px;">
                <div class="summary-card expense">
                    <div class="label">Jumla ya Matumizi</div>
                    <div class="amount">TZS {{ number_format($total_expense ?? 0, 2) }}</div>
                </div>
            </td>
            <td style="width: 33%; border: none; padding: 5px;">
                <div class="summary-card balance">
                    <div class="label">Salio</div>
                    <div class="amount">TZS {{ number_format(($total_income ?? 0) - ($total_expense ?? 0), 2) }}</div>
                </div>
            </td>
        </tr>
    </table>
    @endif

    <!-- Income Section -->
    @if(isset($income_data) && count($income_data) > 0)
    <div class="section-title">
        <i class="fas fa-arrow-down"></i> Mapato (Michango)
    </div>

    @if($group_by_category ?? true)
        @foreach($income_by_category ?? [] as $category => $items)
        <div class="category-header">{{ $category }}</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 20%;">Tarehe</th>
                    <th style="width: 32%;">Maelezo</th>
                    <th style="width: 20%;">Mchangiaji</th>
                    <th style="width: 20%;" class="text-right">Kiasi (TZS)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td>{{ $item['description'] ?? '-' }}</td>
                    <td>{{ $item['contributor'] ?? '-' }}</td>
                    <td class="text-right amount-positive">{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="table-total">
                    <td colspan="4"><strong>Jumla ya {{ $category }}</strong></td>
                    <td class="text-right amount-positive"><strong>{{ number_format(collect($items)->sum('amount'), 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endforeach
    @else
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 12%;">Tarehe</th>
                <th style="width: 18%;">Kategoria</th>
                <th style="width: 25%;">Maelezo</th>
                <th style="width: 20%;">Mchangiaji</th>
                <th style="width: 20%;" class="text-right">Kiasi (TZS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($income_data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                <td>{{ $item['category'] ?? '-' }}</td>
                <td>{{ $item['description'] ?? '-' }}</td>
                <td>{{ $item['contributor'] ?? '-' }}</td>
                <td class="text-right amount-positive">{{ number_format($item['amount'], 2) }}</td>
            </tr>
            @endforeach
            @if($include_totals ?? true)
            <tr class="table-total">
                <td colspan="5"><strong>Jumla ya Mapato</strong></td>
                <td class="text-right amount-positive"><strong>{{ number_format($total_income ?? 0, 2) }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
    @endif

    <!-- Expense Section -->
    @if(isset($expense_data) && count($expense_data) > 0)
    <div class="section-title">
        <i class="fas fa-arrow-up"></i> Matumizi
    </div>

    @if($group_by_category ?? true)
        @foreach($expense_by_category ?? [] as $category => $items)
        <div class="category-header">{{ $category }}</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 20%;">Tarehe</th>
                    <th style="width: 42%;">Maelezo</th>
                    <th style="width: 30%;" class="text-right">Kiasi (TZS)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td>{{ $item['description'] ?? '-' }}</td>
                    <td class="text-right amount-negative">{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="table-total">
                    <td colspan="3"><strong>Jumla ya {{ $category }}</strong></td>
                    <td class="text-right amount-negative"><strong>{{ number_format(collect($items)->sum('amount'), 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endforeach
    @else
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Tarehe</th>
                <th style="width: 20%;">Kategoria</th>
                <th style="width: 40%;">Maelezo</th>
                <th style="width: 20%;" class="text-right">Kiasi (TZS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expense_data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                <td>{{ $item['category'] ?? '-' }}</td>
                <td>{{ $item['description'] ?? '-' }}</td>
                <td class="text-right amount-negative">{{ number_format($item['amount'], 2) }}</td>
            </tr>
            @endforeach
            @if($include_totals ?? true)
            <tr class="table-total">
                <td colspan="4"><strong>Jumla ya Matumizi</strong></td>
                <td class="text-right amount-negative"><strong>{{ number_format($total_expense ?? 0, 2) }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
    @endif

    <!-- Final Summary -->
    @if($include_summary ?? true)
    <table style="width: 50%; margin: 30px auto; border: 2px solid #360958;">
        <thead>
            <tr style="background: #360958; color: #fff;">
                <th colspan="2" style="text-align: center; padding: 12px;">MUHTASARI WA MWISHO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 10px; font-weight: bold;">Jumla ya Mapato</td>
                <td style="padding: 10px; text-align: right;" class="amount-positive">TZS {{ number_format($total_income ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold;">Jumla ya Matumizi</td>
                <td style="padding: 10px; text-align: right;" class="amount-negative">TZS {{ number_format($total_expense ?? 0, 2) }}</td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 12px; font-weight: bold; font-size: 12px;">SALIO</td>
                <td style="padding: 12px; text-align: right; font-weight: bold; font-size: 14px; color: {{ ($total_income ?? 0) - ($total_expense ?? 0) >= 0 ? '#2e7d32' : '#c62828' }};">
                    TZS {{ number_format(($total_income ?? 0) - ($total_expense ?? 0), 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    @endif

    <!-- Notes Section -->
    @if(isset($notes) && $notes)
    <div class="notes-section">
        <div class="notes-title">Maelezo Mengine:</div>
        <div class="notes-content">{{ $notes }}</div>
    </div>
    @endif

    <!-- Signature Section -->
    @if($include_signature ?? false)
    <div class="signature-section">
        <div class="signature-title">Thibitisho la Ripoti</div>
        <table style="width: 100%; border: none; margin-top: 30px;">
            <tr>
                <td style="width: 33%; border: none; text-align: center; padding: 0 15px;">
                    <div class="signature-box">
                        <div class="signature-line">
                            <div class="signature-name">{{ $preparer_name ?? '________________________' }}</div>
                            <div class="signature-title-text">Mhasibu</div>
                            <div class="signature-date">Tarehe: _______________</div>
                        </div>
                    </div>
                </td>
                <td style="width: 33%; border: none; text-align: center; padding: 0 15px;">
                    <div class="signature-box">
                        <div class="signature-line">
                            <div class="signature-name">{{ $reviewer_name ?? '________________________' }}</div>
                            <div class="signature-title-text">Mwenyekiti wa Fedha</div>
                            <div class="signature-date">Tarehe: _______________</div>
                        </div>
                    </div>
                </td>
                <td style="width: 33%; border: none; text-align: center; padding: 0 15px;">
                    <div class="signature-box">
                        <div class="signature-line">
                            <div class="signature-name">{{ $approver_name ?? '________________________' }}</div>
                            <div class="signature-title-text">Mchungaji Mkuu</div>
                            <div class="signature-date">Tarehe: _______________</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="report-footer">
        <div class="footer-left">{{ $settings->company_name ?? 'KKKT Makabe Agape' }}</div>
        <div class="footer-center">Ripoti imetengenezwa na Mfumo wa Kanisa</div>
        <div class="footer-right">Ukurasa wa <span class="page-number"></span></div>
    </div>
</body>
</html>

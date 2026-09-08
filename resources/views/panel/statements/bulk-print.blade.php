<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taarifa za Mwaka - Zote - {{ $year }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            padding: 2rem;
        }

        /* Header with Logo */
        .report-header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header-left {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
        }

        .header-center {
            display: table-cell;
            width: 70%;
            vertical-align: middle;
            text-align: center;
        }

        .header-right {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
        }

        .church-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .church-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .church-address {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .church-contact {
            font-size: 10px;
        }

        /* Report Title */
        .report-title {
            text-align: center;
            margin: 25px 0;
            padding: 15px;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }

        .report-title h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .report-period {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .report-date {
            font-size: 10px;
            color: #666;
        }

        /* Member Statement Wrapper */
        .statement-wrapper {
            page-break-inside: avoid;
            margin-bottom: 10px;
        }

        /* Member Info Section */
        .member-info {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }

        .member-info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            background: #360958;
            color: white;
            padding: 8px;
        }

        .member-details {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .member-detail {
            flex: 1;
            min-width: 200px;
            padding: 5px 0;
        }

        .member-detail strong {
            display: inline-block;
            min-width: 100px;
        }

        /* Total Card */
        .total-card {
            margin: 20px 0;
            padding: 15px;
            background: #360958;
            color: white;
            text-align: center;
            border-radius: 4px;
        }

        .total-card .label {
            font-size: 12px;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        .total-card .amount {
            font-size: 20px;
            font-weight: bold;
        }

        /* Table Styles */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            text-align: center;
            background: #360958;
            color: white;
            padding: 8px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th {
            background: #360958;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #000;
            font-size: 10px;
        }

        .data-table td {
            padding: 6px 8px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .total-row {
            background: #e0e0e0 !important;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #000;
        }

        .amount {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        /* Statement Separator */
        .statement-separator {
            border-top: 3px double #360958;
            margin: 30px 0;
        }

        /* Grand Summary */
        .grand-summary {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border: 2px solid #360958;
        }

        .grand-summary-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            background: #360958;
            color: white;
            padding: 10px;
        }

        .grand-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }

        .grand-summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            background: #e0e0e0;
            margin-top: 5px;
            padding: 10px 5px;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 10px;
        }

        /* Footer */
        .report-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }

            .statement-wrapper {
                page-break-after: auto;
            }
        }

        /* Print Button */
        .print-actions {
            margin: 20px 0;
            text-align: center;
            padding: 15px;
            background: #f0f0f0;
            border: 1px solid #ddd;
        }

        .print-btn {
            background: #360958;
            color: white;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 5px;
        }

        .print-btn:hover {
            background: #2a0745;
        }

        .print-btn.secondary {
            background: #6b7280;
        }

        .print-btn.secondary:hover {
            background: #4b5563;
        }
    </style>
</head>
<body>
    <!-- Print Actions (hidden when printing) -->
    <div class="print-actions no-print">
        <button class="print-btn" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm7 5H4v7h8V8z"/>
            </svg>
            Print Zote ({{ $members->count() }} Taarifa)
        </button>
        <button class="print-btn secondary" onclick="window.close()">
            Funga
        </button>
    </div>

    <!-- Header Section -->
    <div class="report-header">
        <div class="header-left">
            @if(file_exists(public_path('images/roc_logo.jpeg')))
                <img src="{{ asset('images/roc_logo.jpeg') }}" alt="Church Logo" class="church-logo">
            @endif
        </div>
        <div class="header-center">
            <div class="church-name">ROC [REALITY OF CHRIST]</div>
            <div class="church-address">S.L.P 123, Makabe, Arusha</div>
            <div class="church-contact">Simu: +255 123 456 789 | Barua pepe: info@roc.or.tz</div>
        </div>
        <div class="header-right"></div>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h1>TAARIFA ZA MWAKA ZA MICHANGO</h1>
        <div class="report-period">Mwaka: {{ $year }}</div>
        <div class="report-date">Jumla ya taarifa: {{ $members->count() }} | Imetengenezwa: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Grand Summary -->
    <div class="grand-summary">
        <div class="grand-summary-title">MUHTASARI WA JUMLA</div>
        @php
            $grandTotal = 0;
            $totalMembers = 0;
            foreach($members as $m) {
                $grandTotal += $m['total'] ?? 0;
                $totalMembers++;
            }
        @endphp
        <div class="grand-summary-row">
            <span>Jumla ya Waumini:</span>
            <span>{{ $totalMembers }} waumini</span>
        </div>
        <div class="grand-summary-row">
            <span>Jumla ya Michango:</span>
            <span>{{ number_format($grandTotal, 0) }} TZS</span>
        </div>
    </div>

    <!-- Individual Member Statements -->
    @foreach($members as $m)
    <div class="statement-wrapper" @if(!$loop->first) style="page-break-before: always;" @endif>
        <!-- Member Info Section -->
        <div class="member-info">
            <div class="member-info-title">TAARIFA ZA MUUMINI</div>
            <div class="member-details">
                <div class="member-detail">
                    <strong>Jina:</strong> {{ $m['member']->first_name }} {{ $m['member']->middle_name ?? '' }} {{ $m['member']->last_name }}
                </div>
                <div class="member-detail">
                    <strong>Namba:</strong> {{ $m['member']->member_number }}
                </div>
                <div class="member-detail">
                    <strong>Simu:</strong> {{ $m['member']->phone }}
                </div>
                <div class="member-detail">
                    <strong>Email:</strong> {{ $m['member']->email ?? '-' }}
                </div>
            </div>
        </div>

        <!-- Total Giving Card -->
        <div class="total-card">
            <div class="label">JUMLA YA MICHANGO MWAKA {{ $year }}</div>
            <div class="amount">{{ number_format($m['total'] ?? 0, 0) }} TZS</div>
        </div>

        <!-- Contributions by Category -->
        @forelse($m['byCategory'] as $category => $details)
        <div class="section-title">{{ strtoupper($category) }}</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Tarehe</th>
                    <th width="20%">Kiasi (TZS)</th>
                    <th width="25%">Namba ya Risiti</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details['items'] as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->collection_date)->format('d/m/Y') }}</td>
                    <td class="amount">{{ number_format($item->amount, 0) }}</td>
                    <td>{{ $item->receipt_number ?? '-' }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2" align="right"><strong>JUMLA YA {{ strtoupper($category) }}:</strong></td>
                    <td class="amount">{{ number_format($details['total'], 0) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @empty
        <div class="section-title">HAKUNA MICHANGO</div>
        <p style="text-align: center; padding: 20px; color: #666;">Muumini hana michango kwa mwaka {{ $year }}</p>
        @endforelse

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Sahi ya Muumini</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Sahi ya Mchungaji</div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Final Footer -->
    <div class="report-footer">
        <p>Taarifa zote zimetengenezwa kiotomatiki kwaajili ya matumizi ya ndani | {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <script>
        window.onload = function() {
            if (new URLSearchParams(window.location.search).has('auto_print')) {
                window.print();
            }
        };
    </script>
</body>
</html>

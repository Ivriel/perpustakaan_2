<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman #{{ $loan->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: #fff;
            padding: 30px;
        }

        .receipt {
            max-width: 540px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .receipt-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .receipt-title h2 {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 20px;
            background: #f5f5f5;
            display: inline-block;
            border-radius: 4px;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 25px;
        }

        .info-section h3 {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 140px;
            padding: 5px 0;
            font-weight: 600;
            color: #555;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
            color: #333;
        }

        /* Status Badge */
        .status {
            display: inline-block;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 3px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-borrowed {
            background: #cce5ff;
            color: #004085;
        }

        .status-returned {
            background: #d4edda;
            color: #155724;
        }

        .status-overdue {
            background: #f8d7da;
            color: #721c24;
        }

        /* Table */
        .book-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .book-table th {
            background: #333;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 8px;
            text-align: left;
        }

        .book-table th:first-child {
            border-radius: 4px 0 0 0;
        }

        .book-table th:last-child {
            border-radius: 0 4px 0 0;
            text-align: center;
            width: 60px;
        }

        .book-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .book-table tr:last-child td {
            border-bottom: none;
        }

        .book-table tr:nth-child(even) {
            background: #fafafa;
        }

        .book-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .book-author {
            font-size: 10px;
            color: #666;
        }

        .book-code {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #666;
        }

        .book-category {
            font-size: 9px;
            color: #888;
            font-style: italic;
        }

        .book-condition {
            text-align: center;
            font-size: 10px;
            text-transform: capitalize;
        }

        /* Summary */
        .summary {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 5px 0;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
        }

        .summary-row.total {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: 700;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }

        .signature-area {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        .signature-box p {
            font-size: 10px;
            color: #666;
            margin-bottom: 50px;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 10px;
            font-weight: 600;
        }

        .print-info {
            text-align: center;
            font-size: 9px;
            color: #999;
            margin-top: 25px;
        }

        .notes {
            background: #fffef0;
            border: 1px solid #f0e68c;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .notes h4 {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 8px;
        }

        .notes ul {
            margin-left: 15px;
            font-size: 10px;
            color: #555;
        }

        .notes li {
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <h1>Perpustakaan</h1>
            <p>Sistem Manajemen Perpustakaan Digital</p>
        </div>

        <div class="receipt-title">
            <h2>Bukti Peminjaman Buku</h2>
        </div>

        <div class="info-section">
            <h3>Informasi Peminjaman</h3>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">No. Peminjaman</span>
                    <span class="info-value"><strong>#{{ $loan->id }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="status status-{{ $loan->status }}">{{ $loan->status }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pinjam</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jatuh Tempo</span>
                    <span
                        class="info-value"><strong>{{ \Carbon\Carbon::parse($loan->due_date)->format('d F Y') }}</strong></span>
                </div>
                @if($loan->return_date)
                    <div class="info-row">
                        <span class="info-label">Tanggal Kembali</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($loan->return_date)->format('d F Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="info-section">
            <h3>Data Peminjam</h3>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value"><strong>{{ $loan->user->name }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $loan->user->email }}</span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Daftar Buku Dipinjam</h3>
            <table class="book-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Detail Buku</th>
                        <th>Kode</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->details as $index => $detail)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>
                                <div class="book-title">{{ $detail->book->title }}</div>
                                <div class="book-author">oleh {{ $detail->book->author }}</div>
                                <div class="book-category">
                                    @if($detail->book->categories->count() > 0)
                                        {{ $detail->book->categories->pluck('name')->join(', ') }}
                                    @else
                                        Tanpa Kategori
                                    @endif
                                </div>
                            </td>
                            <td class="book-code">{{ $detail->book->book_code }}</td>
                            <td class="book-condition">{{ $detail->condition }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="summary">
            <div class="summary-row">
                <span class="summary-label">Total Buku Dipinjam</span>
                <span class="summary-value"><strong>{{ $loan->details->count() }} buku</strong></span>
            </div>
            @if($loan->fine_amount > 0)
                <div class="summary-row total">
                    <span class="summary-label">Denda</span>
                    <span class="summary-value" style="color: #c00;"><strong>Rp
                            {{ number_format($loan->fine_amount, 0, ',', '.') }}</strong></span>
                </div>
            @endif
        </div>

        <div class="notes">
            <h4>Ketentuan Peminjaman</h4>
            <ul>
                <li>Buku harus dikembalikan sebelum tanggal jatuh tempo.</li>
                <li>Keterlambatan pengembalian akan dikenakan denda.</li>
                <li>Kerusakan atau kehilangan buku menjadi tanggung jawab peminjam.</li>
                <li>Bukti ini wajib dibawa saat pengembalian buku.</li>
            </ul>
        </div>

        <div class="footer">
            <div class="signature-area">
                <div class="signature-box">
                    <p>Peminjam</p>
                    <div class="signature-line">{{ $loan->user->name }}</div>
                </div>
                <div class="signature-box">
                    <p>Petugas Perpustakaan</p>
                    <div class="signature-line">( ............................ )</div>
                </div>
            </div>
        </div>

        <div class="print-info">
            Dicetak pada: {{ $tanggal_dicetak }} | Dokumen ini digenerate secara otomatis oleh sistem.
        </div>
    </div>
</body>

</html>
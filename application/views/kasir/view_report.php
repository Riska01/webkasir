<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        h1{
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
        }
        h3 {
            color: #343a40;
            margin-bottom: 20px;
        }
        p {
            color: #495057;
        }
        .report-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .report-container p {
            margin: 0 0 10px;
        }
        .rice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .rice-table th, .rice-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .rice-table th {
            background-color: #e9ecef;
            color: #495057;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button-container .back-button {
            background-color: #219C90;
            color: #ffffff;
        }
        .button-container .back-button:hover {
            background-color: #1A7C73;
        }
        .button-container .print-button {
            background-color: #FFC700;
            color: #ffffff;
        }
        .button-container .print-button:hover {
            background-color: #D8A600;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <h1>Laporan Penjualan</h1>
        <?php if ($sales_report): ?>
            <p><strong>Tanggal Laporan:</strong> <?php echo $sales_report->report_date; ?></p>
            <p><strong>Total Pemasukan:</strong> <?php echo $sales_report->total_income; ?></p>
            <h3>Beras Yang Terjual:</h3>
            <table class="rice-table">
                <thead>
                    <tr>
                        <th>Nama Beras</th>
                        <th>Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rice_sold = json_decode($sales_report->rice_sold, true);
                    foreach ($rice_sold as $rice) {
                        echo '<tr>';
                        echo '<td>' . $rice['rice_name'] . '</td>';
                        echo '<td>' . $rice['total_quantity'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada laporan penjualan tersedia.</p>
        <?php endif; ?>
        <div class="button-container">
            <button class="back-button" onclick="window.history.back()">Kembali</button>
            <button class="print-button" onclick="window.print()">Cetak Laporan</button>
        </div>
    </div>
</body>
</html>
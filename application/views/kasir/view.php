<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #343a40;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #219C90;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #1A7C73;
        }
    </style>
</head>
<body>
    <h1>Detail Transaksi</h1>
    <table>
        <tr>
            <th>ID Transaksi</th>
            <td><?php echo $transaction->transaction_id; ?></td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td><?php echo $transaction->customer_name; ?></td>
        </tr>
            <th>No WA Pelanggan</th>
                <td><?php echo $transaction->notelp_pelanggan; ?></td>
            </tr>
        <tr>
            <th>Alamat Pelanggan</th>
            <td><?php echo $transaction->customer_address; ?></td>
        </tr>
        <tr>
            <th>Tanggal Pesan</th>
            <td><?php echo $transaction->order_date; ?></td>
        </tr>
        <tr>
            <th>Tanggal Kirim</th>
            <td><?php echo $transaction->delivery_date; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo $transaction->status; ?></td>
        </tr>
    </table>
    
    <h2>Beras yang Dipesan:</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Beras</th>
                <th>Nama Beras</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalKeseluruhan = 0;
            if (!empty($transaction->items)): ?>
                <?php foreach ($transaction->items as $item): 
                    $totalItem = $item->price * $item->quantity;
                    $totalKeseluruhan += $totalItem;
                ?>
                <tr>
                    <td><?php echo $item->rice_code; ?></td>
                    <td><?php echo $item->rice_name; ?></td>
                    <td><?php echo $item->price; ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td><?php echo $totalItem; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada barang yang dipesan</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Keseluruhan</th>
                <th><?php echo $totalKeseluruhan; ?></th>
            </tr>
            <tr>
                <th colspan="4">Uang Dibayar</th>
                <th><?php echo $transaction->amount_paid; ?></th>
            </tr>
            <tr>
                <th colspan="4">Kembalian</th>
                <th><?php echo $transaction->amount_paid - $totalKeseluruhan; ?></th>
            </tr>
        </tfoot>
    </table>
    <a class="btn-back" href="<?php echo site_url('kasir'); ?>">Kembali ke Halaman Awal</a>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>List Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: none;
        }
        .btn-create {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #219C90;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-create:hover {
            background-color: #1A7C73;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        .actions a {
            margin-right: 10px;
            padding: 10px 20px;
            border-radius: 3px;
            transition: background-color 0.3s ease;
            color: white;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .actions a.view, .actions a.edit, .actions a.receipt {
            background-color: #219C90;
        }
        .actions a.view:hover, .actions a.edit:hover, .actions a.receipt:hover {
            background-color: #1A7C73;
        }
        .actions a.delete {
            background-color: #EE4E4E;
        }
        .actions a.delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>List Pesanan Agen Beras Jaya 2</h1>
    <a class="btn-create" href="<?php echo site_url('kasir/create'); ?>">Buat Pesanan Baru</a>
    <a class="btn-create" href="<?php echo site_url('kasir/view_report'); ?>">Lihat Laporan</a>
    <table>
        <thead>
            <tr>
                <th>Id Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Alamat Pelanggan</th>
                <th>Tanggal Pesan</th>
                <th>Tanggal Kirim</th>
                <th>Status Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo $transaction->transaction_id; ?></td>
                <td><?php echo $transaction->customer_name; ?></td>
                <td><?php echo $transaction->customer_address; ?></td>
                <td><?php echo $transaction->order_date; ?></td>
                <td><?php echo $transaction->delivery_date; ?></td>
                <td><?php echo $transaction->status; ?></td>
                <td class="actions">
                    <a class="view" href="<?php echo site_url('kasir/view/' . $transaction->id); ?>">Lihat</a>
                    <a class="edit" href="<?php echo site_url('kasir/edit/' . $transaction->id); ?>">Edit</a>
                    <a class="delete" href="<?php echo site_url('kasir/delete/' . $transaction->id); ?>">Hapus</a>
                    <a class="receipt" href="<?php echo site_url('kasir/receipt/' . $transaction->id); ?>">Struk</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

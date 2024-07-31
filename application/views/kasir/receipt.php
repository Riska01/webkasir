<!DOCTYPE html>
<html>
<head>
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            margin: 0;
            font-size: 24px;
            color: #343a40;
        }
        .receipt-details, .receipt-items {
            margin-bottom: 20px;
        }
        .receipt-details p {
            margin: 5px 0;
            color: #333;
            font-size: 14px;
        }
        .receipt-items h2 {
            font-size: 18px;
            color: #343a40;
            margin-bottom: 10px;
        }
        .receipt-items table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .receipt-items table, .receipt-items th, .receipt-items td {
            border: 1px solid #ddd;
        }
        .receipt-items th, .receipt-items td {
            padding: 10px;
            text-align: left;
        }
        .receipt-items th {
            background-color: #f2f2f2;
        }
        .receipt-total {
            text-align: right;
            font-weight: bold;
            padding-top: 10px;
            font-size: 14px;
        }
        .btn-back, .btn-print {
            display: block;
            width: 100%;
            padding: 10px 0;
            background-color: #219C90;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
            font-size: 14px;
        }
        .btn-back:hover, .btn-print:hover {
            background-color: #1A7C73;
        }
        .thank-you {
            text-align: center;
            font-style: italic;
            margin-top: 20px;
            color: #343a40;
            font-size: 14px;
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            function loadReceiptData(transactionId) {
            $.ajax({
                url: '<?php echo site_url('kasir/receipt'); ?>/' + transactionId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#transactionId').text(data.transaction_id);
                    $('#customerName').text(data.customer_name);
                    $('#customerAddress').text(data.customer_address);
                    $('#customerPhone').text(data.notelp_pelanggan); 
                    $('#orderDate').text(data.order_date);
                    $('#deliveryDate').text(data.delivery_date);
                    $('#status').text(data.status);
                    
                    var itemsHtml = '';
                    $.each(data.items, function(index, item) {
                        itemsHtml += '<tr>';
                        itemsHtml += '<td>' + item.rice_name + '</td>';
                        itemsHtml += '<td>' + item.price + '</td>';
                        itemsHtml += '<td>' + item.quantity + '</td>';
                        itemsHtml += '<td>' + (item.price * item.quantity) + '</td>';
                        itemsHtml += '</tr>';
                    });
                    $('#itemsTable tbody').html(itemsHtml);
                    
                    $('#totalKeseluruhan').text(data.totalKeseluruhan);
                    $('#amountPaid').text(data.amount_paid);
                    $('#change').text(data.amount_paid - data.totalKeseluruhan);
                },
                error: function() {
                    alert('Gagal memuat data struk. Silakan coba lagi.');
                }
            });
        }
           
            var transactionId = <?php echo $transaction->id; ?>;
            loadReceiptData(transactionId);
        
            $('#printReceipt').on('click', function() {
                window.print();
            });
        });
    </script>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Agen Beras Jaya 2</h1>
        </div>
        <div class="receipt-details">
        <p>Id Transaksi: <span id="transactionId"></span></p>
        <p>Nama Pelanggan: <span id="customerName"></span></p>
        <p>Alamat: <span id="customerAddress"></span></p>
        <p>Nomor Telepon: <span id="customerPhone"></span></p> 
        <p>Tanggal Pesan: <span id="orderDate"></span></p>
        <p>Tanggal Kirim: <span id="deliveryDate"></span></p>
        <p>Status: <span id="status"></span></p>
        </div>
        <div class="receipt-items">
            <h2> </h2>
            <table id="itemsTable">
                <thead>
                    <tr>
                        <th>Nama Beras</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Keseluruhan</th>
                        <td id="totalKeseluruhan"></td>
                    </tr>
                    <tr>
                        <th colspan="3">Bayar</th>
                        <td id="amountPaid"></td>
                    </tr>
                    <tr>
                        <th colspan="3">Kembalian</th>
                        <td id="change"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <p class="thank-you">Terimakasih Telah Berbelanja di Agen Beras Jaya 2</p>
        <a class="btn-back" href="<?php echo site_url('kasir'); ?>">Kembali</a>
        <button class="btn-print" id="printReceipt">Cetak</button>
    </div>
</body>
</html>

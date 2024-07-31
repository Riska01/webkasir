<!DOCTYPE html>
<html>
<head>
    <title>Buat Pesanan Baru</title>
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
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="number"], textarea, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        .item {
            margin-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
        }
        .item:last-child {
            border-bottom: none;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"] {
            background-color: #219C90;
            color: white;
        }
        button[type="submit"]:hover {
            background-color: #1A7C73;
        }
        button[type="button"] {
            background-color: #FFC700;
            color: white;
        }
        button[type="button"]:hover {
            background-color: #D8A600;
        }
        .back-button {
            background-color: #6c757d;
            color: white;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Buat Pesanan Baru</h1>
    <form action="<?php echo site_url('kasir/store'); ?>" method="post">
        <label>Id Transaksi</label>
        <input type="text" name="transaction_id" required>
        <label>Id Pelanggan</label>
        <input type="text" name="customer_id" required>
        <label>Nama Pelanggan</label>
        <input type="text" name="customer_name" required>
        <label>No WA Pelanggan</label>
        <input type="text" name="notelp_pelanggan" required>
        <label>Alamat Pelanggan</label>
        <textarea name="customer_address" required></textarea>
        <label>Tanggal Pesan</label>
        <input type="date" name="order_date" required>
        <label>Tanggal Kirim</label>
        <input type="date" name="delivery_date" required>
        <label>Status Pesanan</label>
        <select name="status" required>
            <option value="Pending">Tertunda</option>
            <option value="Delivered">Terkirim</option>
        </select>

        <h2>Beras yang Ingin Dipesan:</h2>
        <div id="items">
            <div class="item">
                <label>Kode Beras</label>
                <select name="items[0][rice_code]" onchange="updateRiceDetails(this)">
                    <option value="">Pilih Kode Beras</option>
                    <option value="BR001">BR001 - Beras Ekonomis Rojolele 5 KG</option>
                    <option value="BR002">BR002 - Beras Super Rojolele 5 KG</option>
                    <option value="BR003">BR003 - Beras Rojolele Pulen 10 KG</option>
                    <option value="BR004">BR004 - Beras Super Rojolele 10 KG</option>
                    <option value="BR005">BR005 - Beras Super Rojolele 20 KG</option>
                    <option value="BR006">BR006 - Beras Super Rojolele 25 KG</option>
                </select>
                <label>Nama Beras</label>
                <input type="text" name="items[0][rice_name]" readonly>
                <label>Harga</label>
                <input type="text" name="items[0][price]" readonly>
                <label>Jumlah</label>
                <input type="number" name="items[0][quantity]" required oninput="calculateTotal(this)">
                <label>Total</label>
                <input type="text" name="items[0][total]" readonly>
            </div>
        </div>
        <button type="button" onclick="addItem()">Tambah Item</button>
        
        <div style="text-align: right; margin-top: 20px;">
            <label>Total Keseluruhan</label>
            <input type="text" id="totalKeseluruhan" name="totalKeseluruhan" readonly>
        </div>
        <div style="text-align: right; margin-top: 20px;">
            <label>Bayar</label>
            <input type="number" id="amount_paid" name="amount_paid" required oninput="calculateChange()">
        </div>
        <div style="text-align: right; margin-top: 20px;">
            <label>Kembalian</label>
            <input type="text" id="change" name="change" readonly>
        </div>
        <button type="submit">Simpan</button>
        <button type="button" class="back-button" onclick="window.location.href='<?php echo site_url('kasir/index'); ?>'">Kembali</button>
    </form>

    <script>
        var itemIndex = 1;
        var ricePrices = {
            'BR001': { 'name': 'Beras Ekonomis Rojolele 5 KG', 'price': 76000 },
            'BR002': { 'name': 'Beras Super Rojolele 5 KG', 'price': 95000 },
            'BR003': { 'name': 'Beras Rojolele Pulen 10 KG', 'price': 145000 },
            'BR004': { 'name': 'Beras Super Rojolele 10 KG', 'price': 180000 },
            'BR005': { 'name': 'Beras Super Rojolele 20 KG', 'price': 330000 },
            'BR006': { 'name': 'Beras Super Rojolele 25 KG', 'price': 390000 }
        };

        function updateRiceDetails(selectElement) {
            var riceCode = selectElement.value;
            var itemDiv = selectElement.parentElement;
            if (ricePrices[riceCode]) {
                itemDiv.querySelector('input[name*="[rice_name]"]').value = ricePrices[riceCode].name;
                itemDiv.querySelector('input[name*="[price]"]').value = ricePrices[riceCode].price;
            } else {
                itemDiv.querySelector('input[name*="[rice_name]"]').value = '';
                itemDiv.querySelector('input[name*="[price]"]').value = '';
            }
            calculateTotal(itemDiv.querySelector('input[name*="[quantity]"]'));
        }

        function calculateTotal(quantityInput) {
            var itemDiv = quantityInput.parentElement;
            var price = parseFloat(itemDiv.querySelector('input[name*="[price]"]').value) || 0;
            var quantity = parseFloat(quantityInput.value) || 0;
            var total = price * quantity;
            itemDiv.querySelector('input[name*="[total]"]').value = total;
            calculateOverallTotal();
        }

        function calculateOverallTotal() {
            var itemsDiv = document.getElementById('items');
            var itemDivs = itemsDiv.getElementsByClassName('item');
            var overallTotal = 0;
            for (var i = 0; i < itemDivs.length; i++) {
                var total = parseFloat(itemDivs[i].querySelector('input[name*="[total]"]').value) || 0;
                overallTotal += total;
            }
            document.getElementById('totalKeseluruhan').value = overallTotal;
            calculateChange();
        }

        function calculateChange() {
            var totalKeseluruhan = parseFloat(document.getElementById('totalKeseluruhan').value) || 0;
            var amount_paid = parseFloat(document.getElementById('amount_paid').value) || 0;
            var change = amount_paid - totalKeseluruhan;
            document.getElementById('change').value = change;
        }

        function addItem() {
            var itemsDiv = document.getElementById('items');
            var newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.innerHTML = `
                <label>Kode Beras</label>
                <select name="items[${itemIndex}][rice_code]" onchange="updateRiceDetails(this)">
                    <option value="">Pilih Kode Beras</option>
                    <option value="BR001">BR001 - Beras Ekonomis Rojolele 5 KG</option>
                    <option value="BR002">BR002 - Beras Super Rojolele 5 KG</option>
                    <option value="BR003">BR003 - Beras Rojolele Pulen 10 KG</option>
                    <option value="BR004">BR004 - Beras Super Rojolele 10 KG</option>
                    <option value="BR005">BR005 - Beras Super Rojolele 20 KG</option>
                    <option value="BR006">BR006 - Beras Super Rojolele 25 KG</option>
                </select>
                <label>Nama Beras</label>
                <input type="text" name="items[${itemIndex}][rice_name]" readonly>
                <label>Harga</label>
                <input type="text" name="items[${itemIndex}][price]" readonly>
                <label>Jumlah</label>
                <input type="number" name="items[${itemIndex}][quantity]" required oninput="calculateTotal(this)">
                <label>Total</label>
                <input type="text" name="items[${itemIndex}][total]" readonly>
            `;
            itemsDiv.appendChild(newItem);
            itemIndex++;
        }
    </script>
</body>
</html>

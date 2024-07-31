<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesanan</title>
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
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        h2 {
            margin-top: 20px;
            color: #343a40;
            padding-bottom: 5px;
            text-align: center;
        }
        .item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
        .item label {
            margin-top: 0;
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
    <h1>Edit Transaksi</h1>
    <form action="<?php echo site_url('kasir/update/' . $transaction->id); ?>" method="post">
        <label>Id Transaksi</label>
        <input type="text" name="transaction_id" value="<?php echo $transaction->transaction_id; ?>" readonly>
        
        <label>Id Pelanggan</label>
        <input type="text" name="customer_id" value="<?php echo $transaction->customer_id; ?>" required>
        
        <label>Nama Pelanggan</label>
        <input type="text" name="customer_name" value="<?php echo $transaction->customer_name; ?>" required>
        
        <label>No WA Pelanggan</label>
        <input type="text" name="notelp_pelanggan" value="<?php echo $transaction->notelp_pelanggan; ?>" required>

        <label>Alamat Pelanggan</label>
        <textarea name="customer_address" required><?php echo $transaction->customer_address; ?></textarea>
        
        <label>Tanggal Pesan</label>
        <input type="date" name="order_date" value="<?php echo $transaction->order_date; ?>" required>
        
        <label>Tanggal Kirim</label>
        <input type="date" name="delivery_date" value="<?php echo $transaction->delivery_date; ?>" required>
        
        <label>Status</label>
        <select name="status" required>
            <option value="Pending" <?php echo $transaction->status == 'Pending' ? 'selected' : ''; ?>>Tertunda</option>
            <option value="Delivered" <?php echo $transaction->status == 'Delivered' ? 'selected' : ''; ?>>Terkirim</option>
        </select>

        <label>Uang yang Diterima</label>
        <input type="number" name="amount_paid" value="<?php echo $transaction->amount_paid; ?>" required>

        <h2>Beras yang Dipesan:</h2>
        <div id="items">
            <?php foreach ($transaction->items as $index => $item): ?>
            <div class="item">
                <label>Kode Beras</label>
                <select name="items[<?php echo $index; ?>][rice_code]" onchange="updateRiceDetails(this)">
                    <option value="">Pilih Kode Beras</option>
                    <?php
                    foreach($berases as $beras){
                        echo "<option value='".$beras['id']."'". ($item->rice_code == $beras['id'] ? ' selected' : '') ."> ".$beras['text']."</option>";
                    }
                    ?>
                    <!-- <option value="BR001" <?php echo $item->rice_code == 'BR001' ? 'selected' : ''; ?>>BR001 - Beras Ekonomis Rojolele 5 KG</option>
                    <option value="BR002" <?php echo $item->rice_code == 'BR002' ? 'selected' : ''; ?>>BR002 - Beras Super Rojolele 5 KG</option>
                    <option value="BR003" <?php echo $item->rice_code == 'BR003' ? 'selected' : ''; ?>>BR003 - Beras Rojolele Pulen 10 KG</option>
                    <option value="BR004" <?php echo $item->rice_code == 'BR004' ? 'selected' : ''; ?>>BR004 - Beras Super Rojolele 10 KG</option>
                    <option value="BR005" <?php echo $item->rice_code == 'BR005' ? 'selected' : ''; ?>>BR005 - Beras Super Rojolele 20 KG</option>
                    <option value="BR006" <?php echo $item->rice_code == 'BR006' ? 'selected' : ''; ?>>BR006 - Beras Super Rojolele 25 KG</option> -->
                </select>
                <label>Nama Beras</label>
                <input type="text" name="items[<?php echo $index; ?>][rice_name]" value="<?php echo $item->rice_name; ?>" readonly>
                <label>Harga</label>
                <input type="number" name="items[<?php echo $index; ?>][price]" value="<?php echo $item->price; ?>" readonly>
                <label>Jumlah</label>
                <input type="number" name="items[<?php echo $index; ?>][quantity]" value="<?php echo $item->quantity; ?>" required oninput="calculateTotal(this)">
                <label>Total</label>
                <input type="number" name="items[<?php echo $index; ?>][total]" value="<?php echo $item->price * $item->quantity; ?>" readonly>
            </div>
            <?php endforeach; ?>
        </div>

        <button type="submit">Simpan</button>
        <button type="button" class="back-button" onclick="window.location.href='<?php echo site_url('kasir/index'); ?>'">Kembali</button>
    </form>

    <script>
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

        }
    </script>
</body>
</html>

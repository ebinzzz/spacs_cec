<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], input[type="date"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        input[type="submit"], .add-item {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover, .add-item:hover {
            background-color: #45a049;
        }
        .item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function addItem() {
            const container = document.getElementById('items-container');
            const item = document.createElement('div');
            item.className = 'item';

            item.innerHTML = `
                <label for="amount">Amount:</label>
                <input type="number" name="amount[]" step="0.01" required>

                <label for="description">Description:</label>
                <textarea name="description[]" rows="4" required></textarea>
            `;
            container.appendChild(item);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Bill Entry Form</h2>
        <form action="insert_bill.php" method="POST" enctype="multipart/form-data">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="file">Upload Proof:</label>
            <input type="file" id="file" name="file" required>

            <div id="items-container">
                <div class="item">
                    <label for="amount">Amount:</label>
                    <input type="number" name="amount[]" step="0.01" required>

                    <label for="description">Description:</label>
                    <textarea name="description[]" rows="4" required></textarea>
                </div>
            </div>

            <button type="button" class="add-item" onclick="addItem()">Add More Items</button>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>

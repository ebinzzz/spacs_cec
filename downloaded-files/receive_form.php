<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Amount Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Amount Received</h2>
        <form action="process_receive.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="date_received">Date:</label>
                <input type="date" id="date_received" name="date_received" required>
            </div>
            <div>
                <label for="transaction_id_received">Transaction ID:</label>
                <input type="text" id="transaction_id_received" name="transaction_id_received" required>
            </div>
            <div>
                <label for="description_received">Description:</label>
                <input type="text" id="description_received" name="description_received" required>
            </div>
            <div>
                <label for="amount_received">Amount Received (₹):</label>
                <input type="number" id="amount_received" name="amount_received" required>
            </div>
            <div>
                <label for="payment_mode_received">Payment Mode:</label>
                <select id="payment_mode_received" name="payment_mode_received" required>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cheque">Cheque</option>
                    <option value="UPI">UPI</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>
            <div>
                <label for="event_name">Event Name:</label>
             <input type="text" id="event_name" name="event_name" required>
            </div>
            <div>
                <label for="proof_upload">Upload Proof:</label>
                <input type="file" id="proof_upload" name="proof_upload" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <div>
                <label for="bill_no_received">Bill No. (if any):</label>
                <input type="text" id="bill_no_received" name="bill_no_received">
            </div>
            <div>
                <label for="remarks_received">Remarks:</label>
                <textarea id="remarks_received" name="remarks_received"></textarea>
            </div>
            <input type="submit" name="submit_received" value="Add Amount Received">
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>

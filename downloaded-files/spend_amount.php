<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Amount Spent</title>
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
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
        <h2>Enter Amount Spent</h2>
        <form action="process_spend.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="date_spent">Date:</label>
                <input type="date" id="date_spent" name="date_spent" required>
            </div>
            <div>
                <label for="transaction_id_spent">Transaction ID:</label>
                <input type="text" id="transaction_id_spent" name="transaction_id_spent" required>
            </div>
            <div>
                <label for="description_spent">Description:</label>
                <input type="text" id="description_spent" name="description_spent" required>
            </div>
            <div>
                <label for="amount_spent">Amount Spent (₹):</label>
                <input type="number" id="amount_spent" name="amount_spent" required>
            </div>
            <div>
                <label for="payment_mode_spent">Payment Mode:</label>
                <select id="payment_mode_spent" name="payment_mode_spent" required>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cheque">Cheque</option>
                    <option value="UPI">UPI</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>
            <div>
                <label for="event_name_spent">Event Name:</label>
                <input type="text" id="event_name_spent" name="event_name_spent" required>
            </div>
            <div>
                <label for="proof_upload_spent">Upload Proof:</label>
                <input type="file" id="proof_upload_spent" name="proof_upload_spent" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <div>
                <label for="bill_no_spent">Bill No. (if any):</label>
                <input type="text" id="bill_no_spent" name="bill_no_spent">
            </div>
            <div>
                <label for="remarks_spent">Remarks:</label>
                <textarea id="remarks_spent" name="remarks_spent"></textarea>
            </div>
            <input type="submit" name="submit_spent" value="Add Amount Spent">
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>

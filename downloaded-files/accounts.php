<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACS Financial Management</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container Styles */
        .container {
            max-width: 900px;
            width: 100%;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        /* Header Styles */
        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Button Styles */
        a, button {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a:hover, button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            a, button {
                margin: 8px;
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        /* Animation */
        a, button {
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>SPACS Financial Management</h2>
        <a href="receive_form.php">Enter Amount Received</a>
        <a href="spend_amount.php">Enter Amount Spent</a>
        <br>
        <form action="display_receive.php" method="GET">
            <button type="submit">Display Received Amounts</button>
        </form>
        <form action="display_spend.php" method="GET">
            <button type="submit">Display Spent Amounts</button>
        </form>
        <form action="tally.php" method="GET">
            <button type="submit">Tally</button>
        </form>
    </div>
</body>
</html>

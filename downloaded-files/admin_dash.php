<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Main Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f7fa;
            color: #333;
            padding: 20px;
        }

        /* Header Styling */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 800px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            gap: 20px;
            transition: all 0.3s ease;
        }

        .header img {
            height: 120px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .header img:first-child {
            margin-right: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #555;
            text-align: center;
            flex-grow: 1;
            padding: 0 10px;
            transition: color 0.3s ease;
        }

        /* Header Hover Effects */
        .header:hover img {
            transform: scale(1.05);
        }

        .header:hover h1 {
            color: #007bff;
        }

        /* Button Container */
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            width: 100%;
            margin-top: 30px;
        }

        /* Button Styling */
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 14px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.98);
        }

        /* Responsive Styling */
        @media (min-width: 600px) {
            .header {
                flex-direction: row;
                justify-content: space-between;
            }

            .button-container {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 25px;
            }

            button {
                width: 180px;
                font-size: 1rem;
                padding: 12px;
            }
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.6rem;
            }

            button {
                font-size: 1rem;
                width: 100%;
                padding: 12px;
            }
        }

    </style>
</head>
<body>
    <!-- Header with Logos -->
    <div class="header">
        <img src="edu.png" alt="Logo 1">
        <h1>AI Conclave Quiz Admin Dashboard</h1>
        <img src="logocec.png" alt="Logo 2">
    </div>

    <!-- Buttons for Actions -->
    <div class="button-container">
        <button onclick="location.href='add_round.php'">Add Round</button>
        <button onclick="location.href='add_question.php'">Add Question</button>
        <button onclick="location.href='add_team.php'">Add Team</button>
        <button onclick="location.href='mark_scores.php'">Mark Scores</button>
        <button onclick="location.href='leaderboard.php'">Leaderboard</button>
        <button onclick="location.href='track_score.php'">Track Scores</button>
        <button onclick="location.href='update_dash.php'">Update Dashboard</button>
    </div>
</body>
</html>

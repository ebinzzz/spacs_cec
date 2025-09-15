<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_competition_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Scores</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            color: #333;
            text-align: center;
        }
        h1 {
            background: #ffffff;
            color: #3a3a3a;
            padding: 20px;
            margin: 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin: 20px 0;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            transition: border-color 0.3s;
        }
        select:focus {
            outline: none;
            border-color: #66a6ff;
        }
        .question-buttons {
            margin: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .question-buttons button {
            padding: 10px 15px;
            margin: 5px;
            font-size: 14px;
            background: #ffb74d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }
        .question-buttons button:hover {
            background: #ffa726;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 90%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background-color: #66a6ff;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1faff;
        }
        button[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button[type="submit"]:hover {
            background: #218838;
        }
        button[type="submit"][value="-3"] {
            background: #dc3545;
        }
        button[type="submit"][value="-3"]:hover {
            background: #c82333;
        }
        #selected-question {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }
        button {
            padding: 10px 15px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
    <script>
        function fetchQuestions() {
            const roundId = document.getElementById('round_id').value;
            if (roundId) {
                fetch(`get_questions.php?round_id=${roundId}`)
                    .then(response => response.json())
                    .then(data => {
                        const questionButtons = document.getElementById('question-buttons');
                        questionButtons.innerHTML = "";
                        data.forEach(question => {
                            const button = document.createElement('button');
                            button.textContent = `Q${question.question_no}`;
                            button.onclick = () => loadTeamsTable(roundId, question.id, question.question_text);
                            questionButtons.appendChild(button);
                        });
                    });
            }
        }

        function loadTeamsTable(roundId, questionId, questionText) {
            fetch(`get_teams.php?round_id=${roundId}&question_id=${questionId}`)
                .then(response => response.json())
                .then(data => {
                    const teamTable = document.getElementById('teams-table');
                    const teamTableBody = document.getElementById('teams-table-body');
                    document.getElementById('selected-question').textContent = `Question: ${questionText}`;
                    teamTable.style.display = 'table';
                    teamTableBody.innerHTML = "";
                    data.teams.forEach(team => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${team.team_name}</td>
                            <td>${team.college}</td>
                            <td>
                                <form method="post" action="update_score.php">
                                    <input type="hidden" name="team_id" value="${team.id}">
                                    <input type="hidden" name="round_id" value="${roundId}">
                                    <input type="hidden" name="question_id" value="${questionId}">
                                    <input type="hidden" name="change" value="5">
                                    <button type="submit">+5</button>
                                </form>
                            </td>
                            <td>
                                <form method="post" action="update_score.php">
                                    <input type="hidden" name="team_id" value="${team.id}">
                                    <input type="hidden" name="round_id" value="${roundId}">
                                    <input type="hidden" name="question_id" value="${questionId}">
                                    <input type="hidden" name="change" value="-3">
                                    <button type="submit">-3</button>
                                </form>
                            </td>
                        `;
                        teamTableBody.appendChild(row);
                    });
                });
        }
    </script>
</head>
<body>
    <h1>Mark Scores</h1>

    <form>
        <div class="form-group">
            <label for="round_id">Select Round:</label>
            <select id="round_id" name="round_id" onchange="fetchQuestions()" required>
                <option value="">Select Round</option>
                <?php
                $rounds = $conn->query("SELECT * FROM rounds");
                while ($round = $rounds->fetch_assoc()) {
                    echo "<option value='{$round['id']}'>{$round['name']}</option>";
                }
                ?>
            </select>
        </div>
    </form>

    <div id="question-buttons" class="question-buttons">
        <!-- Dynamic question buttons -->
    </div>

    <h2 id="selected-question"></h2>

    <table id="teams-table" style="display:none;">
        <thead>
            <tr>
                <th>Team Name</th>
                <th>College</th>
                <th>Correct (+5)</th>
                <th>Incorrect/Timeout (-3)</th>
            </tr>
        </thead>
        <tbody id="teams-table-body">
            <!-- Dynamic team rows -->
        </tbody>
    </table>

    <button onclick="location.href='admin_dash.php'">Back to Dashboard</button>
</body>
</html>

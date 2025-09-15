<?php
// Database connection
$conn = new mysqli('sql202.infinityfree.com', 'if0_36740899', '5HHGuSYz6PDcO', 'if0_36740899_competition_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total scores for each team
$score_query = "
    SELECT teams.team_name, teams.college, SUM(team_scores.score) AS total_score
    FROM teams
    JOIN team_scores ON teams.id = team_scores.team_id
    GROUP BY teams.id
    ORDER BY total_score DESC
    LIMIT 10
";
$scores = $conn->query($score_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #555;
        }
        th {
            background-color: #444;
            font-size: 1.5em;
        }
        tr {
            transition: transform 0.5s ease, background-color 0.5s ease;
        }
        tr.flip {
            animation: flip 0.5s ease;
        }
        tr.updated {
            background-color: #0066cc;
        }
        @keyframes flip {
            0% {
                transform: rotateX(90deg);
            }
            100% {
                transform: rotateX(0deg);
            }
        }
        .highlight {
            color: #FFD700;
            font-weight: bold;
        }
    </style>
    <script>
        const lastData = {}; // Store the last data to compare updates

        // Function to play sound
        function playSound() {
            const audio = new Audio('https://commondatastorage.googleapis.com/codeskulptor-assets/jump.ogg');
            audio.play();
        }

        // Refresh leaderboard every 5 seconds
        setInterval(() => {
            fetch(location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, "text/html");
                    const newRows = Array.from(newDoc.querySelectorAll("tbody tr"));
                    const tbody = document.querySelector("tbody");
                    const currentRows = Array.from(tbody.querySelectorAll("tr"));

                    newRows.forEach((newRow, index) => {
                        const currentRow = currentRows[index];
                        if (currentRow) {
                            const newCells = Array.from(newRow.cells);
                            const currentCells = Array.from(currentRow.cells);
                            let hasUpdated = false;

                            // Compare each cell's content
                            newCells.forEach((newCell, cellIndex) => {
                                if (newCell.textContent !== currentCells[cellIndex].textContent) {
                                    currentRow.classList.add('updated', 'flip');
                                    hasUpdated = true;
                                    setTimeout(() => currentRow.classList.remove('updated', 'flip'), 1000);
                                }
                            });

                            // Replace old row with new data
                            currentRow.innerHTML = newRow.innerHTML;

                            // Play sound if there's an update
                            if (hasUpdated) playSound();
                        } else {
                            // Add new rows if they didn't exist before
                            tbody.appendChild(newRow);
                            playSound();
                        }
                    });

                    // Remove rows if they are no longer in the updated list
                    while (currentRows.length > newRows.length) {
                        const removedRow = currentRows.pop();
                        removedRow.remove();
                    }
                });
        }, 5000);
    </script>
</head>
<body>
    <h1>Leaderboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Team Name</th>
                <th>College</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($scores->num_rows > 0) {
                $rank = 1;
                while ($row = $scores->fetch_assoc()) {
                    $highlightClass = $rank <= 3 ? 'highlight' : '';
                    echo "<tr class='{$highlightClass}'>";
                    echo "<td>{$rank}</td>";
                    echo "<td>{$row['team_name']}</td>";
                    echo "<td>{$row['college']}</td>";
                    echo "<td>{$row['total_score']}</td>";
                    echo "</tr>";
                    $rank++;
                }
            } else {
                echo "<tr><td colspan='4'>No scores available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

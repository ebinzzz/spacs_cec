<?php
$db_host = 'sql202.infinityfree.com';
$db_username = 'if0_36740899';
$db_password = '5HHGuSYz6PDcO';
$db_name = 'if0_36740899_spacs';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users who have "student member" as their current team
$sql = "SELECT id, name, email FROM `TABLE 22` WHERE team = 'student member'";
$result = $conn->query($sql);

// Define available teams
$teams = [
    "Event Planning Team", "Design & Creative Team", 
    "Marketing & PR Team", "Sponsorship & Partnership Team", 
    "Technical & Logistics Team", "Training & Development Team", 
    "Volunteer & Operations Team", "Academic Affairs Team", "Post-Event Coordination Team"
];

// Handle team assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['selected_users']) && !empty($_POST['selected_team'])) {
        $selectedTeam = $_POST['selected_team'];

        foreach ($_POST['selected_users'] as $userId) {
            $updateSQL = "UPDATE `TABLE 22` SET team = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param("si", $selectedTeam, $userId);
            $stmt->execute();
            $stmt->close();
        }
        echo "<script>alert('Team assigned successfully!'); window.location.href = 'assign_team.php';</script>";
    } else {
        echo "<script>alert('Please select at least one user and a team.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Team Members</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 700px;
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        select, input[type="text"], table {
            width: 100%;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Search Bar */
        .search-box {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Buttons */
        .submit-btn {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #003d80;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }

        .footer a {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Function to filter users based on search input
        function searchUsers() {
            let input = document.getElementById("search").value.toLowerCase();
            let table = document.getElementById("userTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { 
                let name = rows[i].getElementsByTagName("td")[1];
                if (name) {
                    let nameText = name.textContent || name.innerText;
                    rows[i].style.display = nameText.toLowerCase().includes(input) ? "" : "none";
                }
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Assign Members to a Team</h2>

    <!-- Team Selection Dropdown -->
    <form method="POST">
        <label for="team">Select Team:</label>
        <select name="selected_team" id="team">
            <option value="">-- Select a Team --</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team) ?>"><?= htmlspecialchars($team) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Search Bar -->
        <input type="text" id="search" class="search-box" onkeyup="searchUsers()" placeholder="Search by name...">

        <!-- User List Table -->
        <table id="userTable">
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_users[]" value="<?= $row['id'] ?>"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" style="text-align:center;">No users available for assignment.</td></tr>
            <?php endif; ?>
        </table>

        <!-- Assign Button -->
        <button type="submit" class="submit-btn">Assign Selected Users</button>
    </form>
</div>

<!-- Footer -->
<div class="footer">
    © 2025 SPACS | <a href="http://www.spacscec.free.nf" target="_blank">Visit Official Website</a>
</div>

</body>
</html>

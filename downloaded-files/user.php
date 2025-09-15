<!-- select_semester_course.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Semester and Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #0073e6;
            margin-bottom: 20px;
        }
        .labels {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #0073e6;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #0073e6;
            outline: none;
        }
        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 10px auto;
        }
        .btn:hover {
            background-color: #218838;
        }
        .back-button, .count-button {
            display: block;
            width: 150px;
            margin: 10px auto;
            padding: 10px 20px;
            text-align: center;
            color: #ffffff;
            background-color: #0073e6;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .back-button:hover, .count-button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Semester and Course</h2>
        <a href="user1.php" class="back-button">Back</a>
        <a href="displaycount.php" class="count-button">View Counts</a>
        <form action="display_students.php" method="get">
            <div class="col-md-12">
                <label class="labels">Semester</label>
                <select class="form-control" name="semester" required>
                    <option value="" disabled selected>Select Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="labels">Course</label>
                <select class="form-control" name="course" required>
                    <option value="" disabled selected>Select Course</option>
                    <option value="cse">Computer Science and Engineering</option>
                    <option value="ece">Electronics and Communication Engineering</option>
                    <option value="eee">Electrical and Electronics Engineering</option>
                    <option value="ai">Artificial Intelligence</option>
                    <option value="ot">Others</option>
                </select>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>
</html>

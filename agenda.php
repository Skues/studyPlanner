<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tasks for the user to display in the dropdown
$tasks_sql = "SELECT id, task_name FROM tasks WHERE user_id = ?";
$tasks_stmt = $conn->prepare($tasks_sql);
$tasks_stmt->bind_param("i", $user_id);
$tasks_stmt->execute();
$tasks_result = $tasks_stmt->get_result();
$tasks = [];
while ($row = $tasks_result->fetch_assoc()) {
    $tasks[] = $row;
}
$tasks_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda</title>
<link rel="stylesheet" href="styles2.css">   
</head>
<body>
<header>
    <nav class="navbar">
        <img src="images/websiteTestLogo.png" alt="Test logo" class= "logo">
        <ul class="navlinks">
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a class="active" href="agenda.php">Agenda</a></li>
            <li><a href="jsontest.php">Upload</a></li>
            <li><a href="gantt3.php">Calendar</a></li>

        </ul>
    </nav>
</header>

<h3>Add Tasks</h3>
<form id="taskform" action="submittask.php" method="post">
    <div class="studytask">
        <label class="studytasklabel">Task name</label>
        <input type="text" name="taskname" required />
    </div>
    <div class="studytask">
        <label class="studytasklabel">Start date</label>
        <input type="date" name="taskstart" required />
    </div>
    <div class="studytask">
        <label class="studytasklabel">End date</label>
        <input type="date" name="taskend" required />
    </div>
    <div class="studytask">
        <label class="studytasklabel">Time spent</label>
        <input type="text" name="timespent" required />
    </div>
    <div class="studytask">
        <label class="studytasklabel">Type of task</label>
        <select name="task_type" required>
            <option value="Writing">Writing</option>
            <option value="Programming">Programming</option>
            <option value="Research">Research</option>
            <option value="Reading">Reading</option>
        </select>
    </div>
    <div class="studytask">
        <label class="studytasklabel">Requirement criterion</label>
        <input type="text" name="requirement" required />
    </div>
    <br>
    <textarea name="notes" id="notes" placeholder="Enter your notes here:" rows="5" cols="50"></textarea>
    <br>
    <button type="submit">Submit</button>
</form>

<h3>Add Activity</h3>
<form id="taskform" action="submitactivity.php" method="post">
    <div class="studytask">
        <label class="studytasklabel">Select Task</label>
        <select name="task_id" required>
            <?php foreach ($tasks as $task): ?>
                <option value="<?= htmlspecialchars($task['id']) ?>"><?= htmlspecialchars($task['task_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="studytask">
        <label class="studytasklabel">Activity name</label>
        <input type="text" name="activity_name" required />
    </div>
    <div class="studytask">
        <label class="studytasklabel">Time the activity will take</label>
        <input type="text" name="timetaken" required />
    </div>
    <br>
    <textarea name="activitynotes" id="activitynotes" placeholder="Enter your notes here:" rows="5" cols="50"></textarea>
    <br>
    <button type="submit">Submit</button>
</form>

<a href="http://localhost/studyPlanner/gettask.php">
    <button>Click me</button>
</a>
</body>
</html>

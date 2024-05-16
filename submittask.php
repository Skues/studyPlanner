<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "mydatabase";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $taskname = $_POST["taskname"];
    $taskstart = $_POST["taskstart"];
    $taskend = $_POST["taskend"];
    $timespent = $_POST["timespent"];
    $task_type = $_POST["task_type"];
    $requirement = $_POST["requirement"];
    $notes = $_POST["notes"];

    $module_code = "CS201";
    $cw_name = "Project";

    $sql = "INSERT INTO tasks (user_id, module_code, cw_name, task_name, task_start, task_end, task_timespent, task_type, requirement, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $user_id, $module_code, $cw_name, $taskname, $taskstart, $taskend, $timespent, $task_type, $requirement, $notes);
    $stmt->execute();
    $stmt->close();


    header("Location: dashboard.php");
}

$conn->close();


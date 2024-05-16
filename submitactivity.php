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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activityname = $_POST["activity_name"];
    $timetaken = $_POST["timetaken"];
    $notes = $_POST["activitynotes"];
    $task_id = $_POST["task_id"];

    $sql = "INSERT INTO activities (user_id, task_id, activity_name, activity_notes, time_completed) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $user_id, $task_id, $activityname, $notes, $timetaken);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
}

$conn->close();
?>

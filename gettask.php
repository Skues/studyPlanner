<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
else{
    // gettasks();
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM tasks WHERE user_id = $user_id";
    $result = $conn->query($sql);

    $taskarray = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $taskarray[] = $row;   
        // print_r($taskarray["task_name"]);
        // echo "<br>";
    
        // echo "<p> ". htmlspecialchars($taskarray) . "</p>";
    }
    echo json_encode($taskarray);

}
}
//function gettasks(){}

$conn->close();



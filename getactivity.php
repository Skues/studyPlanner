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
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM activities WHERE user_id = $user_id";
    $result = $conn->query($sql);

    $activitiesarray = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activitiesarray[] = $row;   
    }
    echo json_encode($activitiesarray);

}
}

$conn->close();



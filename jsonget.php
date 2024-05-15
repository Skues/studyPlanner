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

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT json_data FROM json_files WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $json_array = array();

        while ($row = $result->fetch_assoc()) {
            $json_array[] = json_decode($row["json_data"], true);
        }

        echo json_encode($json_array);
    } else {
        echo "No data found for the logged-in user.";
    }
} else {
    echo "User is not logged in.";
}

$conn->close();

?>
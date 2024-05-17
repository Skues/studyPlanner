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

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["json_file"])) {
    $file_name = $_FILES["json_file"]["name"];
    $file_tmp = $_FILES["json_file"]["tmp_name"];
    $file_type = $_FILES["json_file"]["type"];
    $file_size = $_FILES["json_file"]["size"];

    $json_data = file_get_contents($file_tmp);

    $sql = "INSERT INTO json_files (user_id, file_name, json_data) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $file_name, $json_data);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM json_files WHERE user_id = '$user_id'";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON File</title>
    <link rel="stylesheet" type="text/css" href="styles2.css">
</head>

<body>
<header>
<nav class = "navbar">
                <img src = "images\websiteTestLogo.png" alt = "Test logo" class= "logo">
            <ul class = "navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="agenda.php">Agenda</a></li>
                <li><a class = "active" href="jsontest.php">Upload</a></li>
                <li><a href="gantt3.php">Calendar</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
            </nav>

            
        </header>
    <h1>Upload JSON File</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="json_file" accept=".json">
        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded JSON Files</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['file_name']}</li>";
            }
        } else {
            echo "<li>No JSON files uploaded.</li>";
        }
        ?>
    </ul>

</body>

</html>

<?php
$conn->close();
?>
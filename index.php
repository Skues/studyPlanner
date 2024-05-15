<?php
// Start session
session_start();

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // User is logged in
    $user_id = $_SESSION['user_id'];
    
    // Establish a database connection (you need to replace these values with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mydatabase";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user data
    $sql = "SELECT * FROM users WHERE id = $user_id";

    // Execute the query
    $result = $conn->query($sql);

    // Check if any row is returned
    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        // You can access user data like this
        $username = $row['username'];
        $email = $row['email'];
        // Other user data as needed
    } else {
        // No user found with the given ID
        echo "No user found with ID: $user_id";
    }

    // Close the connection
    $conn->close();

} else {
    // User is not logged in, you might want to redirect them to the login page
    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="styles2.css">

    </head>
    <body>
        <header>
            <nav class = "navbar">
                <img src = "websiteTestLogo.png" alt = "Test logo">
            <ul class = "navlinks">
                <li><a class = "active" href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="jsontest.php">JSON TEST</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
            </nav>

            
        </header>
        <h1>Testing head</h1>
        <p>testing paragraph</p>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>Your email: <?php echo $email; ?></p>


        
    </body>
</html>
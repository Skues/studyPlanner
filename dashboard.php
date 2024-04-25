<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <script src="dashboard.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="websiteTestLogo.png" alt="Test logo">
            <ul class="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <!--<li class="logout"><a href="#logout">Logout</a></li>-->
            </ul>
        </nav>
    </header>
    <h1>DASHBOARD</h1>
    <h2 class="upcoming-deadlines-header">Upcoming Deadlines:</h2>
    <div class="oval">
        <h3>Upcoming Deadline 1</h3>
        <p>Due: 18th June 2024</p>
        <div class="progress-bar">
            <div class="progress"></div>
            <div class="percent">0%</div>
        </div>
    </div>
    <div class="section-gap"></div>
    <h2 class="past-deadlines-header">Past Deadlines:</h2>
</body>
</html>

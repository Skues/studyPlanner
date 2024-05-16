<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="styles2.css?">
        <link rel="stylesheet" type="text/css" href="styles.css?">
        <script src="scripts/gantt.js"></script>

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
                <li><a href="jsontest.php">Upload</a></li>
                <li><a class = "active" href="gantt3.php">Calendar</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
            </nav>

            
        </header>
        <div class = "scroll">
            <div class="chart-wrapper">
                <ul class="chart-values"></ul>
                <ul class="chart-bars"></ul>
            </div>
        </div>


    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="styles2.css">   

<head>
    <header>
    <nav class = "navbar">
                <img src = "images\websiteTestLogo.png" alt = "Test logo" class= "logo">
            <ul class = "navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a class = "active" href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="agenda.php">Agenda</a></li>
                <li><a href="jsontest.php">Upload</a></li>
                <li><a href="gantt3.php">Calendar</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
            </nav>
    </header>
</head>
<body>

    <ul id = "taskarraytest"></ul>

    <div class="content" id="moduleList"></div>

    <h2>Upcoming Deadlines:</h2>
    <div class="upcoming-deadlines"></div>
    <div class="section-gap-lesser"></div>


    <h2>Past Deadlines:</h2>
    <div class="past-deadlines"></div>
    <div class="tasks-container"> </div>
    <div class="DivID"> </div>
    <script src="scripts/dashboard.js"></script>

</body>
</html>


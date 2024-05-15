<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda</title>
<link rel="stylesheet" href="styles2.css">   
<head>
    <header>
        <nav class="navbar">
            <img src="websiteTestLogo.png" alt="Test logo">
            <ul class="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a class = "active" href="agenda.php">Agenda</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="jsontest.php">JSON TEST</a></li>
                <!--<li class="logout"><a href="#logout">Logout</a></li>-->
            </ul>
        </nav>
    </header>
</head>
<body>
<h1>User can see the list of exams and courseworks to assign study tasks to them</h1>
<h3>~Exams and coursework names~</h3>
<button>New task</button>
<br>
<form id = "taskform" action = "submittask.php" method = "post">
<div class = "studytask">
    <label class = "studytasklabel">Task name</label>
    <input type ="text"/>
</div>
<div class = "studytask">
    <label class = "studytasklabel">Time spent</label>
    <input type ="text"/>
</div>
<div class = "studytask">
    <label class = "studytasklabel">Type of task</label>
    <select name="typeoftask" id="typeoftask">
        <option selected>Select a type of task</option>
        <option value="writing">Writing</option>
        <option value="programming">Programming</option>
        <option value="research">Research</option>
        <option value="reading">Reading</option>
    </select>
</div>
<div class = "studytask">
    <label class= "studytasklabel">Requirement criterion</label>
    <input type ="text"/>
</div>
<br>
<textarea id = "notes" placeholder="Enter your notes here:" rows="5" cols="50"></textarea>
<br>
<button>Submit</button>
</form>



</body>
</html>
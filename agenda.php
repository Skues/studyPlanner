<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda</title>
<link rel="stylesheet" href="styles2.css?">   
<head>
    <header>
        <nav class="navbar">
            <img src="images/websiteTestLogo.png" alt="Test logo">
            <ul class="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="gantt2.php">Calendar</a></li>
                <li><a class = "active" href="agenda.php">Tasks</a></li>
                <li><a href="jsontest.php">Upload</a></li>
                <li><a href="profile.php">Profile</a></li>
                <!--<li class="logout"><a href="#logout">Logout</a></li>-->
            </ul>
        </nav>
    </header>
</head>
<body>
<h3>Exams and coursework names</h3>
<form id = "taskform" action = "submittask.php" method = "post">
<div class = "studytask">
    <label class = "studytasklabel">Task name</label>
    <input type ="text" name = "taskname"/>
</div>
<div class = "studytask">
    <label class = "studytasklabel">Start date</label>
    <input type ="date" name = "taskstart"/>
</div>
<div class = "studytask">
    <label class = "studytasklabel">End date</label>
    <input type ="date" name = "taskend"/>
</div>
<div class = "studytask">
    <label class = "studytasklabel">Time spent</label>
    <input type ="text" name = "timespent"/>
</div>
<div class = "studytask">
    <label for="typeoftask">Type of task:</label>
        <select name="typeoftask" id="typeoftask">
            <option value="writing">Writing</option>
            <option value="programming">Programming</option>
            <option value="research">Research</option>
            <option value="reading">Reading</option>
        </select>
</div>
<div class = "studytask">
    <label class= "studytasklabel">Requirement criterion</label>
    <input type ="text" name = "requirement"/>
</div>
<br>
<textarea name = "notes" id = "notes" placeholder="Enter your notes here:" rows="5" cols="50"></textarea>
<br>
<button>Submit</button>

</form>
<a href="http://localhost/studyPlanner/gettask.php">
  <button>Click me</button>
</a>


</body>
</html>
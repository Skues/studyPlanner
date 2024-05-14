<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup.view.inc.php';
require_once 'includes/login_view.inc.php';


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="styles2.css">

        <script src="scripts.js"></script>

    </head>
    <body>
        <header>
        <nav class = "navbar">
                <img src = "websiteTestLogo.png" alt = "Test logo">
            <ul class = "navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="agenda.php">Agenda</a></li>
                <li><a class = "active" href="profile.php">Profile</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
        </header>
        <h1>PROFILE</h1>
        <h2>Modal Signup Form a a a a</h2> 
    <!--Step 1:Adding HTML-->
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign Up</button> 
  
    <div id="id01" class="modal"> 
        <form class="modal-content signup" action="includes\signup.inc.php" method="post"> 
                <label for = "username"><b>Username</b></label> 
                <input id = "username" type="text" placeholder="Enter Username" name="username" >

                <label for = "email"><b>Email</b></label> 
                <input id = "email" type="text" placeholder="Enter Email" name="email" > 
  
                <label for = "password"><b>Password</b></label> 
                <input id = "password" type="password" placeholder="Enter Password" name="pwd" > 
  
                <label for = "repeatpass"><b>Repeat Password</b></label> 
                <input id = "repeatpass" type="password" placeholder="Repeat Password" name="psw-repeat" > 
                <input type="checkbox"> Remember me 
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> 
  
                <div class="clearfix"> 
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn">Sign Up</button> 
            </div> 
        </form>

       

        </div>
        <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Login</button> 
  
    <div id="id02" class="modal"> 
        <form class="modal-content login" action="includes\login.inc.php"  method="post"> 
                <label for = "username"><b>username</b></label> 
                <input type="text" placeholder="Enter Username" name="username"> 
  
                <label for = "password"><b>Password</b></label> 
                <input type="password" placeholder="Enter Password" name="pwd"> 
   
                <input type="checkbox"> Remember me 
  
                <div class="clearfix"> 
                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn">Login</button> 

            </div> 
        </form> 

        
           
        
    </div> 
    <?php
            check_signup_errors();
         check_login_errors();
         ?>

    </body>
</html>
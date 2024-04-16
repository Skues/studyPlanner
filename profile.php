<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="public/styles.css">

        <script src="scripts.js"></script>

    </head>
    <body>
        <header>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a class = "active" href="profile.php">Profile</a></li>
                <!--<li class = "logout"><a href ="#logout">Logout</a></li>-->
            </ul>
        </header>
        <h1>PROFILE</h1>
        <h2>Modal Signup Form</h2> 
    <!--Step 1:Adding HTML-->
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign Up</button> 
  
    <div id="id01" class="modal"> 
        <form class="modal-content signup" action="/action_page.php"> 
            <div class="container"> 
                <label><b>Email</b></label> 
                <input type="text" placeholder="Enter Email" name="email" required> 
  
                <label><b>Password</b></label> 
                <input type="password" placeholder="Enter Password" name="psw" required> 
  
                <label><b>Repeat Password</b></label> 
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required> 
                <input type="checkbox"> Remember me 
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> 
  
                <div class="clearfix"> 
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn">Sign Up</button> 
                </div> 
            </div> 
        </form>
        </div>
        <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Login</button> 
  
    <div id="id02" class="modal"> 
        <form class="modal-content login" action="/action_page.php"> 
            <div class="container"> 
                <label><b>Email</b></label> 
                <input type="text" placeholder="Enter Email" name="email" required> 
  
                <label><b>Password</b></label> 
                <input type="password" placeholder="Enter Password" name="psw" required> 
   
                <input type="checkbox"> Remember me 
  
                <div class="clearfix"> 
                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button> 
                    <button type="submit" class="signupbtn">Login</button> 
                </div> 
            </div> 
        </form> 
    </div> 
    </body>
</html>
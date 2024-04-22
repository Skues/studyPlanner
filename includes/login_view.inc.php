<?php

declare(strict_types=1);

function check_login_errors(){
    if(isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        unset($_SESSION["errors_login"]);
        echo "<br>";

        foreach($errors as $error){
            echo "<p>".$error."</p>";
        }
    
    } else if(isset($_GET["login"]) && $_GET["login"] === "sucess"){
        echo "<br>";
        echo "<p>Login Sucess!</p>";
    }
}
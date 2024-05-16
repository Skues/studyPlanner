<?php 



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];


    try {
        require_once"dbh.inc.php";
        require_once"signup_model.inc.php";
        require_once"signup.contr.inc.php";

        // ERROR HANDLING

        $errors = [];
        if(is_input_empty($username, $email, $password)) {
            $errors["empty_input"] = "Fill in all fields";
        }

        if(is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used";
        }

        if(is_username_taken($pdo, $username )) {
            $errors["username_taken"] = "Username already used";
        }
        if(is_email_taken($pdo, $email)){
            $errors["email_taken"] = "Email already used";
        }

        require_once "config_session.inc.php";

        if($errors){
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "username"=> $username,"email"=> $email
            ];
            $_SESSION["signup_data"] = $signupData;
            header("Location: ../profile.php");
            die();
        }

        create_user($pdo, $username, $email, $password);

        
        header("Location: ../profile.php?signup=sucess");

        $pdo = null;
        $stmt= null;
        die();

    } catch (PDOException $e) {
        echo "Connection failed". $e->getMessage();
    }
}
else {
    header("Location: ../profile.php");
    die();
    
}
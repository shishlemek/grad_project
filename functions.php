
<?php 
function loggedIn(){ 
    //Session logged is set if the user is logged in 
    //set it on 1 if the user has successfully logged in 
    //if it wasn't set create a login form 
    if(!$_SESSION['logged']){ 
        echo'<div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
                <form action="home.hmtl">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember me</label>
                        </div>
                        
                        <a href="#" class="text">Forgot password?</a>
                    </div>
                    <div class="input-field button">
                        <input type="button" value="Login">
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="registration.php" class="text signup-link">Register Now</a>
                    </span>
                </div>
            </div>'; 
        //if session is equal to 1, display  
        //Welcome, and whaterver their user name is 
    }else{ 
        echo 'Welcome, '.$_SESSION['username']; 
    } 
} 
?> 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link rel="stylesheet" href="log_reg.css">
</head>
<body>
            <script src="reg_log.js"></script> 
</body>
</html>
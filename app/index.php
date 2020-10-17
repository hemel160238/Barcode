<?php 
session_start();

if ($_SESSION) {
    if ($_SESSION['role'] == "admin") {
      header("Location: allpurchase.php");
    } 
    elseif($_SESSION['role'] == "admin") {
      header("Location: studentallpurchase.php");
    }
    // else{
    //   header("Location: index.php");
    // }
} 
else {
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="loginstyle.css"> 
</head>
<body>
    <div class="login-page">
        <div class="form">
          <!-- <form class="register-form">
            <input type="text" placeholder="name"/>
            <input type="password" placeholder="password"/>
            <input type="text" placeholder="email address"/>
            <button>create</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
          </form> -->

          <form class="login-form" action="process.php" method="POST">
            <label><input type="radio" name="role" value="admin" checked>Admin</label>
            <label><input type="radio" name="role" value="student" >Student</label>

            <input type="email" placeholder="email" name="email"/>
            <input type="password" placeholder="password" name="password"/>
            
            <button type="submit" name="login">login</button>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
          </form>
        </div>
      </div>
</body>
</html>
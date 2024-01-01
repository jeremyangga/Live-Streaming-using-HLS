<?php
session_start();

// connect to database
$db = mysqli_connect("localhost", "root", "cc", "proyekcc");
$notif='';
// variable declaration
$nama = "";
$email    = "";
$password = "";
$errors   = array(); 



    // call these variables with the global keyword to make them available in function
    global $db, $errors, $nama, $email;


    // receive all input values from the form. Call the e() function
    // defined below to escape form values
   if (isset($_POST['submit'])){
    $nama  =  $_POST['nama'];
    $email =  $_POST['email'];
    $password  =  $_POST['psw'];
    
    // form validation: ensure that the form is correctly filled
    if (empty($nama)) { 
        array_push($errors, "Name is required"); 
    }
    if (empty($email)) { 
        array_push($errors, "Email is required"); 
    }
    if (empty($password)) { 
        array_push($errors, "Password is required"); 
    }
    // register user if there are no errors in the form
    $password = md5($password);//encrypt the password before saving in the database
    $user_type = ($_POST['email']);
                $query = "INSERT INTO user (id, email, nama, password) 
                          VALUES(NULL, '$email', '$nama', '$password')";
                mysqli_query($db, $query);
                $_SESSION['email'] = $email;
                $_SESSION['Login'] = true;
                //$_SESSION['success']  = "New user created!!";
                header('location: index.php');
                //$notif .= phpAlert_user("New User Created!");
        //echo("$password");
        // $sql = "SELECT `email` FROM user WHERE `email` = '$email'";
        // $result = mysqli_query($db, $sql);
        // if(mysqli_num_rows($result) > 0){
        //     $row = mysqli_fetch_assoc($result);
        //     if($email == $row['email']){
        //         echo '<script>alert("User Already Exists!"</script>';
        //     }
        //     else{
                

        //     }
        // }
  }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <title>Sign Up Live Stream</title>
    <style>
        #design_login_signup {
                margin-left: auto; 
            }
         /* The popup form - hidden by default */
        .form-popup {
            display: none;
            position: fixed;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=text], .form-container input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
        }

        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Set a style for the submit/login button */
        .form-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom:10px;
            opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }
    </style>
</head>
<center>
<nav style="padding:10px;" class="navbar navbar-expand-lg navbar-dark bg-dark">
       <a class="navbar-brand" href="index.php">
	    <img src="Live_Stream.png" width="60" height="40" alt="">
	  </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" id="design_login_signup">
        </div>
      </div>
</nav>
  <form action="" class="form-container" method="POST">
    <h1>Sign Up</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="nama"><b>Nama</b></label>
    <input type="text" placeholder="Enter Your Name" name="nama" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn" name="submit">Sign Up</button>
    <button type="button" class="btn cancel" onclick="closeFormSignUp()">Close</button>
  </form>
<br>
<script>
    function closeFormSignUp() {
        document.location.href = "index.php";
        //document.getElementById("FormSignUp").style.display = "none";
        }
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</center>
</body>
</html>

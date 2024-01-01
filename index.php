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

if(isset($_POST['login'])){
  login();
}
function login(){
    global $db, $nama, $password, $errors;

    // grap form values
    $email = $_POST['email'];
    $password = $_POST['psw'];

    // make sure form is filled properly
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) > 0) { // user found
            $logged_in_user = mysqli_fetch_assoc($results);
            $_SESSION['email'] = $logged_in_user;
            $_SESSION['email_user'] = $email;
            $_SESSION['success']  = "You are now logged in";
            $_SESSION['Login'] = true;
            echo "test";
            header('location: index_stream.php');       
        }else {
          echo "<script>alert('Salah password atau username')</script>";
        }
    }
}


function register(){
    // call these variables with the global keyword to make them available in function
    global $db, $errors, $nama, $email;


    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $nama  =  e($_POST['nama']);
    $email =  e($_POST['email']);
    $password  =  e($_POST['password']);

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
    if (count($errors) == 0) {
        $password = md5($password);//encrypt the password before saving in the database
        //echo("$password");
        if (isset($_POST['email'])) {
            $sql = "SELECT `email` FROM proyekcc WHERE `email` = '$email'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                //$_SESSION['success']  = phpAlert("User already exists");
                $notif .= phpAlert("User Already Exists!");
            }
            else{
                $user_type = ($_POST['email']);
                $query = "INSERT INTO `proyekcc` (id, `email`, `nama`, `password`) 
                          VALUES(NULL, '$email', '$nama', '$password')";
                mysqli_query($db, $query);
                //$_SESSION['success']  = "New user created!!";
                //header('location: ../login.php');
                $notif .= phpAlert_user("New User Created!");
            }
        }else{
            $sql = "SELECT `nama` FROM proyekcc WHERE `nama` = '$nama'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                $_SESSION['success']  = "Sudah ada user";
                header('location: index.php');
            }
            else{
            $query = "INSERT INTO proyekcc (`id`, `email`, `nama`, `password`) 
                      VALUES(NULL, '$email', '$nama', '$password')";
            mysqli_query($db, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($db);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');               
        }
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="https://unpkg.com/videojs-contrib-hls/dist/videojs-contrib-hls.js"></script>
    <title>Live Stream</title>
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
       <a class="navbar-brand" href="">
	    <img src="Live_Stream.png" width="60" height="40" alt="">
	  </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" id="design_login_signup">
        <button class="btn btn-outline-info" onclick="openFormLogin()">Log In</button>
        <button class="btn btn-outline-success" onclick="openFormSignUp()">Sign Up</button>
        </div>
      </div>
</nav>
<div class="form-popup" id="FormLogin">
  <form action="" class="form-container" method="POST">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn" name="login">Log In</button>
    <button type="button" class="btn cancel" onclick="closeFormLogin()">Close</button>
  </form>
</div>
<div class="form-popup" id="FormSignUp">
  <!-- <form action="" class="form-container" method="POST">
    <h1>Sign Up</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="nama"><b>Nama</b></label>
    <input type="text" placeholder="Enter Your Name" name="nama" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Sign Up</button>
    <button type="button" class="btn cancel" onclick="closeFormSignUp()">Close</button>
  </form> -->
</div>
<br>

<video id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="480" data-setup='{}'>
  </video>
  <script>
    const player = videojs('my_video_1');
    player.src({
      fill: true,
      <?php
      $sql2 = "SELECT * from stream";
      $results2 = mysqli_query($db, $sql2);
      while($row = mysqli_fetch_assoc($results2)){
          $url = $row['url'];
          $title_video = $row['title'];
          $id_user = $row['user_id'];
      }
      $sql3 = "SELECT * from user where id = $id_user";
      $res3 = mysqli_query($db, $sql3);
      while ($row = mysqli_fetch_assoc($res3)){
        $nama = $row['nama'];
      }
      echo "src: '$url',";
      ?>
      type: 'application/x-mpegURL'
    });
  </script>
  <?php
    echo "<h2>Video title : $title_video</h2>";
    echo "<h2>Streamer name : $nama </h2>";
  ?>
  <script>
    function openFormLogin() {
    document.getElementById("FormLogin").style.display = "block";
    }

    function closeFormLogin() {
    document.getElementById("FormLogin").style.display = "none";
    }

    function openFormSignUp() {
    document.location.href = "signup.php";
    //document.getElementById("FormSignUp").style.display = "block";
    }

    function closeFormSignUp() {
    document.getElementById("FormSignUp").style.display = "none";
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</center>
</body>
</html>

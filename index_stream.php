<?php
session_start();
if(!isset($_SESSION["Login"])){
    header("location: index.php");
}
// connect to database
$db = mysqli_connect("localhost", "root", "cc", "proyekcc");
$notif='';
// variable declaration
$nama = "";
$email = $_SESSION['email_user'];
$sql = "SELECT * from user where email = '$email'";
$results = mysqli_query($db, $sql);
while($row = mysqli_fetch_assoc($results)){
    $nama = $row['nama'];
    $id_user = $row['id'];
}
$errors   = array(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
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
       <a class="navbar-brand" href="index.php">
	    <img src="Live_Stream.png" width="60" height="40" alt="">
	  </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" id="design_login_signup">
        <form method="POST" action ="logout.php">
            <button class="btn btn-outline-danger" type="submit" name="logout">Log Out</button>
        </form>
        </div>
      </div>
</nav>


<br>
<?php
    echo "<h1>Hello ".$nama."</h1>";
?>

  <form action="" class="form-container" method="POST">
    <!-- <h2></h2> -->

    <label for="video_title"><b>Video Title</b></label>
    <input type="text" placeholder="Enter Video Title" name="video_title">

    <button type="submit" class="btn" name="submitvideo"> Submit </button>
  </form>
<?php
    if(isset($_POST["submitvideo"])){
        $sql2 = "SELECT * from stream";
        $results2 = mysqli_query($db, $sql2);
        while($row = mysqli_fetch_assoc($results2)){
            $id_stream = $row['id'];
        }
        $id_stream = $id_stream+1;
        $keystream = $id_user.'-key-'.$id_stream;
        $title = $_POST["video_title"];
        $server = "rtmp://3.236.31.9/show";
        $url = "http://3.236.31.9:8080/hls/".$keystream.".m3u8";
        echo "<h3> Your video title is <h3 style='color:red'>".$title."</h3> <h3>Your stream key is</h3> <h3 style='color:red'>".$keystream."</h3> <h3>Your server is </h3> <h3 style='color:red'>".$server."</h3>";
        echo "<h4> Please insert your stream key and server into your streaming software";
        $sql3 =  "INSERT into stream (id, user_id, keystream, server, url, title) VALUES (NULL, '$id_user', '$keystream','$server','$url','$title')";
        mysqli_query($db, $sql3);
        ?>
        <br><br> <form method="post" action=""> <button type="submit" class="btn btn-primary" name="new"> New Streaming </button> </form> <br><br>
        <?php
        if(isset($_POST["new"])){
            header('location: index_stream.php');
        }
    }
?>
<script>
    function new() {
        document.location.href="index_stream.php";
    //document.getElementById("FormLogin").style.display = "block";
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

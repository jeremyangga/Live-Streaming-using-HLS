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
  <form action="" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Log In</button>
    <button type="button" class="btn cancel" onclick="closeFormLogin()">Close</button>
  </form>
</div>
<div class="form-popup" id="FormSignUp">
  <form action="" class="form-container">
    <h1>Sign Up</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Sign Up</button>
    <button type="button" class="btn cancel" onclick="closeFormSignUp()">Close</button>
  </form>
</div>
<br>
<video id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="268"
  data-setup='{}'>
  </video>

  <script>
    const player = videojs('my_video_1');
    player.src({
      src: 'http://100.26.1.199:8080/hls/test.m3u8',
      type: 'application/x-mpegURL'
    });
  </script>
<script>
    function openFormLogin() {
    document.getElementById("FormLogin").style.display = "block";
    }

    function closeFormLogin() {
    document.getElementById("FormLogin").style.display = "none";
    }

    function openFormSignUp() {
    document.getElementById("FormSignUp").style.display = "block";
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

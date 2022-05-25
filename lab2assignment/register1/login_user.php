<?php

include 'db.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_register` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:mainpage.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MY TUTOR LOGIN</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="stylee.css?v=<?php echo time () ; ?>">


</head>
<body>

<style>
 
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: palevioletred;
    }
    
    li {
      float: left;
    }
    
    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    
    li a:hover {
      background-color: #111;
    }
    </style>
    </head>
    <body>
    
    <ul>
      <li><a class="active" href="register.php">Register</a></li>
      <li><a href="login_user.php">Login</a></li>
      
    </ul>
    <br>
    <br>
    <BR>
    <center><h1>𝕄𝕐 𝕋𝕌𝕋𝕆ℝ</h1></center>  
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>𝐋𝐎𝐆𝐈𝐍 𝐇𝐄𝐑𝐄</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">register here </a></p>
   </form>
   <footer>
   <p>Copyright &copy:2022 NUR MURSYIDA</p>
 
</footer>
</div>

</body>
</html>
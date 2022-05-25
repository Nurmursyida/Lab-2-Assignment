<?php

include 'db.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login_user.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login_user.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MY TUTOR</title>

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
    <center><h1>𝕄𝕐 ℙℝ𝕆𝔽𝕀𝕃𝔼 </h1></center>
<div class="container">

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `user_register` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="userpic/profile.jpg">';
         }else{
            echo '<img src="profileimage/'.$fetch['image'].'">';
         }
      ?>
      <h3><?php echo $fetch['name']; ?></h3>
      <a href="upload.php" class="btn">Update Profile</a>
      <a href="mainpage.php?logout=<?php echo $user_id; ?>" class="delete-btn">Main page</a>
      <p>Click <a href="login_user.php">Login here </a> or <a href="register.php">Register here</a></p>
   </div>
   <footer>
   <p>Copyright &copy:2022 NUR MURSYIDA</p>
 
</footer>
</div>

</body>
</html>
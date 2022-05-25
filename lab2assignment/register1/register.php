<?php

include 'db.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
   $homeaddress = mysqli_real_escape_string($conn, $_POST['homeaddress']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'profileimage/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_register` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_register`(name, email, phonenumber, homeaddress, password, image) VALUES('$name', '$email', '$phonenumber', '$homeaddress', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered is successfu!';
            header('location:login_user.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>𝐌𝐘 𝐓𝐔𝐓𝐎𝐑</title>

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
<center><h1>𝕄𝕐 𝕋𝕌𝕋𝕆ℝ</h1></center>
 

<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>𝐑𝐄𝐆𝐈𝐒𝐓𝐄𝐑 𝐇𝐄𝐑𝐄</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="phonenumber" name="phonenumber" placeholder="enter phone number " class="box" required>
      <input type="homeaddress" name="homeaddress" placeholder="enter home address " class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>Already have an account? <a href="login_user.php">login here</a></p>
      
     
   </form>
  <br>
  <br>
   <footer>
   <p>Copyright &copy:2022 NUR MURSYIDA</p>
 
</footer>
</style>  
</div>

</body>
</html>
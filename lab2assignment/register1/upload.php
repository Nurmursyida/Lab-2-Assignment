<?php

include 'db.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['upload'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_phonenumber = mysqli_real_escape_string($conn, $_POST['update_phonenumber']);
   $update_homeaddress = mysqli_real_escape_string($conn, $_POST['update_homeaddress']);


   mysqli_query($conn, "UPDATE `user_register` SET name = '$update_name', email = '$update_email', phonenumber
   = '$update_phonenumber', homeaddress = '$update_homeaddress' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user_register` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'password update is  successful!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'profileimage/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_register` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image update is  successful!';
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
   <title>update profile</title>

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
<center><h1>𝕄𝕐 𝕋𝕌𝕋𝕆ℝ</h1></center>
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_register` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="userpic/profile.jpg">';
         }else{
            echo '<img src="profileimage/'.$fetch['image'].'">';
         }
         if(isset($message)){

            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>user name :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>user  email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>phone number :</span>
            <input type="text" name="update_phonenumber" value="<?php echo $fetch['phonenumber']; ?>" class="box">
            <span>home address :</span>
            <input type="text" name="update_homeaddress" value="<?php echo $fetch['homeaddress']; ?>" class="box">
            <span>update  picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter current password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="Update Your Profile" name="upload" class="btn">
      <a href="mainpage.php" class="delete-btn">Main Page</a>
   </form>
   <footer>
   <p>Copyright &copy:2022 NUR MURSYIDA</p>
 
</footer>
</div>

</body>
</html>
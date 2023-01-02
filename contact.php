<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/contact.css">


</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<section>
<h2 class="title">Get In Touch</h2>
<br>
<img class="cimg" src="images/contactimg.png" alt="">
</section>
<br>


<section >
<div class="container-page">
   
   
         <div class="adress details">
         <i class="fas fa-map-marker-alt conticon"></i>
         <br><br>
         <div class="topic">Address</div> 
         <div class="text-one">Jorden</div>
         </div>



         <div class="phone details">
         <i class="fas fa-phone-alt conticon"></i>
         <br><br>
         <div class="topic">Phone</div> 
         <div class="text-one">0771234567</div>
         </div>


         <div class="email details">
         <i class="fas fa-envelope conticon"></i>
         <br><br>
         <div class="topic">Email</div> 
         <div class="text-one">felux@gmail.com</div>
         </div> 
    
      
   
</div>
</section>
<!-- <section class="contact">

   <form action="" method="post">
      <h3>get in touch</h3>
      <input type="text" name="name" placeholder="enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section> -->













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
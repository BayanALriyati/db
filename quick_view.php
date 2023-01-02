<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addTOcart'])){
   $product_id = $_POST['product_id'];
   $product_name = $_POST['name'];
   $product_price = $_POST['price'];
   $product_image = $_POST['image'];
   $product_quantity = $_POST['qty'];

   $send_to_cart = $conn->prepare("INSERT INTO `cart` (user_id , pid , name , price , image , quantity)
                                    VALUES (? , ? , ? , ?, ? , ?)"); 
   $send_to_cart->execute([$user_id , $product_id , $product_name , $product_price, $product_image, $product_quantity]);
}?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/98bf175dbe.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/comment.css">
</head>
<style>
    *{
        font-family:'Times New Roman', Times, serif !important;
        /* font-weight: 900% !important; */
    }
   .heading{
    font-weight:900 !important
   }
    a{
        text-decoration:none !important;
    }
</style>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <p class="heading">quick view</p>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE product_id  = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>

   
   <form action="" method="post" class="box">
      <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <?php 
      if ($fetch_product['is_sale'] == 1){
         ?>
         <input type="hidden" name="price" value="<?=$fetch_product['price_discount'];?>">
         <?php
      } else {
         ?>
         <input type="hidden" name="price" value="<?=$fetch_product['price'];?>">
         <?php
      }
      ?>      <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="./uploaded_img/<?= $fetch_product['image']; ?>" alt="">
            </div>
            
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
            <?php if ($fetch_product['is_sale'] == 1){ ?>

<div class="price"><span><del style="text-decoration:line-through; color:silver">$<?= $fetch_product['price']; ?></del><ins style="color:green; padding:20px 0px"> $<?=$fetch_product['price_discount'];?></ins> </span></div>

<?php } else { ?>

<div class="name" style="color:green;">$<?= $fetch_product['price']; ?></div> <?php } ?>               <input type="number" name="qty" class="qty" min="1" max="99"  value="1">
            </div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="add to cart" class="btn" name="addTOcart">
          
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>
<!-- start add comment -->
<section class="quick-view">
   <h1 class="heading">Review for products</h1>
        <?php
        $query = "SELECT * FROM review INNER JOIN users 
                ON (review.user_id = users.user_id) WHERE product_id = ? ";
                $stmt = $conn->prepare($query);
                $stmt->execute([$pid]);
        while ($comment = $stmt->fetch()) {
           $comment_id = $comment['review_id'];
           $user_id = $comment['user_id'];
           $product_id = $comment['product_id'];
           $comment_date = $comment['review_date'];
           $comment_content = $comment['review_text'];
           $user_name = $comment['name'];
           ?>
                  <h4 class=""><?php echo $user_name ?></h4>
                  <h5><?php echo $comment_date ?></h5>
                  <p><?php echo  $comment_content; ?></p><?php } ?>
                  
         <?php if (isset($_POST['submit_comment'])) {
            if (isset($_SESSION['user_id'])) {
               $comment_text = $_POST['comment_text'];
               $sqlInserComment = "INSERT INTO review (user_id,product_id,review_text,review_date) 
               VALUES ('$user_id','$pid','$comment_text ',NOW())";
               $stmt = $conn->query($sqlInserComment);
               $return_to_page =  $_SERVER['PHP_SELF'];
               header("location:./quick_view.php?pid=$pid");
            }
         }
         if (!$stmt->execute([$pid])) {
            echo "NO";
         }
         ?>
         <?php
         if(isset($_SESSION['user_id'])){ ?>
            <form action="" method="post">
            <div >
               <div>
                  <textarea style="width:1110px; border:2px solid silver"  class="form-control" name="comment_text" cols="12"  rows="3" placeholder="Add your comment" value=""></textarea>
               </div>
            </div>
            <div class="col-md-12 text-right">
               <button type="submit" name="submit_comment" class="btn submit_btn">
                  Submit Now
               </button>
            </div>
            </form>
         <?php } ?> 
</section>

<!-- / -->
<section>
  <div class="container my-5 py-5 text-dark">
    <div class="row d-flex justify-content-center">
      <!-- <div class="col-md-11 col-lg-2 col-xl-7"> -->
        <div class="d-flex flex-start mb-4">
          <img class="rounded-circle shadow-1-strong me-3"
            src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar" width="65"
            height="65" />
          <div class="card">
            <div class="card-body p-4">
              <div class="f-5">
                <h5>Johny Cash</h5>
                <p class="small">3 hours ago</p>
                <p class="fs-3">
                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
                  ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus
                  viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla.
                  Donec lacinia congue felis in faucibus ras purus odio, vestibulum in
                  vulputate at, tempus viverra turpis.
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- ///////////////// -->

      </div>
    </div>
  </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
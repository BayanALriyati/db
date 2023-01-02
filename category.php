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
   $product_id = $_POST['pid'];
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
   <title>category</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">
<?php $cd =$_GET['category'] ;?>
<?php  $select_catogry =" SELECT * FROM category WHERE category_id=? " ;
      $X = $conn-> prepare($select_catogry);
      $X -> execute([$cd]);
      $c = $X->fetch();
      $category_id= $c['category_id'];
      $category_name = $c['category_name'];
      ?>
   <h1 class="heading"><?=$category_name?></h1>

   <div class="box-container">

   <?php
     $category = $_GET['category'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE category_id='$category'"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['product_id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
      
      <a href="quick_view.php?pid=<?= $fetch_product['product_id']; ?>"><img src="uploaded_img/<?= $fetch_product['image']; ?>" alt=""></a>
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">


      <?php if ($fetch_product['is_sale'] == 1){ ?>

<div class="price"><span><del style="text-decoration:line-through; color:silver">$<?= $fetch_product['price']; ?></del><ins style="color:green; padding:20px 0px"> $<?=$fetch_product['price_discount'];?></ins></span></div>
<?php } else { ?>
   <div class="name" style="color:green;">$<?= $fetch_product['price']; ?></div> <?php } ?>         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>

      <input type="submit" value="add to cart" class="btn" name="addTOcart">

   </form>
   <?php
      }
  
      
   }else{
      echo '<p class="empty">no products found!</p>';
   }
   ?>

   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
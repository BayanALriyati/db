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
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <!-- <img src="images/homeneck.png" alt=""> -->
            <!-- <img src="images/homeear.png" alt=""> -->
            <img src="images/homebrack.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <!-- edit text -->
            <h3>latest Bracelet</h3> 
            <a href="shop.php" class="btn" style="background-color:#e0b473; color:black;">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/homear.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>latest Ring</h3>
            <a href="shop.php" class="btn" style="background-color:#e0b473; color:black;">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/homeneck.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>latest Necklace</h3>
            <a href="shop.php" class="btn" style="background-color:#e0b473; color:black;">shop now</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>


<section class="category1">

   <h1 class="title">Category</h1>

   <div class="box-container1">
   <?php  $select_catogry =" SELECT * FROM category " ;
      $X = $conn-> prepare($select_catogry);
      $X -> execute();
      while ($c = $X->fetch() ){
      $category_id= $c['category_id'];
      $category_name = $c['category_name'];
      $image_01 = $c['image_01'];
      

      ?>
      <a href="category.php?category=<?php echo "$category_id" ?>" class="box1">
         <img src="images\<?php echo "$image_01" ?>" alt="" width="30" height="30">
         <h3><?php echo "$category_name" ?></h3>
      </a>
      
      <?php } ?>
   
   </div>

</section>


<section class="home-products">

   <h1 class="heading">Salling products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` where is_sale='1'"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
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
      ?>
      <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
      <a href="quick_view.php?pid=<?= $fetch_product['product_id']; ?>"><img src="uploaded_img/<?= $fetch_product['image']; ?>" alt=""></a>
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
      <?php if ($fetch_product['is_sale'] == 1){ ?>

<div class="price"><span><del style="text-decoration:line-through; color:silver">$<?= $fetch_product['price']; ?></del><ins style="color:green; padding:20px 0px"> $<?=$fetch_product['price_discount'];?></ins> </span></div>

<?php } else { ?>

<div class="name" style="color:green;">$<?= $fetch_product['price']; ?></div> <?php } ?>         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="addTOcart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>







<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
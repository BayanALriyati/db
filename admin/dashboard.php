<?php
// $sql = "SELECT products.product_id,products.name,products.price,products.price_discount,products.image,products.description, category.category_name
// FROM products
// INNER JOIN category ON products.product_id=category.category_id ";
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
<style>
   .flex{
      font-family:'Times New Roman', Times, serif !important;
        /* font-weight: 900 !important; */
   }
   .heading{
    font-weight:900 !important
   }
    
    a{
        text-decoration:none !important;
    }
</style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <div class="zeena">
      <h1 class="heading">Dashboard</h1>
      <img src="../images/zeena12.png" alt="" width="30%">
   </div>

<!-- <h3>welcome!</h3>
         <p><?= $fetch_profile['name']; ?></p>  -->
   <div class="box-container" style="display: flex;align-items: center;">
         
   
      <div class="box" style="
    width: 36rem;">
         <a href="placed_orders.php" class="btn">see orders</a>
      </div>

      <div class="box" style="
    width: 36rem;">
         <a href="products.php" class="btn">see products</a>
      </div>

      <div class="box" style="
    width: 36rem;">
        
         <a href="category.php" class="btn">see category</a>
      </div>

      <div class="box" style="
    width: 36rem;">
      
         <a href="users_accounts.php" class="btn">see users</a>
      </div>

   </div>

</section>


<!-- <div class="dashbg"><img src="../images/dashbg.jpg" alt=""></div> -->


<script src="../js/admin_script.js"></script>
   
</body>
</html>
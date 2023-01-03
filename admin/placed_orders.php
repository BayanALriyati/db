<?php

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
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
       .flex{
      font-family:'Times New Roman', Times, serif !important;
      /* font-weight: 900 !important; */
   }
   .heading{
      font-family:'Times New Roman', Times, serif !important;
    font-weight:900 !important
   }
    
    a{
        text-decoration:none !important;
    }
   table, th, td {
  font-size: large;
 }
</style> 
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Placed Orders</h1>
<div class="col-lg-9 m-auto ">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">  <thead>
    <tr>
      <th scope="col">placed on</th>
      <th scope="col">name</th>
      <th scope="col">number</th>
      <th scope="col">email</th>
      <th scope="col">total products</th>
      <th scope="col">total price</th>
      <th scope="col">order_time</th>
      
    </tr>
  </thead>
  <tbody>

  <?php $select_orders = $conn->prepare("SELECT * 
                                       FROM `orders`
                                       INNER JOIN `users` ON Orders.user_id = users.user_id;");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
    <tr>
      <td><?= $fetch_orders['location']; ?></td>
      <td><?= $fetch_orders['name']; ?></td>
      <td><?= $fetch_orders['number']; ?></td>
      <td><?= $fetch_orders['email']; ?></td>
      <td><?= $fetch_orders['total_quantity']; ?></td>
      <td>JD<?= $fetch_orders['total_price']; ?></td>
      <td><?= $fetch_orders['order_time']; ?></td>
    </tr>

    <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

    

  </tbody>
</table>
<iv>

</section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


<script src="../js/admin_script.js"></script>
   
</body>
</html>
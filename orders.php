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
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
table {
  border-collapse: collapse;
  width: 100%;
  font-size: 17px;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: white;
}
</style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>
   <br>
   <br>
   <div class="box-container">
   <table>
   <tr>
   <th>Placed on</th>
   <th>Name</th>
   <th>Number</th>
   <th>Email</th>
   <th>Total Products</th>
   <th>Total Price </th>
   <th>Order Date</th>
</tr>

   <?php
      $select_orders = $conn->prepare("SELECT * 
                                       FROM `orders`
                                       INNER JOIN `users` ON Orders.user_id = users.user_id;");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            if ($fetch_orders['user_id'] == $user_id){
   ?>
   <tr>
   <td><?= $fetch_orders['location']; ?></td>
   <td><?= $fetch_orders['name']; ?></td>
   <td><?= $fetch_orders['number']; ?></td>
   <td><?= $fetch_orders['email']; ?></td>
   <td><?= $fetch_orders['total_quantity']; ?></td>
   <td>JD<?= $fetch_orders['total_price']; ?> </td>
   <td><?= $fetch_orders['order_time']; ?></td>
</tr>

   <?php
         } }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>
</table>
<div class="box-container">

</section>

<!-- <table>
   <tr>
   <th>placed on</th>
   <th>name</th>
   <th>number</th>
   <th>email</th>
   <th>total products</th>
   <th>total price </th>
   <th>Order Time</th>
</tr>
<tr>
   <th><?= $fetch_orders['location']; ?></th>
   <th><?= $fetch_orders['name']; ?></th>
   <th><?= $fetch_orders['number']; ?></th>
   <th><?= $fetch_orders['email']; ?></th>
   <th><?= $fetch_orders['total_quantity']; ?></th>
   <th>JD<?= $fetch_orders['total_price']; ?> </th>
   <th><?= $fetch_orders['order_time']; ?></th>
</tr>
</table> -->











<!-- <?php include 'components/footer.php'; ?> -->

<script src="js/script.js"></script>

</body>
</html>
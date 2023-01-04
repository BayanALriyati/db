<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE user_id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

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
        font-weight: 900 !important;
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

<section class="accounts">

   <h1 class="heading">User Accounts</h1>
   <div class="col-lg-9 m-auto ">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">  <thead>
    <tr>
      <th scope="col">User Id</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
    <tr>
      <th scope="row"><?= $fetch_accounts['user_id']; ?></th>
      <td><?= $fetch_accounts['name']; ?></td>
      <td><?= $fetch_accounts['email']; ?></td>
      <td><button type="button" ><a href="users_accounts.php?delete=<?= $fetch_accounts['user_id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" ><i class="fa-solid fa-trash delete1"></a></button></td>
      
    </tr>
    <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>


    

  </tbody>
</table>
<iv>
   </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>
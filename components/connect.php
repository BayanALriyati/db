<?php 

$db_name = 'mysql:host=localhost;dbname=shop_db';
$user_name = 'root';
$user_password = '';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       //SILENT
       //WARNING
  );
$conn = new PDO($db_name, $user_name, $user_password,$options);


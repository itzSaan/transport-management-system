<?php 
 $host = 'localhost';
 $username = 'root';
 $password = '';
 $db_name = 'db_tms';

//  //Create connection
 $conn = new mysqli($host, $username, $password, $db_name);
 //check connection
 if ($conn->connect_error) {
    die ('Connection failed: ' . $conn->connect_error);
 }
//  echo 'Connected successfully!';

// PDO Connection 
//  try {
//     $conn = new PDO("mysql:host=$host;dbname=db_tms", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo 'Connection to DB is successful!';
//    } catch (PDOException $err) {
//       echo "Connection Failed: " . $err->getMessage();
//    }
   


?>
<?php

require './config/config.php';
session_start();

$title = "Transport Management System";
include('./components/header.php');
include('./components/navbar.php');
?>

<main>
   <div class="container">
      <div class="text-center mb-3">
         <h1 class="lead fs-1">Book a Slot</h1>
      </div>
      <div class="row justify-content-center">
         <div class="col-sm-3">
            <a href="./pages/newBooking.php" class="card p-3 text-center text-decoration-none text-bg-dark">
               <span class="bi bi-car-front fs-1"></span>
               <span class="fs-2 lead">Pickup</span>
            </a>
         </div>
         <div class="col-sm-3">
            <a href="./pages/newBooking.php" class="card p-3 text-center text-decoration-none text-bg-warning">
               <span class="bi bi-car-front-fill fs-1"></span>
               <span class="fs-2 lead">Drop</span>
            </a>
         </div>
      </div>
   </div>
</main>

<?php

include('./components/footer.php');

?>
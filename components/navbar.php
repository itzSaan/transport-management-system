<?php 
$pageUrl = $_SERVER['PHP_SELF'];
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm" style="height: 72px;">
  <div class="container py-2">
    
    <a class="navbar-brand" href="/">
      <img src="../img/tms-logo.png" height="48" alt="">
      <!-- Transport Management System -->
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <!-- <li class="nav-item">
          <a class="nav-link <?= ($pageUrl == '/index.php' || $pageUrl == '/') ? 'active' : '' ?>" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($pageUrl == '/pages/newBooking.php') ? 'active' : '' ?>" href="../pages/newBooking.php">Book a Ride</a>
        </li> -->
        <li class="nav-item ">
          <a class="nav-link text-bg-primary px-3 rounded-2 nav-link-pill<?= ($pageUrl == '/pages/login.php') ? 'active' : '' ?>" href="../pages/login.php">
            Sign in <i class="bi bi-arrow-right"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
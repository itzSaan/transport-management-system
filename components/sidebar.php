<?php
// echo $_SESSION['user']; 
$pageURL = $_SERVER["PHP_SELF"];
?>

<!--Sidebar static sidebar-->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-flex flex-column sidebar collapse">
  <div class="text-center mt-5"><img src="../img/user.png" width="50%" alt=""></div>
  <div class="position-sticky pt-3">
    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link <?php echo ($pageURL =='/pages/admin.php' || $pageURL=='/pages/userDashboard.php') ? 'active' : '' ?>" aria-current="page" href="../pages/admin.php">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>
      <?php if ($_SESSION['user'] !== '' && $_SESSION['user'] !== 'sangramm7@gmail.com') { ?>
      <li class="nav-item">
        <a href="../pages/newBooking.php" class="nav-link <?php echo ($pageURL =='/pages/newBooking.php' ) ? 'active' : '' ?>">
          <span class="" data-feather="plus-square"></span>
          New Booking
        </a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a href="../pages/manageBookings.php" class="nav-link <?php echo ($pageURL =='/pages/manageBookings.php')?'active':'' ?>">
          <span class="" data-feather="edit"></span>
          Manage Bookings
        </a>
      </li>

      <?php if ($_SESSION['user'] == 'sangramm7@gmail.com') { ?>
        <li class="nav-item"><a href="../pages/addRoute.php" class="nav-link <?php echo ($pageURL =='/pages/addRoute.php')?'active':'' ?>"><span class="" data-feather="plus-square"></span>Add Route</a></li>
        <li class="nav-item"><a href="../pages/manageRoutes.php" class="nav-link <?php echo ($pageURL =='/pages/manageRoutes.php')?'active':'' ?>"><span class="" data-feather="edit"></span>Manage Routes</a></li>
        <li class="nav-item"><a href="../pages/manageUsers.php" class="nav-link <?php echo ($pageURL =='/pages/manageUsers.php')?'active':'' ?>"><span class="" data-feather="edit"></span>Manage Users</a></li>
      <?php }  ?>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="bar-chart-2"></span>
          Reports
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($pageURL =='/pages/updateProfile.php')?'active':'' ?>" href="/pages/updateProfile.php">
          <span data-feather="user"></span>
          My Profile
        </a>
      </li>
    </ul>

    <!-- sidebar footer  -->
  </div>
  <div class="sidebar-footer text-center mt-auto mb-3">
    <small class="text-secondary">&copy; WiseTech Inc.</small>
  </div>
</nav>
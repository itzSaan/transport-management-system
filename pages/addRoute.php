<?php

session_start();
require '../config/config.php';

$title = "Admin | Add Route";
if (!isset($_SESSION['user'])) {
    print("You're not Logged in, ");
    header('location:login.php');
} else if ($_SESSION['user'] == 'sangramm7@gmail.com') {

    require '../components/header.php';
    require '../components/adminNavbar.php';

?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">Add Route</p>
                </div> <!--main area header-->

                <!--Post manage-->
                <div class="container-fluid p-4">
                    <?php 
                    $origin = $destination = $distance = $fare =  $status = '';
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $origin = $_POST['origin'];
                        $destination = $_POST['destination'];
                        $distance = $_POST['distance'];
                        $fare = $_POST['fare'];
                    
                        $sql = "INSERT INTO routes(origin, destination, distance, fare) VALUES(\"$origin\", \"$destination\", \"$distance\", \"$fare\")";
                        if ($conn->query($sql) == TRUE) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Well done!</strong> Route Added Successfully.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                       <?php } else { ?>
                        <div class="alert alert-success alert-dismissible fade " role="alert">
                        <strong>Error!</strong> <?php echo $conn->error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                      <?php  }
                    }
                    ?>                    
                    <form method="post" action="" id="addRouteForm">
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <label for="origin" class=" col-auto form-label">Origin</label>
                                <input type="text" name="origin" class="form-control" id="origin" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="destination" class="col form-label">Destination</label>
                                <input type="text" name="destination" class="form-control" id="destination" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="distance" class="col form-label">Distance</label>
                                <input type="number" step="0.01" name="distance" class="form-control" id="distance" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="fare" class="col form-label">Fare</label>
                                <input type="number" step="0.01" name="fare" class="form-control" id="fare" required>
                            </div>
                            <div class="col-auto ms-auto">
                                <button type="submit" class="btn btn-primary me-3 px-4">Add Route</button>
                                <button type="reset" class="btn btn-danger px-4">Cancel/Reset</button>
                            </div>
                        </div>
                    </form>
                </div>

            </main>

            <?php require '../components/footer.php'; ?>
        </div> <!--row-->

    </div> <!--Container-fluid-->

<?php } else {
    header('location:userDashboard.php');
}

?>


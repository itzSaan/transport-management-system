<?php

session_start();
require '../config/config.php';

$title = "Manage Routes";
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    echo "You're not Logged in, ";
} else if ($_SESSION['user'] == 'sangramm7@gmail.com') {

    require '../components/header.php';
    require '../components/adminNavbar.php';

    // For Delete Routes
    if(isset($_GET['action']) && $_GET["action"]=='del' && isset($_GET['route_id'])) {
        $id=intval($_GET['route_id']);
        $query=mysqli_query($conn,"delete from routes  where route_id='$id'");
        $delmsg="Category deleted forever";
    }

?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">Manage Routes</p>
                </div> <!--main area header-->

                <!--Post manage-->
                <div class="container-fluid">
                    <?php 
                        $sql = "SELECT * FROM `routes`";
                        $result = $conn->query($sql);     
                        
                        if ($result->num_rows > 0) { ?>
                    <table class="table table-hover">
                        <thead class="bg-success bg-gradient text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Origin</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Distance</th>
                                <th scope="col">Fare</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $result->fetch_assoc()) {
                                ?>
                            <tr>
                                <th scope="row"><?php echo $row['route_id'] ?></th>
                                <td><?php echo $row['origin'] ?></td>
                                <td><?php echo $row['destination'] ?></td>
                                <td><?php echo $row['distance'] ?> km</td>
                                <td><?php echo $row['fare'] ?>.00</td>
                                <td>
                                    <a href=""><i data-feather="edit" class="text-primary"></i></a>
                                    <a href="manageRoutes.php?route_id=<?php echo htmlentities($row['route_id']);?>&&action=del"><i class="text-danger ms-2" data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php } } else {
                              echo  '<div class="alert alert-danger" role="alert">
                                No Routes Found! Please Add Some
                              </div>';
                            } ?>
                        </tbody>
                    </table>

                </div>

            </main>

            <?php require '../components/footer.php'; ?>
        </div> <!--row-->

    </div> <!--Container-fluid-->

<?php } else {
    header('location:userDashboard.php');
}
?>
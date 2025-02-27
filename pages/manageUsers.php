<?php

session_start();
require '../config/config.php';
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    echo "You're not Logged in, ";
} else if ($_SESSION['user'] == 'sangramm7@gmail.com') {
    $title = "Admin | Manage Users";
    require '../components/header.php';
    require '../components/adminNavbar.php';

?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">Manage Users</p>
                    <!-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Library</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav> -->
                </div> <!--main area header-->

                <!--Post manage-->
                <div class="container-fluid">
                    <?php 
                        $sql = "SELECT * FROM `users`";
                        $result = $conn->query($sql);
                       
                        // if($result->num_rows > 0) {
                        //    echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Username</th><th>Password</th></tr>";
                        //    // output data of each row
                        //    while($row = $result->fetch_assoc()) {
                        //       echo "<tr><td>".$row["user_id"]."</td><td>".$row["full_name"]."</td><td>".$row["email"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td></tr>";
                        //    }
                        //    echo "</table>";
                        //    } else {
                        //    echo "0 results";
                        // }                    
                    ?>
                    <?php if ($result->num_rows > 0) { ?>
                    <table class="table table-hover">
                        <thead class="bg-success bg-gradient text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $result->fetch_assoc()) {
                                ?>
                            <tr>
                                <th scope="row"><?php echo $row['user_id'] ?></th>
                                <td><?php echo $row['full_name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td>
                                    <a href=""><i data-feather="edit" class="text-primary"></i></a>
                                    <a href=""><i class="text-danger ms-2" data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php } } else {
                              echo  '<div class="alert alert-danger" role="alert">
                                No Users Found!
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
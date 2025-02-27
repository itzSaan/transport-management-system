<?php

session_start();
require '../config/config.php';
$title = "Admin | Dashboard";
if (!isset($_SESSION['user'])) {
    echo "You're not Logged in.";
    header('location:login.php');
    exit(); // Ensuring no further code is executed if not logged in
} else if ($_SESSION['user'] == 'sangramm7@gmail.com') {

    require '../components/header.php';
    require '../components/adminNavbar.php';

    $query = "SELECT b.booking_id, b.datetime, b.status
                FROM bookings b
                JOIN users u ON b.user_id=u.user_id";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $allbookings = [];
    $pendingbookings = [];
    $approvedbookings = [];
    $rejectedbookings = [];

    while($row = $result->fetch_assoc()) {
        $allbookings[] = $row;
        if($row['status'] == "pending") {
            $pendingbookings[] = $row;
        }
        elseif($row['status'] == "approved") {
            $approvedbookings[] = $row;
        }
        elseif($row['status'] == "rejected") {
            $rejectedbookings[] = $row;
        }
    }

    $stmt->close();
?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">Dashboard</p>
                </div> <!--main area header-->

                <div class="container-fluid p-4">
                    <div class="row gy-3">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-bg-primary border-0 p-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="fs-6">Total Booking</p>
                                    <h5 class="lead fs-1"><?php echo count($allbookings) ?></h5>
                                    <span class="bi bi-stack fs-2 position-absolute bottom-0" style="opacity: 0.3;"></span>
                                </div>
                                <a href="../pages/manageBookings.php" class="btn btn-sm btn-dark ms-auto flex-shrink-0">View all</a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-bg-warning border-0 p-3">
                                <div class=" d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="fs-6">Pending Booking</p>
                                    <h5 class="lead fs-1"><?php echo count($pendingbookings) ?></h5>
                                    <span class="bi bi-hourglass-split fs-2 position-absolute bottom-0" style="opacity: 0.3;"></span>
                                </div>
                                <a href="../pages/manageBookings.php" class="btn btn-sm btn-dark ms-auto flex-shrink-0">View all</a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-bg-success border-0 p-3">
                                <div class=" d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="fs-6">Approved Booking</p>
                                    <h5 class="lead fs-1"><?php echo count($approvedbookings) ?></h5>
                                    <span class="bi bi-ui-checks fs-2 position-absolute bottom-0" style="opacity: 0.3;"></span>
                                </div>
                                <a href="../pages/manageBookings.php" class="btn btn-sm btn-dark ms-auto flex-shrink-0">View all</a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-bg-danger border-0 p-3">
                                <div class=" d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="fs-6">Rejected Booking</p>
                                    <h5 class="lead fs-1"><?php echo count($rejectedbookings) ?></h5>
                                    <span class="bi bi-trash3 fs-2 position-absolute bottom-0" style="opacity: 0.3;"></span>
                                </div>
                                <a href="../pages/manageBookings.php" class="btn btn-sm btn-dark ms-auto flex-shrink-0">View all</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="h5">Latest Bookings</p>
                </div> <!--main area header-->

            </main>

            <?php require '../components/footer.php'; ?>
        </div> <!--row-->

    </div> <!--Container-fluid-->

<?php } else {
    header('location:userDashboard.php');
}
?>
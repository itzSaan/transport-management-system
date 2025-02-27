<?php

session_start();
require '../config/config.php';
$title = "Manage Bookings";
$admin = "sangramm7@gmail.com";

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    echo "You're not Logged in, Please Login ";
} else  {

    require '../components/header.php';
    require '../components/adminNavbar.php';

    // For Delete bookings
    if(isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['booking_id'])) {
        $id=intval($_GET['booking_id']);
        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute())
            $delmsg="Booking deleted successfully!";
        else
            $delmsg = "Error" / $conn->error;
    }
    //For edit (Approve Bookings)
    if(isset($_GET['action']) && $_GET['action'] == 'approve' && isset($_GET['booking_id'])) {
        $id=intval($_GET['booking_id']);
        $stmt = $conn->prepare("UPDATE bookings SET status='approved' WHERE booking_id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute())
            $delmsg="Booking Approved successfully!";
        else
            $delmsg = "Error" / $conn->error;
    }
    //For edit (reject Bookings)
    if(isset($_GET['action']) && $_GET['action'] == 'reject' && isset($_GET['booking_id'])) {
        $id=intval($_GET['booking_id']);
        $stmt = $conn->prepare("UPDATE bookings SET status='rejected' WHERE booking_id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute())
            $delmsg="Booking Rejected successfully!";
        else
            $delmsg = "Error" / $conn->error;
    }
?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">Manage Bookings</p>
                </div> <!--main area header-->

                <!--Post manage-->
                <div class="container-fluid p-4">
                <?php 
                    $sql = "SELECT * FROM bookings b 
                            JOIN routes r ON b.route_id = r.route_id 
                            JOIN users u ON b.user_id = u.user_id";
                    if($_SESSION['user']!=$admin) {
                        $email = $_SESSION["user"];
                        $sql .= " WHERE u.email = '$email'";
                    }
                        $result = $conn->query($sql);
                        $sn = 1;     
                        
                        if ($result->num_rows > 0) { ?>
                    <table class="table table-hover">
                        <thead class="bg-success bg-gradient text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Route ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Origin</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Date Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $result->fetch_assoc()) {
                                ?>
                            <tr class="table-<?php 
                                if($row['status']=='pending')
                                    echo 'warning';
                                elseif($row['status']=='approved')
                                    echo 'success';
                                else echo 'danger';
                            
                            ?>">
                                <th scope="row"><?php echo $sn++ ?></th>
                                <td><?php echo $row['booking_id'] ?></td>
                                <td><?php echo $row['route_id'] ?></td>
                                <td><?php echo $row['full_name'] ?></td>
                                <td><?php echo $row['origin'] ?></td>
                                <td><?php echo $row['destination'] ?></td>
                                <td><?php echo $row['datetime'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td>
                                    <?php if ($_SESSION['user'] == $admin) { ?>
                                    <a href="" data-bs-target="#editModal" data-bs-toggle="modal" data-id="<?php echo $row["booking_id"] ?>"><i data-feather="edit" class="text-primary"></i></a>
                                        <?php } ?>
                                    <a href=""
                                        data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo htmlentities($row['booking_id']); ?>" >
                                        <i class="text-danger ms-2" data-feather="trash-2"></i>
                                    </a>

                                    <!-- Edit Booking Modal -->
                                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Approve Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Name:</strong> <?php echo $row["full_name"] ?></p>
                                            <p><strong>Origin:</strong> <?php echo $row["origin"] ?></p>
                                            <p><strong>Destination:</strong> <?php echo $row["destination"] ?></p>
                                            <p><strong>Date & Time:</strong> <?php echo $row["datetime"] ?></p>
                                            Are you sure you want to Approve this booking?
                                        </div>
                                        <div class="modal-footer">
                                            <a id="approveBooking" href="#" class="btn btn-success">Approve</a>
                                            <a id="rejectBooking" href="#" class="btn btn-danger">Reject</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this booking?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a id="confirmDelete" href="#" class="btn btn-danger">Delete</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                </td>
                            </tr>
                            <?php } } else {
                              echo  '<div class="mt-5 d-flex flex-column align-items-center justify-content-center">
                              <img class="mb-4 img-fluid" src="../img/undraw_empty.svg" width="300" alt="" />
                                <h1>Uh-ho!..</h1>
                                <h5>No Bookings Found! <br>Please Book <a href="/pages/newBooking.php" class="link text-primary">Here</a></h5>
                              </div>';
                            } ?>
                        </tbody>
                    </table>                        
                </div>

            </main>

            <script>
                const editModal = document.getElementById("editModal")
                editModal.addEventListener("shown.bs.modal", (event)=> {
                    const btn = event.relatedTarget
                    const bookingId = btn.getAttribute("data-id")
                    const approveBooking = document.getElementById("approveBooking")
                    const rejectBooking = document.getElementById("rejectBooking")
                    approveBooking.href = 'manageBookings.php?booking_id=' + bookingId + '&action=approve'
                    rejectBooking.href = 'manageBookings.php?booking_id=' + bookingId + '&action=reject'
                })
                const deleteModal = document.getElementById("deleteModal")
                deleteModal.addEventListener('shown.bs.modal', (event)=> {
                    const btn = event.relatedTarget
                    const bookingId = btn.getAttribute('data-id');

                    const confirmDelete = document.getElementById("confirmDelete");
                    confirmDelete.href = 'manageBookings.php?booking_id=' + bookingId + '&action=del'
                })
            </script>

            <?php require '../components/footer.php'; ?>
        </div> <!--row-->

    </div> <!--Container-fluid-->

<?php } ?>
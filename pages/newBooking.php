<?php

use function PHPSTORM_META\type;

session_start();
require '../config/config.php';
if (!isset($_SESSION['user'])) {
    print("You're not Logged in, ");
    header('location:login.php');
    exit();
} else {
    $title = "New Booking";
    require '../components/header.php';
    require '../components/adminNavbar.php';

    // Form1 Handling
    $successMsg = $errorMsg = "";
    $routeid = $datetime = "";
    $email = $_SESSION['user'];
    $useridresult = $conn->query("SELECT user_id FROM `users` WHERE email=\"$email\"");
    $row =  $useridresult->fetch_assoc();
    $userid = $row['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["bookSlotForm1-submit"])) {
        $routeid = $_POST['route'];
        $datetime = $_POST['datetime'];

        $sql = "INSERT INTO bookings (user_id, route_id, datetime) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $userid, $routeid, $datetime);
        if ($stmt->execute()) {
            $successMsg = "Booking Done Successfully!";
        } else {
            $errorMsg = "Error: " . $conn->error;
        }
    }

    // Form2 Handling
    $origin = $destination = $distance = $datetime = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookSlotForm2-submit"])) {
        $origin = $_POST["origin"];
        $destination = $_POST["destination"];
        $distance = $_POST["distance"];
        $datetime = $_POST["datetime"];
        $conn->begin_transaction();

        try {
            $stmt1 = $conn->prepare("INSERT INTO routes (origin, destination, distance) VALUES (?,?,?)");
            $stmt1->bind_param("ssd", $origin, $destination, $distance);
            if ($stmt1->execute()) {
                $routeid = $conn->insert_id; // getting the latest inserted id
                $stmt2 = $conn->prepare("INSERT INTO bookings (user_id, route_id, datetime) VALUES (?,?,?)");
                $stmt2->bind_param("iis", $userid, $routeid, $datetime);

                if ($stmt2->execute()) {
                    $conn->commit();
                    $successMsg = "Route added & Booking Done Successfully!";
                } else {
                    $conn->rollback();
                    $errorMsg = "Error" . $stmt2->error;
                }
            } else {
                $conn->rollback();
                $errorMsg = "Error" . $stmt1->error;
            }
        } catch (Exception $e) {
            $conn->rollback();
            $errorMsg = "Transaction failed: " . $e->getMessage();
        }
    }

?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
                    <p class="fs-3 lead mb-0">New Bookings</p>
                </div> <!--main area header-->

                <!--Post manage-->
                <div class="container-fluid p-4">
                <?php if($successMsg != "") {?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $successMsg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                        <?php }?>

                        <?php if($errorMsg != "") {?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $errorMsg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                        <?php }?>
                    <div class="row justify-content-between gy-3">
                        <div class="col-lg-5">
                            <form method="post" action="" id="bookSlotForm1">
                            <p class="lead pb-3 border-bottom">Select a Route from list</p>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <label for="route" class=" col-auto form-label">Route</label>
                                    <select name="route" id="route" class="form-select" required>
                                        <option selected>Select a Route</option>
                                        <?php
                                        $sql = "SELECT route_id, origin, destination FROM `routes`";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $row['route_id'] ?>"><?php echo $row['origin'] . "-" . $row['destination'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">No Routes Found</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="destination" class="col form-label">Pickup/Drop Time</label>
                                    <input type="datetime-local" name="datetime" class="form-control" id="destination" required>
                                </div>
                                <div class="col-auto ms-auto">
                                    <button type="submit" name="bookSlotForm1-submit" class="btn btn-primary me-3 px-4">Book Slot</button>
                                    <button type="reset" class="btn btn-danger px-4">Cancel/Reset</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        
                    <div class="text-center col-lg-auto ol-md align-self-center">
                        <h3 class="lead fs-2">OR</h3>
                    </div>

                        <div class="col-lg-5">
                        <form method="post" action="" id="bookSlotForm2">
                            <p class="lead pb-3 border-bottom">Craete a new Route</p>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <label for="origin" class=" col-auto form-label">Origin</label>
                                    <input type="text" name="origin" class="form-control" id="origin" placeholder="Enter Origin" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="destination" class="col form-label">Destination</label>
                                    <input type="text" name="destination" class="form-control" id="destination" placeholder="Enter Destination" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="distance" class="col form-label">Distance</label>
                                    <input type="number" step="0.01" name="distance" class="form-control" id="distance" placeholder="Enter Distance" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="destination" class="col form-label">Pickup/Drop Time</label>
                                    <input type="datetime-local" name="datetime" class="form-control" id="destination" required>
                                </div>
                                <div class="col-auto ms-auto">
                                    <button type="submit" name="bookSlotForm2-submit" class="btn btn-primary me-3 px-4">Book Slot</button>
                                    <button type="reset" class="btn btn-danger px-4">Cancel/Reset</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    
                </div>

            </main>

            <?php  require '../components/footer.php'; ?>
        </div> <!--row-->

    </div> <!--Container-fluid-->

<?php } ?>
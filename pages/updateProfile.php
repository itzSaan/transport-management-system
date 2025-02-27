<?php
session_start();
require '../config/config.php';
if (!isset($_SESSION['user'])) {
    print("You're not Logged in, ");
    header('location:login.php');
} else {
    $title = "Update Profile";
    require '../components/header.php';
    require '../components/adminNavbar.php';
    // $status = $email = $new_name = $new_username = $name = $uname = "";
    $successMessage = "";
    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST["email"];
        $new_name = $_POST["name"];
        $new_username = $_POST["username"];
        if (strlen($new_username) <= 4) {
            $errorMessage = "Please Provide a username fo length greater than 4.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET full_name=?, username=? WHERE users.email=?");
            $stmt->bind_param("sss", $new_name, $new_username, $email);
            if ($stmt->execute()) {
                $successMessage = "User Details updated Successfully!";
            } else $errorMessage = "Error" . $conn->error;
        }
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $name = $row['full_name'];
    $uname = $row['username'];

?>

    <div class="container-fluid">
        <div class="row">
            <?php require '../components/sidebar.php' ?>

            <!--Main area-->
            <main class="col-md-9 col-lg-10 ms-sm-auto h-content px-md-4">

                <!--User Details Area-->
                <div class="container-fluid">
                    <?php if ($errorMessage != "") { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $errorMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if ($successMessage != "") { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $successMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div class="my-4 shadow rounded-4 p-4 w-50 w-md-full mx-auto">
                    <p class="fs-3 mb-0 lead text-center">Your Profile</p>
                    <p class="text-secondary text-center border-bottom pb-3">Your Details are safe with us</p>
                    
                        <p class="d-flex justify-content-between"><span class="fw-bold">Name: </span><?php echo $name ?></p>
                        <p class="d-flex justify-content-between"><span class="fw-bold">Email Id: </span> <?php echo $email ?></p>
                        <p class="d-flex justify-content-between"><span class="fw-bold">Username: </span><?php echo $uname ?></p>
                        <button  class="btn btn-primary d-block ms-auto" onclick="showEditProfile()">Edit Profile</button>
                    </div>

                    <div class="update-profile my-5" style="display: none">
                        <div class="shadow rounded-4 p-4 w-50 mx-auto">
                        <p class="fs-3 mb-0 lead text-center">Update Profile</p>
                        <p class="text-secondary text-center border-bottom pb-3">Update your Details</p>
                        <form action="updateProfile.php" method="post">
                            <div class="row">
                                <div class="col-sm-12 mb-4">
                                    <label for="name" class="col form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $name ?>" required>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <label for="email" class="col form-label">Email</label>
                                    <input type="email" name="email" class="form-control" readonly id="email" value="<?php echo $email ?>">
                                </div>

                                <div class="col-sm-12 mb-4">
                                    <label for="username" class="col form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" value="<?php echo $uname ?>">
                                </div>

                            </div>
                            <input class="btn btn-primary d-block ms-auto" type="submit" value="Update Details">
                        </form>
                    </div>
                    </div>
                </div>

            </main>

        </div> <!--row-->
        
    </div> <!--Container-fluid-->
    <script>
        const showEditProfile = () => {
            const div = document.querySelector('.update-profile');
            div.style.display === 'none' ? div.style.display = 'block' : div.style.display = 'none';            
        }
    </script>
    <?php require '../components/footer.php'; ?>

<?php }
?>
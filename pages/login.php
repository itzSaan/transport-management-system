<?php

require '../config/config.php';

session_start();
$title = "Login";
require '../components/header.php';
require '../components/navbar.php';
$status = "";
$email = $password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $encrypted = crypt($password, $password);

    $sql = "SELECT email, password FROM users where email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($result->num_rows == 0) {
        $status = "Email Id not found!";
    } else if (password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $email;
        header('Location: ./admin.php');
        exit();
    } 
    else {
        $status = "Password is incorrect.";
    }
}
?>

<div class="container">
    <div class="card mt-5 mx-auto p-4 shadow border-0" style="width: 24rem">
        <p class="lead  fs-3 text-center">Log in</p>
        <?php if($status!=="") { ?>
        <div class="alert alert-danger"><?php echo $status ?></div>
        <?php } ?>
        <form action="login.php" method="post" id="userLogInForm">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" placeholder="Enter Email" name="email" id="Email" required>
                <label for="Email" class="col-auto col-form-label">Email</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" placeholder="Enter Password" name="password" minlength="6" id="inputPassword" required>
                <label for="inputPassword" class="col-auto col-form-label">Password</label>
            </div>
            
            <div class="my-3 row">
                <div class="col-sm-12">
                    <small>Forgot your Password ? <a href="/pages/resetPassword.php">Reset Password</a></small>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary py-3 w-100">Log in</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <small>Don't have an account ? <a href="/pages/register.php">Register</a></small>
                </div>
            </div>

        </form>
    </div>
</div>


<?php

require '../components/footer.php';

$conn->close();

?>
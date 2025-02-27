<?php
require '../config/config.php';

session_start();
$title = "Admin | Reset Password";

require '../components/header.php';
require '../components/navbar.php';

$email = $password = $status = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row["count"] > 0 && $password == $repassword) {
        $encrypted = crypt($password, $password);
        $sql = "UPDATE users SET password = ? WHERE users.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $encrypted, $email);
        if ($stmt->execute()) {
            $status = "Password Reset Successfully!";
        }
        else $error = "Error occured! please try again.";
    } else {
        $error = "Email Id not found!";
    }
}

?>

<div class="container">
    <div class="card mt-5 mx-auto p-4 shadow border-0" style="width: 24rem">
        <p class="lead  fs-3 text-center">Reset Password</p>
        <?php if($error!=="") { ?>
        <div class="alert alert-danger"><?php echo $error ?></div>
        <?php } ?>
        <?php if($status!=="") { ?>
        <div class="alert alert-success"><?php echo $status ?></div>
        <?php } ?>
        <form action="resetPassword.php" method="post" id="passwordResetForm">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" placeholder="Enter Email" name="email" id="Email" required>
                <label for="Email" class="col-auto col-form-label">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Enter Password" name="password" id="inputPassword" minlength="6" required>
                <label for="inputPassword" class="col-auto col-form-label">New Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="repassword" id="reInputPassword" minlength="6" required>
                <label for="reInputPassword" class="col-auto col-form-label">Confirm Password</label>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-dark py-3 w-100">Reset Password</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const email = document.querySelector('#Email')
    const password = document.querySelector('#inputPassword')
    const confirmPassword = document.querySelector('#reInputPassword')

    
    function isValidEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }
    email.addEventListener('input', ({target})=> {
        emailValid = isValidEmail(target.value)
        if(emailValid) {
            email.classList.add('is-valid')
            email.classList.remove('is-invalid')
        } else {
            email.classList.add('is-invalid')
            email.classList.remove('is-valid')
        }
    })

    password.addEventListener('input', ({target}) => {
        console.log(target.value.length)
        if(target.value.length >= 6) {
        password.classList.add("is-valid")
        password.classList.remove("is-invalid")
    } else {
        password.classList.add("is-invalid")
        password.classList.remove("is-valid")
    }
})
    confirmPassword.addEventListener('input', (e) => {
        let val = e.target.value;
        if(password.value == val) {
            console.log("matched")
            confirmPassword.classList.add('is-valid');
            confirmPassword.classList.remove('is-invalid');
        } else {
            confirmPassword.classList.add('is-invalid');
            confirmPassword.classList.remove('is-valid');
        }
    })
</script>

<?php

require '../components/footer.php';

$conn->close();

?>
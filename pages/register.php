<?php

require '../config/config.php';
$title = "Register";
require '../components/header.php';
require '../components/navbar.php';

$fullName = $email = $password = $confirm_password = $status = "";
$duplicateEmail = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $encrypted = crypt($password, $confirm_password);

    // Prepare a statement to check for duplicate email
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['count'] > 0) {
        $duplicateEmail = true;
        $status = "Email Id already registered!";
    } else if ($password == $confirm_password && $duplicateEmail == false) {
        $sql = "INSERT INTO users(full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $fullName, $email, $encrypted);
        if ($stmt->execute()) {
            $status = "User Registration Successfully!";
        } else {
            $status = "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $status = "Password not matching!";
    }
}

?>

<div class="container">
    <div class="card mt-5 mx-auto p-4 shadow border-0" style="width: 24rem">
        <p class="lead  fs-3 text-center">Register</p>
        <?php if($status!=="") { ?>
        <div class="alert alert-danger"><?php echo $status ?></div>
        <?php } ?>
        <form method="post" action="register.php" id="userRegisterForm">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" placeholder="Enter Name" name="name" id="Name" minlength="7" required>
                <label for="Name" class="">Full Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" placeholder="Enter Email" name="email" id="Email" required>
                <label for="Email" class="">Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Enter Password" name="password" minlength="6" id="inputPassword" required>
                <label for="inputPassword" class="">Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Re-enter Password" name="confirm-password" minlength="6" id="inputConfirmPassword" required>
                <label for="inputConfirmPassword" class="">Confirm Password</label>
            </div>
            <div class="my-3 row">
                <div class="col-sm-12">
                    <small>Already have an account ? <a href="/pages/login.php">Log in</a></small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary py-3 w-100">Register</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const email = document.querySelector('#Email')
    const name = document.querySelector('#Name')
    const password = document.querySelector('#inputPassword')
    const confirmPassword = document.querySelector('#inputConfirmPassword')

    
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
    name.addEventListener('input', ({target})=> {
        if(target.value.length >= 7) {
            name.classList.add('is-valid')
            name.classList.remove('is-invalid')
        } else {
            name.classList.add('is-invalid')
            name.classList.remove('is-valid')
        }
    })

    password.addEventListener('input', ({target}) => {
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
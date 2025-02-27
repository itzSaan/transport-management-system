<nav class="navbar bg-white d-flex px-4 py-3 sticky-top shadow-sm">
    <div class="container-fluid">
        <h3 class="navbar-brand mb-0"><?php echo $_SESSION['user']== 'sangramm7@gmail.com' ?  'Admin' :  'User'; ?> Dashboard</h3>
        <div class="dropdown float-right">
            <div class="notification d-inline">
                <a href="#" class="btn btn-sm text-success rounded-circle"> <span data-feather="mail"></span>
                    <span class="position-absolute top-0 start-10 translate-middle badge rounded-pill bg-danger">+9 <span class="visually-hidden">unread messages</span></span>
                </a>
                <a href="#" class="btn btn-sm text-danger rounded-circle"> <span data-feather="bell"></span></a>
                <a href="#" class="btn btn-sm text-info rounded-circle"> <span data-feather="search"></span></a>
            </div>
            <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i data-feather="user"></i> 
                <?php echo $_SESSION['user']; ?>
            </a>
            <ul class="dropdown-menu mt-2 dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="../pages/updateProfile.php"><i data-feather="edit"></i> Update Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../pages/logout.php"><i data-feather="log-out"></i> Log out</a></li>
            </ul>

        </div>
    </div>
</nav>
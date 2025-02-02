<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ed4167ae3c.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        .active {
            background-color: #f0f0f0;
            border-left: 4px solid #000;
        }
    </style>
</head>

<body>
    <?php
    // Get the current file name
    $current_page = basename($_SERVER['REQUEST_URI']);
    ?>
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href="../pages/index.php" target="_blank">
                <i class="fa-solid fa-k fa-xl" style="color: #737373;"></i>
                <span class="ms-1 text-sm text-dark">Kiran Dhoke</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="../pages/index.php">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?= ($current_page == 'tables.php') ? 'active' : ''; ?>" href="../pages/tables.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Tables</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?= ($current_page == 'profile.php') ? 'active' : ''; ?>" href="../pages/profile.php">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item" id="login-Div">
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0">
            <div class="mx-3">
                <p>Made By <b style="color: black;">Kiran Dhoke</b></p>
            </div>
        </div>
    </aside>
</body>
</html>

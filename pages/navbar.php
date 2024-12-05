<?php
$fullPath = $_SERVER['PHP_SELF'];
$currentPage = basename($fullPath);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb" class="d-flex justify-content-between w-100">
        <div>
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <?php if ($currentPage == "index.php"): ?>
            <li class="breadcrumb-item text-sm text-dark " aria-current="page">Dashboard</li>
            <?php elseif($currentPage == "tables.php"): ?>
            <li class="breadcrumb-item text-sm text-dark " aria-current="page">Tables</li>
            <?php else: ?>
            <li class="breadcrumb-item text-sm text-dark " aria-current="page">Profile</li>
            <?php endif; ?>
          </ol>
        </div>
        <div>
          <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
            <i class="material-symbols-rounded">account_circle</i>
          </a>
        </div>
      </nav>
    </div>
  </nav>
</body>

</html>
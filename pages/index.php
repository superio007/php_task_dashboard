<?php
error_reporting(E_ALL & ~E_WARNING); // Reports all errors except warnings

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Dashboard by Kiran Dhoke
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/ed4167ae3c.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php
    include "dbconn.php";
    function MaxValue($rowType,$endYear,$conn){
        $sql = "SELECT MAX(".$rowType.") FROM `insights_data` WHERE end_year = $endYear";
        $result = $conn->query($sql);
        $value = $result->fetch_assoc();
        return $value;
    }
    function calculatePercentage($thisYear,$lastYear){
        $percentage = ($thisYear - $lastYear) / $lastYear * 100;
        return $percentage;
    }
    function getCountryName($maxintensity, $endYear, $conn) {
        $sql = "SELECT country FROM `insights_data` WHERE intensity = " . intval($maxintensity) . " AND end_year = " . intval($endYear) . " AND country IS NOT NULL";
        $result = $conn->query($sql);
        
        // Check if query was successful and has results
        if ($result && $result->num_rows > 0) {
            $value = $result->fetch_assoc();
            return $value; // Return the country name
        } else {
            return null; // Return null if no results found
        }
    }
    
    $intensitythisYear = MaxValue("intensity",Date("Y"),$conn);
    $intensitylastYear = MaxValue("intensity",Date("Y")-1,$conn);
    $intensityPercentage = calculatePercentage($intensitythisYear["MAX(intensity)"],$intensitylastYear["MAX(intensity)"]);
    $relevancethisYear = MaxValue("relevance",Date("Y"),$conn);
    $relevancelastYear = MaxValue("relevance",Date("Y")-1,$conn);
    $relevancePercentage = calculatePercentage($relevancethisYear["MAX(relevance)"],$relevancelastYear["MAX(relevance)"]);
    $likelihoodthisYear = MaxValue("likelihood",Date("Y"),$conn);
    $likelihoodlastYear = MaxValue("likelihood",Date("Y")-1,$conn);
    $likelihoodPercentage = calculatePercentage($likelihoodthisYear["MAX(likelihood)"],$likelihoodlastYear["MAX(likelihood)"]);
    $countryName = getCountryName($intensitythisYear["MAX(intensity)"],Date("Y"),$conn);
    $lastcountryName = getCountryName($intensitythisYear["MAX(intensity)"],Date("Y")-1,$conn);
    $conn->close();
    ?>
    <?php include "sidebar.php"; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php include "navbar.php"; ?>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                    <p class="mb-4">
                        Check the Intensity, relevance and likelihood by year.
                    </p>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">This Year Intensity</p>
                                    <h4 class="mb-0"><?php echo $intensitythisYear['MAX(intensity)']; ?></h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">weekend</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <?php if($intensityPercentage > 0):?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $intensityPercentage; ?>% </span>than last year</p>
                            <?php elseif($intensityPercentage == 0):?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $intensityPercentage; ?>% </span>than last year</p>
                            <?php else:?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $intensityPercentage; ?>% </span>than yesterday</p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">This Year Relevance</p>
                                    <h4 class="mb-0"><?php echo $relevancethisYear['MAX(relevance)']; ?></h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">person</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <?php if($relevancePercentage > 0):?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $relevancePercentage; ?>% </span>than last year</p>
                            <?php elseif($relevancePercentage == 0):?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $relevancePercentage; ?>% </span>than last year</p>
                            <?php else:?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $relevancePercentage; ?>% </span>than yesterday</p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">This Year Likelihood</p>
                                    <h4 class="mb-0"><?php echo $likelihoodthisYear['MAX(likelihood)']; ?></h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">leaderboard</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <?php if($likelihoodPercentage > 0):?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php elseif($likelihoodPercentage == 0):?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php else:?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Top Intesity Conutry</p>
                                    <?php if($countryName['country'] == null):?>
                                        <h4 class="mb-0">-</h4>
                                    <?php else:?>
                                        <h4 class="mb-0"><?php echo $countryName['country']; ?></h4>
                                    <?php endif;?>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">weekend</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <?php if($lastcountryName['country'] == null):?>
                                <p class="mb-0 text-sm">-</p>
                            <?php else:?>
                                <p class="mb-0 text-sm"><?php echo $lastcountryName['country']; ?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0 ">Website Views</h6>
                            <p class="text-sm ">Last Campaign Performance</p>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-bars" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-bars" width="400" height="170"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card ">
                        <div class="card-body">
                            <h6 class="mb-0 "> Daily Sales </h6>
                            <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales. </p>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-line" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-line-1"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> updated 4 min ago </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0 ">Completed Tasks</h6>
                            <p class="text-sm ">Last Campaign Performance</p>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-line-2"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">just updated</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Projects</h6>
                                    <p class="text-sm mb-0">
                                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">30 done</span> this month
                                    </p>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="dropdown float-lg-end pe-4">
                                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-secondary"></i>
                                        </a>
                                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Companies</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Members</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Budget</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Completion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Material XD Version</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                        <img src="../assets/img/team-1.jpg" alt="team1">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                        <img src="../assets/img/team-2.jpg" alt="team2">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                                                        <img src="../assets/img/team-3.jpg" alt="team3">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                        <img src="../assets/img/team-4.jpg" alt="team4">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> $14,000 </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">60%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-atlassian.svg" class="avatar avatar-sm me-3" alt="atlassian">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Add Progress Track</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                        <img src="../assets/img/team-2.jpg" alt="team5">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                        <img src="../assets/img/team-4.jpg" alt="team6">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> $3,000 </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">10%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info w-10" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm me-3" alt="team7">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Fix Platform Errors</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                        <img src="../assets/img/team-3.jpg" alt="team8">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                        <img src="../assets/img/team-1.jpg" alt="team9">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> Not set </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">100%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm me-3" alt="spotify">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Launch our Mobile App</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                        <img src="../assets/img/team-4.jpg" alt="user1">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                        <img src="../assets/img/team-3.jpg" alt="user2">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                                                        <img src="../assets/img/team-4.jpg" alt="user3">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                        <img src="../assets/img/team-1.jpg" alt="user4">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> $20,500 </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">100%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm me-3" alt="jira">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Add the New Pricing Page</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                        <img src="../assets/img/team-4.jpg" alt="user5">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> $500 </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">25%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm me-3" alt="invision">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Redesign New Online Shop</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group mt-2">
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                        <img src="../assets/img/team-1.jpg" alt="user6">
                                                    </a>
                                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                        <img src="../assets/img/team-4.jpg" alt="user7">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> $2,000 </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">40%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info w-40" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="40"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Orders overview</h6>
                            <p class="text-sm">
                                <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                                <span class="font-weight-bold">24%</span> this month
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">notifications</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-danger text-gradient">code</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-info text-gradient">shopping_cart</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-warning text-gradient">credit_card</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-primary text-gradient">key</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                                    </div>
                                </div>
                                <div class="timeline-block">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-dark text-gradient">payments</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "footer.php" ?>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (localStorage.getItem("userCredential")) {
                document.getElementById("login-Div").innerHTML = `
                        <a class="nav-link text-dark" id="logout">
                            <i class="material-symbols-rounded opacity-5">assignment</i>
                            <span class="nav-link-text ms-1">Logout</span>
                        </a>
                    `;
                document.getElementById("logout").addEventListener("click", function() {
                    localStorage.removeItem("userCredential");
                    window.location.href = "sign-in.php";
                });
            } else {
                document.getElementById("login-Div").innerHTML = `
                    <a class="nav-link text-dark" href="sign-in.php">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Log In</span>
                    </a>
                `;
                window.location.href = "sign-in.php";
            }
            // for bar chart
            const data = [50, 45, 22, 28, 50, 60, 76, 25, 55, 75, 78, 20]; // Updated data
            const svg = d3.select("#chart-bars");
            const margin = { top: 20, right: 20, bottom: 30, left: 40 };
            const width = +svg.attr("width") - margin.left - margin.right;
            const height = +svg.attr("height") - margin.top - margin.bottom;

            const x = d3.scaleBand().rangeRound([0, width]).padding(0.1);
            const y = d3.scaleLinear().rangeRound([height, 0]);

            const g = svg
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            // Update the domain to include labels for all data points
            x.domain(["M", "T", "W", "T", "F", "S", "S", "M2", "T2", "W2", "T3", "F2"]); 
            y.domain([0, d3.max(data)]);

            g.append("g")
                .attr("class", "axis axis--x")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x));

            g.append("g")
                .attr("class", "axis axis--y")
                .call(d3.axisLeft(y).ticks(10));

            g.selectAll(".bar")
                .data(data)
                .enter()
                .append("rect")
                .attr("class", "bar")
                .attr("x", (d, i) => x(["M", "T", "W", "T", "F", "S", "S", "M2", "T2", "W2", "T3", "F2"][i]))
                .attr("y", d => y(d))
                .attr("width", x.bandwidth())
                .attr("height", d => height - y(d))
                .attr("fill", "#43A047");

            function renderLineChart(chartId, data, labels) {
                const svg = d3.select(`#${chartId}`)
                    .attr("width", 400)
                    .attr("height", 170 );

                const margin = { top: 20, right: 20, bottom: 30, left: 40 };
                const width = +svg.attr("width") - margin.left - margin.right;
                const height = +svg.attr("height") - margin.top - margin.bottom;

                const g = svg.append("g").attr("transform", `translate(${margin.left},${margin.top})`);

                // Define the scales
                const x = d3.scalePoint()
                    .domain(labels)
                    .range([0, width]);

                const y = d3.scaleLinear()
                    .domain([0, d3.max(data)])
                    .range([height, 0]);

                // Define the line generator
                const line = d3.line()
                    .x((_, i) => x(labels[i]))
                    .y(d => y(d))
                    .curve(d3.curveMonotoneX); // Smooth the line

                // Add X-axis
                g.append("g")
                    .attr("transform", `translate(0,${height})`)
                    .call(d3.axisBottom(x));

                // Add Y-axis
                g.append("g")
                    .call(d3.axisLeft(y));

                // Add the line path
                g.append("path")
                    .datum(data)
                    .attr("fill", "none")
                    .attr("stroke", "green")
                    .attr("stroke-width", 2)
                    .attr("d", line);

                // Add data points
                g.selectAll(".dot")
                    .data(data)
                    .enter().append("circle")
                    .attr("class", "dot")
                    .attr("cx", (_, i) => x(labels[i]))
                    .attr("cy", d => y(d))
                    .attr("r", 4)
                    .attr("fill", "green");
            }
            const data1 = [200, 300, 150, 450, 400, 300, 250, 150, 200, 300, 350, 250];
            const labels1 = ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"];

            const data2 = [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600];
            const labels2 = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            // Render the first chart
            renderLineChart("chart-line-1", data1, labels1);

            // Render the second chart
            renderLineChart("chart-line-2", data2, labels2);    
        })
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
</body>

</html>
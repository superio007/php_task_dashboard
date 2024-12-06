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
    <link id="pagestyle" href="../assets/css/Style.css?v=3.2.0" rel="stylesheet" />
    <!-- Jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php
    include "dbconn.php";
    function retriveDataTable($endYear, $conn)
    {
        $sql = "SELECT * FROM `insights_data` WHERE end_year = $endYear LIMIT 0 , 6";
        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
    function MaxValue($rowType, $endYear, $conn)
    {
        $sql = "SELECT MAX(" . $rowType . ") FROM `insights_data` WHERE end_year = $endYear";
        $result = $conn->query($sql);
        $value = $result->fetch_assoc();
        return $value;
    }
    function getYears($conn, $currentYear)
    {
        $sql = "SELECT DISTINCT(end_year)
                FROM insights_data
                WHERE end_year != " . $currentYear . "
                ORDER BY end_year ASC;
                ";
        $result = $conn->query($sql);
        $value = $result->fetch_all();
        return $value;
    }
    $getYears = getYears($conn, Date("Y"));
    function calculatePercentage($thisYear, $lastYear)
    {
        $percentage = ($thisYear - $lastYear) / $lastYear * 100;
        return $percentage;
    }
    function getCountryName($maxintensity, $endYear, $conn)
    {
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

    $intensitythisYear = MaxValue("intensity", Date("Y"), $conn);
    $intensitylastYear = MaxValue("intensity", Date("Y") - 1, $conn);
    $intensityPercentage = calculatePercentage($intensitythisYear["MAX(intensity)"], $intensitylastYear["MAX(intensity)"]);
    $relevancethisYear = MaxValue("relevance", Date("Y"), $conn);
    $relevancelastYear = MaxValue("relevance", Date("Y") - 1, $conn);
    $relevancePercentage = calculatePercentage($relevancethisYear["MAX(relevance)"], $relevancelastYear["MAX(relevance)"]);
    $likelihoodthisYear = MaxValue("likelihood", Date("Y"), $conn);
    $likelihoodlastYear = MaxValue("likelihood", Date("Y") - 1, $conn);
    $likelihoodPercentage = calculatePercentage($likelihoodthisYear["MAX(likelihood)"], $likelihoodlastYear["MAX(likelihood)"]);
    $countryName = getCountryName($intensitythisYear["MAX(intensity)"], Date("Y"), $conn);
    $lastcountryName = getCountryName($intensitythisYear["MAX(intensity)"], Date("Y") - 1, $conn);
    $tableData = retriveDataTable(Date("Y"), $conn);
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
                            <?php if ($intensityPercentage > 0): ?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $intensityPercentage; ?>% </span>than last year</p>
                            <?php elseif ($intensityPercentage == 0): ?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $intensityPercentage; ?>% </span>than last year</p>
                            <?php else: ?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $intensityPercentage; ?>% </span>than yesterday</p>
                            <?php endif; ?>
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
                            <?php if ($relevancePercentage > 0): ?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $relevancePercentage; ?>% </span>than last year</p>
                            <?php elseif ($relevancePercentage == 0): ?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $relevancePercentage; ?>% </span>than last year</p>
                            <?php else: ?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $relevancePercentage; ?>% </span>than yesterday</p>
                            <?php endif; ?>
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
                            <?php if ($likelihoodPercentage > 0): ?>
                                <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+<?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php elseif ($likelihoodPercentage == 0): ?>
                                <p class="mb-0 text-sm"><span class="text-warning font-weight-bolder"><?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php else: ?>
                                <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-<?php echo $likelihoodPercentage; ?>% </span>than last year</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Top Intesity Conutry</p>
                                    <?php if ($countryName['country'] == null): ?>
                                        <h4 class="mb-0">-</h4>
                                    <?php else: ?>
                                        <h4 class="mb-0"><?php echo $countryName['country']; ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">weekend</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <?php if ($lastcountryName['country'] == null): ?>
                                <p class="mb-0 text-sm">-</p>
                            <?php else: ?>
                                <p class="mb-0 text-sm"><?php echo $lastcountryName['country']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Yearly Intensity Trends</h6>
                                    <p class="text-sm ">Intensity trends over the years.</p>
                                </div>
                                <div>
                                    <select name="Bar_Year" id="Bar_Year" style="padding: 4px;border-color: #ddd;color: #676565;border-radius: 6px;">
                                        <option value="<?php echo getdate()['year']; ?>" selected><?php echo getdate()['year']; ?></option>
                                        <?php foreach ($getYears as $yearArray): ?>
                                            <?php $year = $yearArray[0]; // Access the year inside the nested array 
                                            ?>
                                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-bars" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-bars" width="400" height="170"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="update-timer mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 ">Relevance Over Time</h6>
                                    <p class="text-sm ">Relevance trends across years.</p>
                                </div>
                                <div>
                                    <select name="Chart_Year" id="Chart_Year" style="padding: 4px;border-color: #ddd;color: #676565;border-radius: 6px;">
                                        <option value="<?php echo getdate()['year']; ?>" selected><?php echo getdate()['year']; ?></option>
                                        <?php foreach ($getYears as $yearArray): ?>
                                            <?php $year = $yearArray[0]; // Access the year inside the nested array 
                                            ?>
                                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-line" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-line-1"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="update-timer mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 ">Likelihood Over Time</h6>
                                    <p class="text-sm ">Likelihood trends across years.</p>
                                </div>
                                <div>
                                    <select name="Chart_Year2" id="Chart_Year2" style="padding: 4px;border-color: #ddd;color: #676565;border-radius: 6px;">
                                        <option value="<?php echo getdate()['year']; ?>" selected><?php echo getdate()['year']; ?></option>
                                        <?php foreach ($getYears as $yearArray): ?>
                                            <?php $year = $yearArray[0]; // Access the year inside the nested array 
                                            ?>
                                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pe-2">
                                <div class="chart">
                                    <!-- <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas> -->
                                    <svg id="chart-line-2"></svg>
                                </div>
                            </div>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                                <p class="update-timer mb-0"></p>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Global Industry Insights</h6>
                                        <p>A table of sector-specific data, sources, and global trends.</p>
                                    </div>
                                    <div>
                                        <select name="table_Year" id="table_Year" style="padding: 4px;border-color: #ddd;color: #676565;border-radius: 6px;">
                                            <option value="<?php echo getdate()['year']; ?>" selected><?php echo getdate()['year']; ?></option>
                                            <?php foreach ($getYears as $yearArray): ?>
                                                <?php $year = $yearArray[0]; // Access the year inside the nested array 
                                                ?>
                                                <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive px-3">
                                <table class="table align-items-center mb-0">
                                    <thead id="table-head">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable" data-column="topic" data-order="asc">
                                                Topic
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2 sortable" data-column="sector" data-order="asc">
                                                Sector
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable" data-column="source" data-order="asc">
                                                Source
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable" data-column="city" data-order="asc">
                                                City
                                                <span class="sort-icon"></span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <!-- Data will be populated dynamically here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-evenly align-items-center pb-3">
                            <button style="background-color: #fff; padding: 4px 16px;border-color: #ddd;color: #676565;border-radius: 6px;" id="prevPage">Previous Page</button>
                            <button style="background-color: #fff; padding: 4px 16px;border-color: #ddd;color: #676565;border-radius: 6px;" id="nextPage">Next Page</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center pb-3">
                                <div>
                                    <h6 class="mb-0">Regions overview</h6>
                                    <p>Key data and insights by region.</p>
                                </div>
                                <div>
                                    <select name="Pie_Year" id="Pie_Year" style="padding: 4px;border-color: #ddd;color: #676565;border-radius: 6px;">
                                        <option value="<?php echo getdate()['year']; ?>" selected><?php echo getdate()['year']; ?></option>
                                        <?php foreach ($getYears as $yearArray): ?>
                                            <?php $year = $yearArray[0]; // Access the year inside the nested array 
                                            ?>
                                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="chart">
                            <canvas id="regionPieChart" width="400" height="400"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {

            $(".sortable").on("click", function() {
                const column = $(this).data("column"); // Get the column name
                const currentOrder = $(this).data("order"); // Get the current order
                const newOrder = currentOrder === "asc" ? "desc" : "asc"; // Toggle order

                // Update the order attribute in the clicked <th>
                $(this).data("order", newOrder);

                // Remove active class and sort-icon from all <th>
                $(".sortable").removeClass("active");
                $(".sort-icon").text(""); // Clear previous icons

                // Add active class and sort-icon to the clicked <th>
                $(this).addClass("active");
                $(this).find(".sort-icon").html(newOrder === "asc" ? `<i class="fa-solid fa-lg fa-caret-up" style="color: #a2a2a2;"></i>` : `<i class="fa-solid fa-lg fa-caret-down" style="color: #a2a2a2;"></i>`);

                // Fetch sorted data
                const year = $("#table_Year").val(); // Get the selected year
                fetchTableData(year, 0, 5, column, newOrder); // Fetch sorted table data
            });

            let elapsedMinutes = 0; // Counter for elapsed minutes
            const $updateElement = $(".update-timer"); // Target DOM element to update

            // Function to update the DOM
            function updateDom() {
                if (elapsedMinutes === 0) {
                    $updateElement.text("Updated Just Now"); // Initial update
                } else {
                    $updateElement.text(`Updated ${elapsedMinutes} minute${elapsedMinutes > 1 ? "s" : ""} ago`);
                }
            }

            // Call the function immediately on page load
            updateDom();

            // Set interval to update every minute
            setInterval(function() {
                elapsedMinutes++;
                updateDom();
            }, 60000);
            const loginDiv = $("#login-Div");
            let start = 0;
            const limit = 5;
            // Next Page button click event
            $('#nextPage').on('click', function() {
                start += limit; // Increment start for the next page
                fetchTableData(initialValues.table, start, start + limit);
            });

            // Previous Page button click event
            $('#prevPage').on('click', function() {
                if (start > 0) {
                    start -= limit; // Decrement start for the previous page
                    fetchTableData(initialValues.table, start, start + limit);
                }
            });
            if (localStorage.getItem("userCredential")) {
                loginDiv.html(`
                    <a class="nav-link text-dark" id="logout">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                `);

                $("#logout").on("click", function() {
                    localStorage.removeItem("userCredential");
                    window.location.href = "sign-in.php";
                });
            } else {
                loginDiv.html(`
                    <a class="nav-link text-dark" href="sign-in.php">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Log In</span>
                    </a>
                `);
                window.location.href = "sign-in.php";
            }
            const calltoRetrieve = (type, year, chartId, isLineChart = false) => {
                $.ajax({
                    url: "retriveData.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        type,
                        year
                    }),
                    success: (response) => {
                        try {
                            console.log("Server response:", response);

                            // Ensure the response is an object
                            if (typeof response === "string") {
                                response = JSON.parse(response);
                            }

                            // Validate response structure
                            if (response.status === "success" && Array.isArray(response.labels) && Array.isArray(response.values)) {
                                renderChart(chartId, response.values, response.labels, isLineChart);
                            } else {
                                console.error("Invalid response format:", response);
                            }
                        } catch (error) {
                            console.error("Error parsing response:", error);
                        }
                    },
                    error: (error) => console.error("AJAX Error:", error)
                });
            };
            let regionPieChartInstance; // Store the chart instance

            function fetchRegionData(year) {
                if (!year) {
                    alert("Please enter a valid year.");
                    return;
                }

                $.ajax({
                    url: "retriveRegions.php", // Replace with your PHP script's path
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        year: year
                    }),
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.status === "success") {
                                const labels = [];
                                const values = [];

                                for (const [region, count] of Object.entries(data.regionCounts)) {
                                    labels.push(region);
                                    values.push(count);
                                }

                                // Update or render the chart
                                if (regionPieChartInstance) {
                                    // Update existing chart
                                    regionPieChartInstance.data.labels = labels;
                                    regionPieChartInstance.data.datasets[0].data = values;
                                    regionPieChartInstance.update();
                                } else {
                                    // Create new chart
                                    renderPieChart("regionPieChart", labels, values);
                                }
                            } else {
                                alert(`Error: ${data.message}`);
                            }
                        } catch (error) {
                            alert("An error occurred while parsing the response.");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(`An error occurred: ${error}`);
                    },
                });
            }
            // Function to render a pie chart
            function renderPieChart(canvasId, labels, data) {
                const ctx = document.getElementById(canvasId).getContext("2d");
                regionPieChartInstance = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Region Distribution",
                            data: data,
                            backgroundColor: [
                                "#FF6384",
                                "#36A2EB",
                                "#FFCE56",
                                "#4BC0C0",
                                "#9966FF",
                                "#FF9F40",
                            ],
                            hoverOffset: 4,
                        }, ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    },
                });
            }
            // Function to fetch table data
            function fetchTableData(year, start, end, column = null, order = null) {
                const requestData = {
                    year: year,
                    start: start,
                    end: end,
                };

                // Add sorting parameters if provided
                if (column && order) {
                    requestData.column = column;
                    requestData.order = order;
                }

                console.log("Request Data:", requestData); // Debugging

                $.ajax({
                    url: 'retriveTable.php', // Update with your PHP endpoint
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(requestData),
                    dataType: 'json',
                    success: function(response) {
                        const tableBody = $('#table-body');
                        tableBody.empty(); // Clear existing table rows

                        if (response.status === 'success') {
                            if (response.regionCounts.length === 0) {
                                tableBody.append('<tr><td colspan="4" class="text-center">No data available</td></tr>');
                            } else {
                                let counter = start + 1; // Starting counter
                                response.regionCounts.forEach(row => {
                                    tableBody.append(`
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>${counter}</div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <p style="margin-left: 12px; color:#262626" class="mb-0 text-sm">${row.topic || 'Not available'}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <p class="text-center" style="color:#262626">${row.sector || 'Not available'}</p>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    ${row.source
                                        ? `<a target="_blank" id="source_link" href="${row.url || '#'}">${row.source.length > 50 ? row.source.substring(0, 50) + '...' : row.source}</a>`
                                        : 'Not available'}
                                </td>
                                <td class="align-middle">
                                    <div class="progress-wrapper w-75 mx-auto">
                                        <div>
                                            <p style="color:#262626">${row.city || 'Not available'}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
                                    counter++;
                                });
                            }
                        } else {
                            console.error("Error:", response.message);
                            tableBody.append('<tr><td colspan="4" class="text-center">Error loading data</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $('#table-body').html('<tr><td colspan="4" class="text-center">An error occurred while fetching data</td></tr>');
                    }
                });
            }


            const initialValues = {
                intensity: $("#Bar_Year").val(),
                relevance: $("#Chart_Year").val(),
                likelihood: $("#Chart_Year2").val(),
                regions: $("#Pie_Year").val(),
                table: $("#table_Year").val()
            };

            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }


            console.log("Initial Values:", initialValues);
            calltoRetrieve("intensity", initialValues.intensity, "chart-bars");
            calltoRetrieve("relevance", initialValues.relevance, "chart-line-1", true);
            calltoRetrieve("likelihood", initialValues.likelihood, "chart-line-2", true);
            fetchTableData(initialValues.table, start, start + limit);
            fetchRegionData(initialValues.regions);

            $("#Bar_Year").on("input", (e) => {
                calltoRetrieve("intensity", e.target.value, "chart-bars");
                console.log("Bar Selected year:", e.target.value);
            });

            $("#Chart_Year").on("input", (e) => {
                calltoRetrieve("relevance", e.target.value, "chart-line-1", true);
                console.log("Chart Selected year:", e.target.value);
            });

            $("#Chart_Year2").on("input", (e) => {
                calltoRetrieve("likelihood", e.target.value, "chart-line-2", true);
                console.log("Chart 2 Selected year:", e.target.value);
            });

            $("#Pie_Year").on("input", debounce((e) => {
                    console.log("Pie chart selected year:", e.target.value);
                    fetchRegionData(e.target.value);
                }, 300) // Adjust debounce delay as needed
            );

            $("#table_Year").on("input", debounce((e) => {
                    console.log("Table chart selected year:", e.target.value);
                    fetchTableData(e.target.value, start, start + limit);
                }, 300) // Adjust debounce delay as needed
            );

            const renderChart = (id, data, labels, isLineChart = false) => {
                requestAnimationFrame(() => {
                    const chartElement = d3.select('.chart');
                    const width = parseFloat(chartElement.style("width")) || 380;
                    const height = parseFloat(chartElement.style("height")) || 170;

                    d3.select(`#${id}`).selectAll("*").remove();
                    const svg = d3.select(`#${id}`).attr("width", width).attr("height", height);
                    const margin = {
                        top: 20,
                        right: 20,
                        bottom: 30,
                        left: 40
                    };
                    const innerWidth = width - margin.left - margin.right;
                    const innerHeight = height - margin.top - margin.bottom;
                    const g = svg.append("g").attr("transform", `translate(${margin.left},${margin.top})`);

                    const x = isLineChart ?
                        d3.scalePoint().domain(labels).range([0, innerWidth]) :
                        d3.scaleBand().domain(labels).range([0, innerWidth]).padding(0.1);

                    const y = d3.scaleLinear().domain([0, d3.max(data)]).range([innerHeight, 0]);

                    g.append("g").attr("transform", `translate(0,${innerHeight})`).call(d3.axisBottom(x));
                    g.append("g").call(d3.axisLeft(y));

                    if (isLineChart) {
                        const line = d3.line()
                            .x((_, i) => x(labels[i]))
                            .y((d) => y(d))
                            .curve(d3.curveMonotoneX);

                        g.append("path").datum(data).attr("fill", "none").attr("stroke", "green").attr("stroke-width", 2).attr("d", line);
                    } else {
                        g.selectAll(".bar").data(data).enter().append("rect")
                            .attr("class", "bar")
                            .attr("x", (_, i) => x(labels[i]))
                            .attr("y", (d) => y(d))
                            .attr("width", x.bandwidth())
                            .attr("height", (d) => innerHeight - y(d))
                            .attr("fill", "#43A047");
                    }
                });
            };

            $(window).resize(() => {
                console.log("Window resized. Reloading...");
                window.location.reload();
                console.log("Reloaded.");
            });
        });
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
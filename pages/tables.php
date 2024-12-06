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
    $sql = "SELECT MAX(end_year) FROM `insights_data` ";
    $result = $conn->query($sql);
    $value = $result->fetch_assoc();
    ?>
    <?php include "sidebar.php" ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php include "navbar.php" ?>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Global Insights</h6>
                                <p class="ps-3">Interactive table analyzing topics, intensity, relevance, and likelihood by region.</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="authors-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="id" data-order="asc">
                                                Id
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="topic" data-order="asc">
                                                Topics
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 ps-2 sortable" data-column="intensity" data-order="asc">
                                                Intensity
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="country" data-order="asc">
                                                Country
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="region" data-order="asc">
                                                Region
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="city" data-order="asc">
                                                City
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="relevance" data-order="asc">
                                                Relevance
                                                <span class="sort-icon"></span>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-dark text-sm font-weight-bolder opacity-7 sortable" data-column="likelihood" data-order="asc">
                                                Likelihood
                                                <span class="sort-icon"></span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        
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
            </div>
            <?php include 'footer.php'; ?>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let maxYear = <?php echo $value['MAX(end_year)']; ?>;
            let start = 0;
            const limit = 10;
            // Next Page button click event
            $('#nextPage').on('click', function() {
                start += limit; // Increment start for the next page
                fetchTableData(maxYear, start, start + limit);
            });

            // Previous Page button click event
            $('#prevPage').on('click', function() {
                if (start > 0) {
                    start -= limit; // Decrement start for the previous page
                    fetchTableData(maxYear, start, start + limit);
                }
            });
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
                fetchTableData(maxYear, 0, 10, column, newOrder); // Fetch sorted table data
            });
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
                    url: 'retriveAllData.php', // Update with your PHP endpoint
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
                                                <span class="text-xs">${counter + ")"}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.topic}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.intensity}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.country}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.region}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.city}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.relevance}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">${row.likelihood}</span>
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
            fetchTableData(maxYear, start, start + limit);
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
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        })
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
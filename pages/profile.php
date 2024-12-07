<?php
session_start();
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
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- sweet alert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="g-sidenav-show bg-gray-100">
    <?php
    include "dbconn.php";
    $email = $_SESSION['email'];
    function get_data($conn, $email)
    {
        $sql = "SELECT * FROM `user_profiles` WHERE `email` = '$email'";
        $result = $conn->query($sql);
        $value = $result->fetch_assoc();
        return $value;
    }
    function retrive($conn, $email)
    {
        $sql = "SELECT image_path FROM `user_imageuploads` WHERE `username` = '$email'";
        $result = $conn->query($sql);
        $value = $result->fetch_assoc();
        return $value;
    }
    $getData = get_data($conn, $email);
    if ($getData != null) {
        $imgPath = retrive($conn, $email);
    }

    ?>
    <?php include "sidebar.php" ?>
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <?php include "navbar.php" ?>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-dark  opacity-6"></span>
            </div>
            <?php if ($getData == null): ?>
                <div class="card card-body mx-2 mx-md-2 mt-n6">
                    <div class="alert alert-warning text-dark text-lg fw-bold" role="alert">
                        <span>User information was not found. Please <a type="button" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">click here</a> to update your details.</span>
                    </div>
                </div>
                <!-- Model for edit profile -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editProfileForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                    <label for="position" class="form-label mt-3">Position</label>
                                    <input type="text" class="form-control" id="position" placeholder="Enter Position">
                                    <label for="summary" class="form-label mt-3">Summary</label>
                                    <textarea class="form-control" id="summary" rows="3" placeholder="Enter Summary"></textarea>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="mobileNumber" class="form-label">Mobile Number</label>
                                            <input type="tel" class="form-control" id="mobileNumber" placeholder="Enter Mobile Number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" readonly placeholder="Enter Email" required>
                                        </div>
                                    </div>
                                    <label for="location" class="form-label mt-3">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="Enter Location">
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="facebookLink" class="form-label">Facebook URL</label>
                                            <input type="url" class="form-control" id="facebookLink" placeholder="Enter Facebook URL">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="twitterUrl" class="form-label">Twitter URL</label>
                                            <input type="url" class="form-control" id="twitterUrl" placeholder="Enter Twitter URL">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="instagramUrl" class="form-label">Instagram URL</label>
                                            <input type="url" class="form-control" id="instagramUrl" placeholder="Enter Instagram URL">
                                        </div>
                                    </div>
                                    <!-- Separate Image Upload Button -->
                                    <div class="mt-3">
                                        <label for="profileImage" class="form-label">Upload Profile Image</label>
                                        <div class="d-flex align-items-baseline">
                                            <input type="file" style="width: 70%;" class="form-control me-2" id="profileImage" accept="image/*">
                                            <button type="button" class="btn btn-secondary" id="uploadImageBtn">Upload Image</button>
                                        </div>
                                        <div id="successMessage">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveProfile">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card card-body mx-2 mx-md-2 mt-n6">
                    <div class="row gx-4 mb-2">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="<?php echo $imgPath['image_path']; ?>" alt="profile_image" style="height:80px;" class="border-radius-lg shadow-sm">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    <?php echo $getData['first_name'] . " " . $getData['last_name']; ?>
                                </h5>
                                <p class="mb-0 font-weight-normal text-sm">
                                    <?php $getData['position']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-12 col-xl-4">
                                <div class="card card-plain h-100">
                                    <div class="card-header pb-0 p-3">
                                        <div class="row">
                                            <div class="col-md-8 d-flex align-items-center">
                                                <h6 class="mb-0">Profile Information</h6>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <i id="editProfile" class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="modal" data-bs-target="#updateProfileModal" title="Edit Profile"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="text-sm">
                                            <?php echo $getData['summary']; ?>
                                        </p>
                                        <hr class="horizontal gray-light my-4">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; <?php echo $getData['first_name'] . " " . $getData['last_name']; ?></li>
                                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; <?php echo $getData['mobile_number']; ?></li>
                                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; <?php echo $email; ?></li>
                                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Location:</strong> &nbsp; <?php echo $getData['location']; ?></li>
                                            <li class="list-group-item border-0 ps-0 pb-0">
                                                <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                                <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="<?php echo $getData['facebook_link']; ?>">
                                                    <i class="fab fa-facebook fa-lg"></i>
                                                </a>
                                                <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="<?php echo $getData['twitter_url']; ?>">
                                                    <i class="fab fa-twitter fa-lg"></i>
                                                </a>
                                                <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="<?php echo $getData['instagram_url']; ?>">
                                                    <i class="fab fa-instagram fa-lg"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="UpdateProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editProfileForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" required value="<?php echo $getData['first_name']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required value="<?php echo $getData['last_name']; ?>">
                                        </div>
                                    </div>
                                    <label for="position" class="form-label mt-3">Position</label>
                                    <input type="text" class="form-control" id="position" placeholder="Enter Position" value="<?php echo $getData['position']; ?>">
                                    <label for="summary" class="form-label mt-3">Summary</label>
                                    <textarea class="form-control" id="summary" rows="3" placeholder="Enter Summary"><?php echo $getData['summary']; ?></textarea>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="mobileNumber" class="form-label">Mobile Number</label>
                                            <input type="tel" class="form-control" id="mobileNumber" placeholder="Enter Mobile Number" required value="<?php echo $getData['mobile_number']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter Email" required value="<?php echo $getData['email']; ?>">
                                        </div>
                                    </div>
                                    <label for="location" class="form-label mt-3">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="Enter Location" value="<?php echo $getData['location']; ?>">
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="facebookLink" class="form-label">Facebook URL</label>
                                            <input type="url" class="form-control" id="facebookLink" placeholder="Enter Facebook URL" value="<?php echo $getData['facebook_link']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="twitterUrl" class="form-label">Twitter URL</label>
                                            <input type="url" class="form-control" id="twitterUrl" placeholder="Enter Twitter URL" value="<?php echo $getData['twitter_url']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="instagramUrl" class="form-label">Instagram URL</label>
                                            <input type="url" class="form-control" id="instagramUrl" placeholder="Enter Instagram URL" value="<?php echo $getData['instagram_url']; ?>">
                                        </div>
                                    </div>
                                    <!-- Separate Image Upload Button -->
                                    <div class="mt-3">
                                        <label for="profileImage" class="form-label">Upload Profile Image</label>
                                        <div class="d-flex align-items-baseline">
                                            <input type="file" style="width: 70%;" class="form-control me-2" id="profileImage" accept="image/*">
                                            <button type="button" class="btn btn-secondary" id="uploadImageBtn">Upload Image</button>
                                        </div>
                                        <div id="successMessage">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveProfile">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userCredential = JSON.parse(localStorage.getItem('userCredential'));
            const username = userCredential.email;
            document.getElementById('email').value = username;
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
        document.getElementById('uploadImageBtn').addEventListener('click', function() {
            const profileImageInput = document.getElementById('profileImage');
            const successMessageDiv = document.getElementById('successMessage');
            const selectedFile = profileImageInput.files[0];

            successMessageDiv.innerHTML = ''; // Clear previous messages

            if (!selectedFile) {
                successMessageDiv.innerHTML = `
            <div class="alert alert-warning" role="alert">
                Please select an image to upload.
            </div>`;
                return;
            }

            const userCredential = JSON.parse(localStorage.getItem('userCredential'));
            const username = userCredential.email;


            // Create a FormData object to send the file and username
            const formData = new FormData();
            formData.append('userImage', selectedFile);
            formData.append('username', username);

            // Send the file and username using AJAX
            fetch('upload.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Server response:', data);
                    // Show success message or error message returned by the server
                    successMessageDiv.innerHTML = `
                <div class="alert alert-success" role="alert">
                    ${data}
                </div>`;
                })
                .catch(error => {
                    console.error('Error:', error);
                    successMessageDiv.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    An error occurred while uploading the image. Please try again.
                </div>`;
                });
        });


        document.getElementById('saveProfile').addEventListener('click', function() {
            const profileData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                position: document.getElementById('position').value,
                summary: document.getElementById('summary').value,
                mobileNumber: document.getElementById('mobileNumber').value,
                email: document.getElementById('email').value,
                location: document.getElementById('location').value,
                facebookLink: document.getElementById('facebookLink').value,
                twitterUrl: document.getElementById('twitterUrl').value,
                instagramUrl: document.getElementById('instagramUrl').value
            };

            console.log('Profile Data:', profileData);

            // Send data to the server using AJAX
            fetch('saveProfile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(profileData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Use SweetAlert for success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Saved',
                            text: 'Your profile has been saved successfully!',
                        }).then(() => {
                            // Reload the page after the alert is dismissed
                            location.reload();
                        });
                    } else {
                        // Use SweetAlert for error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to save profile. Please try again.',
                        }).then(() => {
                            // Reload the page after the alert is dismissed (optional for errors)
                            location.reload();
                        });
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving the profile. Please try again.',
                    });
                });

            // Hide the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
            modal.hide();
            const updatemodal = bootstrap.Modal.getInstance(document.getElementById('updateProfileModal'));
            updatemodal.hide();
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
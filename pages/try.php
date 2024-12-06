<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Responsive Profile Modal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .modal-body input,
        .modal-body textarea {
            margin-bottom: 15px;
        }

        .modal-header {
            background-color: #6c757d;
            color: white;
        }

        .modal-footer {
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <!-- Trigger Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
        Edit Profile
    </button>

    <!-- Modal -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userCredential = JSON.parse(localStorage.getItem('userCredential'));
            const username = userCredential.email;
            document.getElementById('email').value = username;
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
                        });
                    } else {
                        // Use SweetAlert for error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to save profile. Please try again.',
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
        });
    </script>
</body>

</html>
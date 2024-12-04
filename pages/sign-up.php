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

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('../assets/img/illustrations/illustration-signup.jpg'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  <h4 class="font-weight-bolder">Sign Up</h4>
                  <p class="mb-0">Enter your email and password to register</p>
                </div>
                <div class="d-flex gap-3">
                  <div class="col-2 text-center ms-auto Microsoft">
                    <i class="fa-brands fa-windows text-white text-lg" style="color: #000 !important; "></i>
                  </div>
                  <div class="col-2 text-center px-1 Yahoo">
                    <i class="fa-brands fa-yahoo text-white text-lg" style="color: #000 !important;"></i>
                  </div>
                  <div class="col-2 text-center me-auto google">
                    <i class="fa fa-google text-white text-lg" style="color: #000 !important;"></i>
                  </div>
                </div>
                <div class="card-body">
                  <form role="form" method="post">
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" id="name" class="form-control">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" id="email" class="form-control">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" id="password" class="form-control">
                    </div>
                    <div class="form-check form-check-info text-start ps-0">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div>
                    <div class="text-center">
                      <button type="button" id="SignBtn" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Sign Up</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    Already have an account?
                    <a href="../pages/sign-in.php" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script type="module">
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    // Import the functions you need from the SDKs you need
    import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
    import {
      getAuth,
      signInWithEmailAndPassword,
      signInWithPopup,
      GoogleAuthProvider,
      OAuthProvider
    } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-auth.js";
    const firebaseConfig = {
      apiKey: "AIzaSyD4fWIT9UB0RSSehDYFMdIRf9U-_0WKBdc",
      authDomain: "kiran-dhoke.firebaseapp.com",
      projectId: "kiran-dhoke",
      storageBucket: "kiran-dhoke.firebasestorage.app",
      messagingSenderId: "80606582129",
      appId: "1:80606582129:web:fe2650726e2ff4c33492d0",
      measurementId: "G-CTVCT4S1Y2"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const provider = new GoogleAuthProvider();
    const yahooProvider = new OAuthProvider('yahoo.com');
    const microsoftProvider = new OAuthProvider('microsoft.com');

    const auth = getAuth();
    // For Microsoft
    document.querySelector('.Microsoft').addEventListener("click", (event) => {
      event.preventDefault();
      console.log("microsoft opening");
      signInWithPopup(auth, microsoftProvider)
        .then((result) => {
          // User is signed in.
          // IdP data available in result.additionalUserInfo.profile.

          // Get the OAuth access token and ID Token
          const credential = OAuthProvider.credentialFromResult(result);
          const accessToken = credential.accessToken;
          const idToken = credential.idToken;
          const user = result.user;
          localStorage.setItem('userCredential', JSON.stringify(user));
          console.log(credential);
          console.log(accessToken);
          console.log(idToken);
          window.location.href = "index.php";
        })
        .catch((error) => {
          // Handle Errors here.
          const errorCode = error.code;
          const errorMessage = error.message;
          console.error(errorMessage);
        });
    })
    document.getElementById('SignBtn').addEventListener('click', (event) => {
      event.preventDefault();
      console.log("Log in");
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
          // Signed in
          const user = userCredential.user;
          localStorage.setItem("userCredential", JSON.stringify(user));
          console.log(user);
          window.location.href = "index.php";
          // ...
        })
        .catch((error) => {
          const errorCode = error.code;
          const errorMessage = error.message;
        });
    });
    // for google popup and registration
    document.querySelector(".google").addEventListener("click", (event) => {
      event.preventDefault();
      console.log("google opening");
      signInWithPopup(auth, provider)
        .then((result) => {
          // This gives you a Google Access Token. You can use it to access the Google API.
          const credential = GoogleAuthProvider.credentialFromResult(result);
          const token = credential.accessToken;
          // The signed-in user info.
          const user = result.user;
          localStorage.setItem("userCredential", JSON.stringify(user));
          console.log(user);
          window.location.href = "index.php";
          // ...
        })
        .catch((error) => {
          // Handle Errors here.
          const errorCode = error.code;
          const errorMessage = error.message;
        });
    });
    // for yahoo
    document.querySelector('.Yahoo').addEventListener("click", (event) => {
      event.preventDefault();
      console.log("yahoo opening");
      signInWithPopup(auth, yahooProvider)
        .then((result) => {
          const credential = OAuthProvider.credentialFromResult(result);
          const accessToken = credential.accessToken;
          const idToken = credential.idToken;
          const user = result.user;
          localStorage.setItem('userCredential', JSON.stringify(user));
          console.log(credential);
          console.log(accessToken);
          console.log(idToken);
          window.location.href = "index.php";

        })
        .catch((error) => {
          // Handle Errors here.
          const errorCode = error.code;
          const errorMessage = error.message;
          console.log(errorMessage);
        });
    })
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
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
</head>

<body class="bg-gray-200">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                  <div class="row mt-3">
                    <div class="col-2 text-center ms-auto Microsoft">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa-brands fa-windows text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center px-1 Yahoo">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa-brands fa-yahoo text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center me-auto google">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-google text-white text-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form role="form" method="post" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <!-- <label class="form-label">Email</label> -->
                    <input type="email" id="email" placeholder="Enter Email" class="form-control">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <!-- <label class="form-label">Password</label> -->
                    <input type="password" id="password" placeholder="Enter Password" class="form-control">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="button" id="loginbtn" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign in</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    Don't have an account?
                    <a href="../pages/sign-up.php" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    // for sign in
    document.getElementById('loginbtn').addEventListener('click', (event) => {
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
</body>

</html>
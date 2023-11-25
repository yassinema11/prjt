<?php
  include("./include/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Nom"];
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];

    // Check if the user already exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $checkStmt->bind_param("s", $Email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('This user already exists!')</script>";
    } else {
        // User does not exist, proceed with insertion
        $insertStmt = $conn->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $Name, $Email, $Password);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            echo "Data added to the database successfully.";
            header("Location: login.php");

        } else {
            echo "Error adding data to the database.";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title> ALLO Services</title>



    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">



    <link href="assets/css/theme.css" rel="stylesheet" />

  </head>
  <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand" href="index.php"> <p> ALLO SERVICES  </p></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
              <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="./index.php"> Accueil </a></li>
              <li class="nav-item px-2"><a class="nav-link" href="./register.php"> Inscrire </a></li>
              <li class="nav-item px-2"><a class="nav-link" href="./login.php"> Se Connecter </a></li>

            </ul>
            <div class="dropdown d-none d-lg-block">
              
            </div><a class="btn btn-primary order-1 order-lg-0 ms-lg-3" href="#form">Contactez nous</a>
          </div>
        </div>
      </nav>


      <section>

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4"><img src="assets/img/illustrations/callback.png" alt="..." />
            <h1> INSCRIRE </h1>
            </div>
            <div class="col-md-6 col-lg-5 col-xl-4">
              <form class="row" method="post" action="register.php">
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="Name"> Nom </label>
                  <input class="form-control form-quriar-control" name="Nom" id="Nom" type="text" placeholder="Nom et prénom" required="required" />
                </div>
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="Email">Email</label>
                  <input class="form-control form-quriar-control" id="Email" name="Email" type="text" placeholder="Email" required="required"/>
                </div>
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="Password"> Password </label>
                  <input class="form-control form-quriar-control" id="Password" type="text" name="Password" placeholder="Password" required="required"/>
                </div>
                <div class="d-grid">
                  <button class="btn btn-primary" type="submit"> S'inscrire <i class="fas fa-paper-plane ms-2"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>

      </main>



    <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="assets/js/theme.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
  </body>

</html>
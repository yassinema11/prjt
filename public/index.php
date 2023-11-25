<?php

// Establish a database connection (replace these values with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$dbname = "allo";

$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["Name"]);
    $email = trim($_POST["Email"]);
    $message = trim($_POST["text"]);

    $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    // Bind the parameters
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Close the connection
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


  <body>

    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand" href="index.html"> <p> ALLO SERVICES  </p></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
              <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="index.php"> Accueil </a></li>
              <li class="nav-item px-2"><a class="nav-link" href="#services">Nos Services</a></li>
              <li class="nav-item px-2"><a class="nav-link" href="./register.php"> Inscrire </a></li>
              <li class="nav-item px-2"><a class="nav-link" href="./login.php"> Se Connecter </a></li>

            </ul>
            <div class="dropdown d-none d-lg-block">
              
            </div><a class="btn btn-primary order-1 order-lg-0 ms-lg-3" href="#form">Contactez nous</a>
          </div>
        </div>
      </nav>
      <section class="py-xxl-10 pb-0" id="home">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/hero-header-bg.png);background-position:top center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-5 col-xl-6 col-xxl-7 order-0 order-md-1 text-end"><img class="pt-7 pt-md-0 w-100" src="assets/img/illustrations/hero.png" alt="hero-header" /></div>
            <div class="col-md-75 col-xl-6 col-xxl-5 text-md-start text-center py-8">
              <h1 class="fw-normal fs-6 fs-xxl-7"> Vos Services à  </h1>
              <h1 class="fw-bolder fs-6 fs-xxl-7 mb-2"> DOMICILE </h1>
              <a class="btn btn-primary me-2" href="#!" role="button"> Se Connecter <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
          </div>
        </div>
      </section>


      <section class="py-7" id="services" container-xl="container-xl">

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 text-center mb-3">
              <h5 class="text-danger">SERVICES</h5>
              <h2>Our services for you</h2>
            </div>
          </div>
          <div class="row h-100 justify-content-center">
            <div class="col-md-4 pt-4 px-md-2 px-lg-3">
              <div class="card h-100 px-lg-5 card-span">
                <div class="card-body d-flex flex-column justify-content-around">
                  <div class="text-center pt-5"><img class="img-fluid" src="assets/img/icons/services-1.svg" alt="..." />
                    <h5 class="my-4">Business Services</h5>
                  </div>
                  
                  <div class="text-center my-5">
                    <div class="d-grid">
                      <button class="btn btn-outline-danger" type="submit">Learn more </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 pt-4 px-md-2 px-lg-3">
              <div class="card h-100 px-lg-5 card-span">
                <div class="card-body d-flex flex-column justify-content-around">
                  <div class="text-center pt-5"><img class="img-fluid" src="assets/img/icons/services-2.svg" alt="..." />
                    <h5 class="my-4">Statewide Services</h5>
                  </div>
                  
                  <div class="text-center my-5">
                    <div class="d-grid">
                      <button class="btn btn-danger hover-top btn-glow border-0" type="submit">Learn more</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 pt-4 px-md-2 px-lg-3">
              <div class="card h-100 px-lg-5 card-span">
                <div class="card-body d-flex flex-column justify-content-around">
                  <div class="text-center pt-5"><img class="img-fluid" src="assets/img/icons/services-3.svg" alt="..." />
                    <h5 class="my-4">Personal Services</h5>
                  </div>
                  
                  <div class="text-center my-5">
                    <div class="d-grid">
                      <button class="btn btn-outline-danger" type="submit">Learn more </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>

      <section class="pt-7 pb-0">

        <div class="container">
          <div class="row">
            <div class="col-6 col-lg mb-5">
              <div class="text-center"><img src="assets/img/icons/awards.png" alt="..." />
                <h1 class="text-primary mt-4">26+</h1>
                <h5 class="text-800">Awards won</h5>
              </div>
            </div>
            <div class="col-6 col-lg mb-5">
              <div class="text-center"><img src="assets/img/icons/states.png" alt="..." />
                <h1 class="text-primary mt-4">65+</h1>
                <h5 class="text-800">States covered</h5>
              </div>
            </div>
            <div class="col-6 col-lg mb-5">
              <div class="text-center"><img src="assets/img/icons/clients.png" alt="..." />
                <h1 class="text-primary mt-4">689K+</h1>
                <h5 class="text-800">Happy clients</h5>
              </div>
            </div>
            <div class="col-6 col-lg mb-5">
              <div class="text-center"><img src="assets/img/icons/goods.png" alt="..." />
                <h1 class="text-primary mt-4">130M+</h1>
                <h5 class="text-800">Goods delivered</h5>
              </div>
            </div>
            <div class="col-6 col-lg mb-5">
              <div class="text-center"><img src="assets/img/icons/business.png" alt="..." />
                <h1 class="text-primary mt-4">130M+</h1>
                <h5 class="text-800">Business hours</h5>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>  

      <section>

        <div class="container" id="form">
          <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4"><img src="assets/img/illustrations/callback.png" alt="..." />
              <h5 class="text-danger">Contacter nous </h5>
              <p class="text-muted">Lundi à Samedi, 08 - 18</p>
            </div>
            <div class="col-md-6 col-lg-5 col-xl-4">
              <form class="row" method="post" action="index.php">
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="Name">Nom</label>
                  <input class="form-control form-quriar-control" id="Name" name="Name" type="text" placeholder="Name" required="required" />
                </div>
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="Email">Another label</label>
                  <input class="form-control form-quriar-control" id="Email" name="Email" type="email" placeholder="Email" required="required"/>
                </div>
                <div class="mb-5">
                  <label class="form-label visually-hidden" for="text">Message</label>
                  <textarea class="form-control form-quriar-control is-invalid border-400" name="text" id="text" placeholder="Message" style="height: 150px" required="required"></textarea>
                </div>
                <div class="d-grid">
                  <button class="btn btn-primary" type="submit">Envoyer Message<i class="fas fa-paper-plane ms-2"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>
 

      <section id="findUs">

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 mb-6 text-center">
              <h5 class="text-danger"></h5>
              <h2>Trouver Nous</h2>
            </div>
            <div class="col-12">
              <div class="card card-span rounded-2 mb-3">
                <div class="row">
                  <div class="col-md-6 col-lg-7 d-flex"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3196.427766008099!2d10.267349875416718!3d36.7603042699483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd49fa15643927%3A0xad64c8c462b52435!2sHigher%20Institute%20of%20Technological%20Studies%20of%20Rades!5e0!3m2!1sen!2stn!4v1700558505939!5m2!1sen!2stn" width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                  <div class="col-md-6 col-lg-5 d-flex flex-center">
                    <div class="card-body">
                      <h5>Contactez Nous</h5>
                      <p class="text-700 my-4"> <i class="fas fa-map-marker-alt text-warning me-3"></i><span>ISET Rades,  Ben Arous Tunisie</span></p>
                      <p><i class="fas fa-envelope text-warning me-3"> </i><a class="text-700" href="mailto:info@services.tn"> info@services.tn</a></p>
                              </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-primary px-5" type="submit"><i class="fas fa-phone-alt me-2"></i><a class="text-light" href="tel:123-456789">Contacter Nous +216 23 456 789</a></button>
              </div>
            </div>
          </div>
        </div>
        <!-- end of .container-->

      </section>

      <section class="py-0 bg-1000">

        <div class="container">
          <div class="row justify-content-md-between justify-content-evenly py-4">
            <div class="col-12 col-sm-8 col-md-6 col-lg-auto text-center text-md-start">
              <p class="fs--1 my-2 fw-bold text-200">All rights Reserved &copy; 2023</p>
            </div>
            <div class="col-12 col-sm-8 col-md-6">
              <p class="fs--1 my-2 text-center text-md-end text-200"> Made with&nbsp;
                <svg class="bi bi-suit-heart-fill" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#F95C19" viewBox="0 0 16 16">
                  <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"></path>
                </svg>&nbsp;by&nbsp; EYA & NAWRES</a>
              </p>
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
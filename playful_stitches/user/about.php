<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}

$category = isset($_GET['category']) ? $_GET['category'] : '';

$validCategories = ['crochet', 'embroidery', 'quilt', 'rug making'];
$category = in_array($category, $validCategories) ? $category : '';

$show_products = $conn->prepare("SELECT * FROM `products` WHERE category = :category");
$show_products->bindParam(':category', $category, PDO::PARAM_STR);
$show_products->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>About</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <!-- Include Montserrat font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />

  <!-- style.css -->
  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/about.css" />
</head>

<body style="background-color: #f8f7f6">
  <?php include '../user/header.php' ?>

  <!-- Main Container -->
  <main>
    <div class="second-nav">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="home.php">HOME</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
            aria-expanded="false">CATEGORIES</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="category.php?category=crochet">Crochet</a></li>
            <li><a class="dropdown-item" href="category.php?category=embroidery">Embroidery</a></li>
            <li><a class="dropdown-item" href="category.php?category=quilt">Quilt</a></li>
            <li><a class="dropdown-item" href="category.php?category=rug making">Rug Making</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">ABOUT</a>
        </li>
      </ul>
    </div>

    <div class="container">
      <h1 class="text-center p-5 mt-5" style="font-weight: bold; color: #a17d60">
        ABOUT
      </h1>

      <section class="about">
        <div class="wrapper">
          <div class="project">
            <div class="shop mt-5">
              <div class="image">
                <img src="../about.png" alt="Your Image" class="img-fluid mt-2">
              </div>
            </div>


            <div class="right-bar text-center">
              <p>Welcome to Playful Stitches – your go-to e-commerce wonderland for exquisite handmade
                crafts! We're
                not just
                a
                store; we're your one-stop haven for all things fiber arts, offering a delightful array of crafts
                like
                crocheting,
                quilting, embroidery, and the cozy magic of rug-making.</p>
              <p>

                But wait, there's more! Nestled in the heart of Alapan 2A, Imus, Cavite, our charming shop is a
                treasure
                trove
                waiting for you to explore. Come and experience the craftsmanship firsthand – visit us and let the
                magic of
                handmade creations enchant your senses! Your journey into the world of Playful Stitches begins here.
                See you
                soon!</p>

              <a href="category.php" class="btn-primary mx-auto" style="border-radius: 10px; width: 50%;">Shop Now!</a>
            </div>

          </div>

        </div>
      </section>

      <section class="steps">
        <div class="wrapper">
          <h2 class="text-center mt-5" style="font-weight: bold; color: #a17d60">
            How to order?
          </h2>
            <div class="crochet mt-5">
              <div class="row row-cols-1 row-cols-md-3 g-3">
                <div class="col">
                  <div class="card h-100 text-center mb-3" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Choose your order</h5>
                      <p class="card-text">Explore and order from our unique collection of handmade crafts.</p>
                      <a href="category.php" class="btn btn-primary">Order Now</a>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card h-100 text-center mb-3" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Delivery</h5>
                      <p class="card-text">Fast and reliable delivery to bring your handmade crafts to your doorstep.</p>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card h-100 text-center mb-3" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Enjoy your order</h5>
                      <p class="card-text">Experience the joy of handmade crafts delivered with care and crafted for your delight.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
      </section>
    </div>
    </div>
    </div>
  </main>

  <!-- End of container-->
  <?php include '../user/footer.php' ?>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- Navigation bar & footer using JavaScript -->
  <script src="../js/user.js"></script>

</body>

</html>
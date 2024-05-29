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
  <title>Playful Stitches</title>
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
</head>

<body style="background-color: #f8f7f6">
  <?php include '../user/header.php' ?>

  <!-- Main Container -->
  <main>
    <div class="second-nav">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">HOME</a>
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
          <a class="nav-link" href="about.php">ABOUT</a>
        </li>
      </ul>
    </div>

    <div class="container mt-5" style="height: 50vh">
      <img src="../bg.jpg" alt="bg" class="img-fluid w-100 h-100 rounded rounded-13" />
    </div>

    <div class="container">
      <h2 class="text-center p-5 mt-5 mb-4" style="font-weight: bold; color: #a17d60">
        SHOP CATEGORIES
      </h2>

      <div class="crochet">
        <div class="row">
          <div class="col">
            <h4 style="font-weight: bold; color: #a17d60">Crochet</h4>
          </div>
          <div class="col">
            <h4>
              <a href="category.php?category=crochet" class="float-end">See all</a>
            </h4>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <a href="category.php?category=crochet">
              <img src="../Products/crochet/1.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=crochet">
              <img src="../Products/crochet/2.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=crochet">
              <img src="../Products/crochet/3.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=crochet">
              <img src="../Products/crochet/4.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
        </div>
      </div>

      <div class="embroidery mt-5">
        <div class="row">
          <div class="col">
            <h4 style="font-weight: bold; color: #a17d60">Embroidery</h4>
          </div>
          <div class="col">
            <h4>
              <a href="category.php?category=embroidery" class="float-end">See all</a>
            </h4>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <a href="category.php?category=embroidery">
              <img src="../Products/embroidery/1.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=embroidery">
              <img src="../Products/embroidery/2.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=embroidery">
              <img src="../Products/embroidery/3.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=embroidery">
              <img src="../Products/embroidery/4.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
        </div>
      </div>

      <div class="quilt mt-5">
        <div class="row">
          <div class="col">
            <h4 style="font-weight: bold; color: #a17d60">Quilt</h4>
          </div>
          <div class="col">
            <h4>
              <a href="category.php?category=quilt" class="float-end">See all</a>
            </h4>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <a href="category.php?category=quilt">
              <img src="../Products/quilt/1.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=quilt">
              <img src="../Products/quilt/2.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=quilt">
              <img src="../Products/quilt/3.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=quilt">
              <img src="../Products/quilt/4.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
        </div>
      </div>

      <div class="rugmaking mt-5">
        <div class="row">
          <div class="col">
            <h4 style="font-weight: bold; color: #a17d60">Rug Making</h4>
          </div>
          <div class="col">
            <h4>
              <a href="category.php?category=rug making" class="float-end">See all</a>
            </h4>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <a href="category.php?category=rug making">
              <img src="../Products/rugmaking/1.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=rug making">
              <img src="../Products/rugmaking/2.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=rug making">
              <img src="../Products/rugmaking/3.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
          <div class="col">
            <a href="category.php?category=rug making">
              <img src="../Products/rugmaking/4.jpg" class="card-img-top rounded rounded-13" alt="..." />
            </a>
          </div>
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
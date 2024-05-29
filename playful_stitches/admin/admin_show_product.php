<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}

$category = isset($_GET['category']) ? $_GET['category'] : '';

$validCategories = ['crochet', 'embroidery', 'quilt', 'rug making'];
$category = in_array($category, $validCategories) ? $category : '';

$show_products = $conn->prepare("SELECT * FROM `products` WHERE category = :category");
$show_products->bindParam(':category', $category, PDO::PARAM_STR);
$show_products->execute();

if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];
  $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('../uploaded_img/' . $fetch_delete_image['image']);
  $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
  $delete_product->execute([$delete_id]);
  $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
  $delete_cart->execute([$delete_id]);
  header('location:admin_show_product.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Listed Items</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <link rel="stylesheet" href="../css/admin.css" />
</head>

<body style="background-color: #f8f7f6">
  <?php include '../admin/admin_header.php' ?>

  <main>
    <div class="container">
      <ul class="nav nav-tabs mt-5">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="admin_product.php">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Listed Items</a>
        </li>
      </ul>
    </div>

    <div class="container">
      <div class="box">
        <div>
          <section class="category">

            <div class="row text-center">
              <div class="col mt-4">
                <h4 style="font-weight: bold; color: #a17d60">Crochet</h4>
              </div>
              <div class="col mt-4">
                <h4 style="font-weight: bold; color: #a17d60">Embroidery</h4>
              </div>
              <div class="col mt-4">
                <h4 style="font-weight: bold; color: #a17d60">Quilt</h4>
              </div>
              <div class="col mt-4">
                <h4 style="font-weight: bold; color: #a17d60">Rug Making</h4>
              </div>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4">
              <div class="col">
                <a href="category.php?category=crochet">
                  <img src="../Products/crochet/1.jpg" class="card-img-top rounded rounded-13" alt="..." /></a>
              </div>
              <div class="col">
                <a href="category.php?category=embroidery">
                  <img src="../Products/embroidery/1.jpg" class="card-img-top rounded rounded-13" alt="..." /></a>
              </div>
              <div class="col">
                <a href="category.php?category=quilt">
                  <img src="../Products/quilt/1.jpg" class="card-img-top rounded rounded-13" alt="..." /></a>
              </div>
              <div class="col">
                <a href="category.php?category=rug making">
                  <img src="../Products/rugmaking/1.jpg" class="card-img-top rounded rounded-13" alt="..." /></a>
              </div>
            </div>

          </section>
        </div>
      </div>
    </div>
  </main>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- Include navigation bar using JavaScript -->
  <script src="../js/admin.js"></script>
</body>

</html>
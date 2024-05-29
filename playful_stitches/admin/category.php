<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}

// Fetch category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Validate and sanitize the category input to prevent SQL injection
$validCategories = ['crochet', 'embroidery', 'quilt', 'rug making'];
$category = in_array($category, $validCategories) ? $category : '';

// Check if category is set in the URL, otherwise check the session
if (isset($_GET['category'])) {
  $category = $_GET['category'];
} elseif (isset($_SESSION['category'])) {
  $category = $_SESSION['category'];
} else {
  // Handle the case where the category is not set
  // You might want to redirect to a default category or display an error message.
}

// Set the session variable for category
$_SESSION['category'] = $category;

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

  header("location:category.php?category=$category");
  exit;

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Category</title>
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
      <div class="container2">
        <div class="box2">
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_show_product.php">Category</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                <?= ucfirst($category); ?>
              </li>
            </ol>
          </nav>

          <?php
          $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
          $select_products->execute([$category]);
          if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
              ?>

              <div class="container2 mt-3 mb-3">
                <div class="inner-box justify-content-between">
                  <img src="../uploaded_img/<?= $fetch_products['image']; ?>" />
                  <div class="content">
                    <div class="row">
                      <div class="col-3">
                        <h6>Item:
                          <?= $fetch_products['name']; ?>
                        </h6>
                        <h6>Price: ₱
                          <?= $fetch_products['price']; ?>
                        </h6>
                      </div>
                      <div class="col-8">
                        <h6>Description:
                          <?= $fetch_products['description']; ?>
                        </h6>
                      </div>
                    </div>
                  </div>

                  <div class="mx-3">
                    <div class="row">
                      <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal"
                        data-bs-target="#updateProductModal" data-productid="<?= $fetch_products['id']; ?>">Update</button>
                      <a href="category.php?delete=<?= $fetch_products['id']; ?>" class="btn btn-danger mt-2"
                        onclick="return confirm('Delete this product?');">Delete</a>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo '<p class="empty">No products added yet!</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="updateProductModalBody">
          <?php include '../admin/admin_update_product.php' ?>
        </div>
      </div>
    </div>
  </div>

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
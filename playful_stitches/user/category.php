<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}
;

include 'add_cart.php';

// Fetch category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Validate and sanitize the category input
$validCategories = ['crochet', 'embroidery', 'quilt', 'rug making'];
$category = in_array($category, $validCategories) ? $category : '';

// Check if category is set in the URL
if (isset($_GET['category'])) {
  $category = $_GET['category'];
} elseif (isset($_SESSION['category'])) {
  $category = $_SESSION['category'];
} else {
  
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
  <?php include '../user/header.php' ?>

  <section>
    <div class="second-nav">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="category.php?category=crochet">Crochet</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="category.php?category=embroidery">Embroidery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="category.php?category=quilt">Quilt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="category.php?category=rug making">Rug Making</a>
        </li>
      </ul>
    </div>

    <div class="container">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mt-4">
          <li class="breadcrumb-item"><a href="home.php">Back to home</a></li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= ucfirst($category); ?>
          </li>
        </ol>
      </nav>

      <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
        $select_products->execute([$category]);

        if ($select_products->rowCount() > 0) {
          while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col">
              <div class="card container mt-2 fw-bold" style="width: 18rem">
                <form action="" method="post">
                  <img src="../uploaded_img/<?= $fetch_products['image']; ?>" class="card-img-top mt-3"
                    alt="<?= $fetch_products['name']; ?>" />
                  <div class="card-body">
                    <h5 class="card-title">
                      <?= $fetch_products['name']; ?>
                    </h5>
                    <div class="row">
                      <div class="col-6">
                        <h4 class="card-text">₱
                          <?= $fetch_products['price']; ?>
                        </h4>
                      </div>
                      <div class="col-4">
                        <h4 class="quantity">
                          <input type="number" name="qty" class="qty form-control" min="1" max="99" value="1" maxlength="2">
                        </h4>
                      </div>
                      <div class="col-2">
                        <!-- View icon -->
                        <a href="view.php?pid=<?= $fetch_products['id']; ?>" class="btn btn-link">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-eye-fill"
                            viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                              d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                          </svg>
                        </a>
                      </div>
                    </div>

                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

                    <button type="submit" name="add_to_cart" class="btn btn-primary d-flex justify-content-center w-100 mt-2">Add
                      to
                      Cart</button>
                </form>
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

  <!-- End of container-->
  <?php include '../user/footer.php' ?>

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
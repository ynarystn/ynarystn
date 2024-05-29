<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}
;

if (isset($_POST['add_product'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_STRING);

  $description = $_POST['description'];
  $description = filter_var($description, FILTER_SANITIZE_STRING);

  $category = $_POST['category'];
  $category = filter_var($category, FILTER_SANITIZE_STRING);

  $image = $_FILES['image']['name'];
  $image = filter_var($image, FILTER_SANITIZE_STRING);
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = '../uploaded_img/' . $image;

  $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
  $select_products->execute([$name]);

  if ($select_products->rowCount() > 0) {
    $message[] = 'product name already exists!';
  } else {
    if ($image_size > 2000000) {
      $message[] = 'image size is too large';
    } else {
      move_uploaded_file($image_tmp_name, $image_folder);

      $insert_product = $conn->prepare("INSERT INTO `products`(name, price, description, category, image) VALUES(?,?,?,?,?)");
      $insert_product->execute([$name, $price, $description, $category, $image]);

      $message[] = 'new product added!';
    }

  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Product</title>
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
          <a class="nav-link active" aria-current="page" href="#">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_show_product.php">Listed Items</a>
        </li>
      </ul>
    </div>

    <div class="container">
      <div class="box">
        <div class="container-form mx-auto">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <input type="text" class="form-control" id="productName" placeholder="Product name" name="name"
                maxlength="100" required>
            </div>

            <div class="mb-3">
              <input type="number" class="form-control" id="price" placeholder="Price" min="0" max="9999999999"
                name="price" onkeypress="if(this.value.length == 10) return false;" required>
            </div>

            <div class="mb-3">
              <textarea class="form-control" id="description" placeholder="Description" rows="3" name="description"
                maxlength="500" required></textarea>
            </div>

            <div class="mb-3">
              <select class="form-select" id="category" name="category" required>
                <option value="" disabled selected>Select a category</option>
                <option value="Crochet">Crochet</option>
                <option value="Embroidery">Embroidery</option>
                <option value="Quilt">Quilt</option>
                <option value="Rug Making">Rug Making</option>
              </select>
            </div>

            <div class="mb-3">
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="add-product-btn w-100" name="add_product">Add Product</button>
          </form>
        </div>
      </div>

    </div>
  </main>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- Include navigation bar using JavaScript -->
  <script src="../js/admin.js"></script>
</body>

</html>
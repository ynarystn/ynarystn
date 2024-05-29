<?php
include '../components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}

include 'add_cart.php';

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
  <link rel="stylesheet" href="../css/style.css" />
</head>

<body style="background-color: #f8f7f6">

  <?php include 'header.php' ?>

  <section class="quick-view">
    <div class="container">

      <?php
      if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$pid]);

        if ($select_products->rowCount() > 0) {
          while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            $name = $fetch_products['name'];
            ?>
            <div class="container">
              <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mt-4">
                  <li class="breadcrumb-item"><a href="category.php">Back to Category</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <?= ucfirst($name); ?>
                  </li>
                </ol>
              </nav>
            </div>

            <div class="row">
              <div class="col">
                <!-- Card -->
                <div class="card container mt-4" style="width: 25rem">
                  <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" class="card-img-top mt-3 mb-3">
                </div>
              </div>

              <div class="col">
                <!-- Card Details -->
                <div class="container mt-4" style="width: 45rem; margin-right: 3rem;">
                  <div class="card-body">
                    <h1 class="card-title">
                      <?= $fetch_products['name']; ?>
                    </h1>
                    <h5 class="mt-3">Description</h5>
                    <h6>
                      <?= $fetch_products['description']; ?>
                    </h6>
                    <h2 class="card-text">₱
                      <?= $fetch_products['price']; ?>
                    </h2>
                    <form action="" method="post">
                      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

                      <h6>Quantity:
                      <input type="number" name="qty" class="qty mt-5" min="1" max="99" value="1" maxlength="2"></h6>

                      <button type="submit" name="add_to_cart" class="btn btn-primary d-flex justify-content-center w-100 mt-2">Add to
                        Cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php
          }
        } else {
          echo '<p class="empty">No products added yet!</p>';
        }
      } else {
        echo '<p class="empty">Product ID not provided in the URL!</p>';
      }
      ?>

    </div>


  </section>

  <?php include '../user/footer.php' ?>

  <!-- custom js file link  -->
  <script src="../js/user.js"></script>

</body>

</html>
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <!-- Include Montserrat font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />

  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>

<body style="background: #f8f7f6">

  <?php include '../user/header.php'; ?>

  <section class="products" style="min-height: 100vh; padding-top:0;">

    <div class="container">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mt-4">
          <li class="breadcrumb-item"><a href="home.php">Back to home</a></li>
          <li class="breadcrumb-item active" aria-current="page">
            Search
          </li>
        </ol>
      </nav>

      <div class="row row-cols-1 row-cols-md-4 g-4">

        <?php
        if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
          $search_box = $_POST['search_box'];
          $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
          $select_products->execute();
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

                      <button type="submit" name="add_to_cart"
                        class="btn btn-primary d-flex justify-content-center w-100 mt-2">Add
                        to
                        Cart</button>
                  </form>
                </div>
              </div>
            </div>
            <?php
            }
          } else {
            echo '<p class="empty">No products!</p>';
          }
        }
        ?>

    </div>

    </div>

  </section>











  <!-- footer section starts  -->
  <?php include 'footer.php'; ?>
  <!-- footer section ends -->







  <!-- custom js file link  -->
  <script src="../js/user.js"></script>

</body>

</html>
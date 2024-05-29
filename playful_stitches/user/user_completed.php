<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('location:home.php');
}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Completed Order</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    type="text/css" />

  <!-- style.css -->
  <link rel="stylesheet" href="../css/user_order.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/admin.css" />

  <style>
    .box_order {
      flex: 80%;
      margin-left: 20px;
      padding: 20px;
      border-radius: 5px;
    }
  </style>

</head>

<body style="background: #f8f7f6">

  <?php include 'header.php'; ?>

  <div class="container">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          Orders
        </li>
      </ol>
    </nav>

    <main>
      <div class="container">
        <div class="wrapper">
          <div class="project mt-5">
            <div class="shop">
              <div class="container2 text-center">
                <div>
                  <p class="bi bi-person-circle mb-3" style="font-size: 3rem">
                </div>
                <h4 class="mt-2">
                  <?= $fetch_profile['name']; ?>
                </h4>
              </div>

              <div class="container2 mt-3">
                <h6><i class="bi bi-person"></i> <a href="profile.php">Personal Information</a></h6>
                <h6><i class="bi bi-geo-alt"></i> <a href="address.php">Address</a></h6>
              </div>

              <div class="container2 mt-3 mb-3">
                <h6><i class="bi bi-box"></i> <a href="orders.php">My Orders</a></h6>
                <h6><i class="bi bi-check2-square"></i> <a href="#">Completed Orders</a></h6>
              </div>

              <div class="container2 mt-3 mb-3">
                <h6><i class="bi bi-box-arrow-right"></i> <a href="logout.php"
                    onclick="return confirm('Are you sure you want to logout?');" style="text-decoration: none">Sign
                    Out</a>
                </h6>
              </div>

            </div>

            <div class="box_order">
              <h3 class="mb-4">My Completed Orders</h3>
              <?php
              if ($user_id == '') {
                echo '<p class="empty">Please login to see your orders</p>';
              } else {
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? AND payment_status = 'delivered'");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0) {
                  while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="container2 mt-3 mb-3">
                      <div class="box3 justify-content-between">
                        <div class="content">
                          <h6>Placed on:
                            <?= $fetch_orders['placed_on']; ?>
                          </h6>
                          <h6>Items:
                            <?= $fetch_orders['total_products']; ?>
                          </h6>
                          <h6>Total: ₱
                            <?= number_format($fetch_orders['total_price'], 2); ?>
                          </h6>
                          <h6>Name:
                            <?= $fetch_orders['name']; ?>
                          </h6>
                          <h6>Email:
                            <?= $fetch_orders['email']; ?>
                          </h6>
                          <h6>Number:
                            <?= $fetch_orders['number']; ?>
                          </h6>
                          <h6>Address:
                            <?= $fetch_orders['address']; ?>
                          </h6>
                        </div>
                        <div class="text-end">
                          <h5>Order Status: <span class="fw-bold"
                              style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                              <?= $fetch_orders['payment_status']; ?>
                            </span>
                          </h5>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  echo '<p class="empty">No completed orders found!</p>';
                }
              }
              ?>
            </div>

          </div>
        </div>
      </div>
    </main>

  </div>

  <?php include '../user/footer.php' ?>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- Include navigation bar using JavaScript -->
  <script src="../js/user.js"></script>

</body>

</html>
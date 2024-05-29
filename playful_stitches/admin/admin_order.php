<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}
;

if (isset($_POST['update_payment'])) {
  $order_id = $_POST['order_id'];
  $payment_status = $_POST['payment_status'];

  // Update the payment_status in the orders table
  $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
  $update_status->execute([$payment_status, $order_id]);

  // Assuming $user_id is the ID of the user (retrieve it based on the order_id)
  $get_user_id = $conn->prepare("SELECT user_id FROM orders WHERE id = ?");
  $get_user_id->execute([$order_id]);
  $user_id = $get_user_id->fetchColumn();

  // Get the order number
  $get_order_number = $conn->prepare("SELECT id FROM orders WHERE id = ?");
  $get_order_number->execute([$order_id]);
  $order_number = $get_order_number->fetchColumn();

  // Add a notification for the user
  $notification_message = "Your order for #$order_number is now $payment_status";
  $add_notification = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
  $add_notification->execute([$user_id, $notification_message]);

  $message[] = 'Order status updated!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Placed Order</title>
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
    <div class="container mt-5">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Placed Order</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_completed.php">Completed Order</a>
        </li>
      </ul>
    </div>

    <div class="container mb-5">
      <div class="box">
        <?php
        $select_orders = $conn->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        if ($select_orders->rowCount() > 0) {
          while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            // Check if payment_status or order_status is not "delivered"
            if ($fetch_orders['payment_status'] !== 'delivered') {
              ?>
              <div class="container2 mt-3 mb-3">
                <div class="inner-box justify-content-between">
                  <div class="content">
                    <div class="row">
                      <div class="col-6">
                        <h6>Placed on:
                          <?= $fetch_orders['placed_on']; ?>
                        </h6>
                        <h6>Item:
                          <?= $fetch_orders['total_products']; ?>
                        </h6>
                        <h6>Order Total: ₱
                          <?= number_format($fetch_orders['total_price'], 2); ?>
                        </h6>
                      </div>
                      <div class="col-6">
                        <h6>Name:
                          <?= $fetch_orders['name']; ?>
                        </h6>
                        <h6>Address:
                          <?= $fetch_orders['address']; ?>
                        </h6>
                        <h6>Number:
                          <?= $fetch_orders['number']; ?>
                        </h6>
                        <h6>Email:
                          <?= $fetch_orders['email']; ?>
                        </h6>
                      </div>
                    </div>
                  </div>

                  <div class="text-end">
                    <form action="" method="POST">
                      <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                      <select name="payment_status" class="drop-down btn btn-secondary">
                        <option value="" selected disabled>
                          <?= $fetch_orders['payment_status']; ?>
                        </option>
                        <option value="pending">Pending</option>
                        <option value="preparing">Preparing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                      </select>
                      <div class="flex-btn">
                        <input type="submit" value="Update" class="btn btn-primary mt-2" name="update_payment">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php
            }
          }
        } else {
          echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
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
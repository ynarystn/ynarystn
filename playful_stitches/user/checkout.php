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

// Calculate total_products and total_price based on the cart items
$grand_total = 0;
$total_products = '';
$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);
if ($select_cart->rowCount() > 0) {
  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
    $total_products .= $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
  }
}

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $address = $_POST['address'];
  $address = filter_var($address, FILTER_SANITIZE_STRING);
  $total_products = $_POST['total_products'];
  $total_price = $_POST['total_price'];

  $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
  $check_cart->execute([$user_id]);

  if ($check_cart->rowCount() > 0) {

    if ($address == '') {
      $message[] = 'Please add your address!';
    } else {

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, address, total_products, total_price) VALUES(?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';

      sleep(1);

      header('Location: home.php');
      exit;
    }

  } else {
    $message[] = 'Your cart is empty';
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    type="text/css" />

  <!-- style.css -->
  <link rel="stylesheet" href="../css/checkout.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/admin.css" />

</head>

<body style="background: #f8f7f6">

  <?php include 'header.php'; ?>

  <div class="container">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item"><a href="cart.php">Back to cart</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          Checkout
        </li>
      </ol>
    </nav>

    <section class="checkout">
      <div class="wrapper">
        <h2 class="mt-3 mb-3">Check Out</h2>
        <div class="project">
          <div class="shop">

            <form action="" method="post">
              <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
              <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
              <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
              <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
              <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
              <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

              <div class="container2">
                <h5 class="mb-3">Your Details</h5>
                <h6><i class="bi bi-person-fill"></i><span>
                    <?= $fetch_profile['name'] ?>
                  </span></h6>
                <h6><i class="bi bi-telephone-fill"></i><span>
                    <?= $fetch_profile['number'] ?>
                  </span></h6>
                <h6><i class="bi bi-envelope-fill"></i><span>
                    <?= $fetch_profile['email'] ?>
                  </span></h6>
                <button class="btn btn-secondary mt-2"><a href="update_profile.php"
                    style="text-decoration: none; color: white">Update Details</a></button>
                    
              </div>

              <div class="container2 mt-3">
                <h5 class="mb-3">Delivery Address</h5>
                <h6><i class="bi bi-geo-alt-fill"></i><span>
                    <?php if ($fetch_profile['address'] == '') {
                      echo 'Please enter your address';
                    } else {
                      echo $fetch_profile['address'];
                    } ?>
                  </span></h6>
                <button class="btn btn-secondary mt-2"><a href="update_address.php"
                    style="text-decoration: none; color: white">Update Address</a></button>
              </div>

              <div class="container2 mt-3">
                <h5 class="mb-3">Payment Method</h5>
                <h6 style="color: #646464">Cash on delivery</h6>
              </div>

              <div class="container2 mt-3 mb-3">
                <h5 class="mb-3">Review Your Item</h5>
                <?php
                $grand_total = 0;
                $cart_items[] = '';
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    ?>
                    <h6><span class="name">
                        <?= $fetch_cart['name']; ?>
                      </span><span class="price">₱
                        <?= $fetch_cart['price']; ?> x
                        <?= $fetch_cart['quantity']; ?>
                      </span></h6>
                    <?php
                  }
                } else {
                  echo '<p class="empty">Your cart is empty!</p>';
                }
                ?>
                <button class="btn btn-secondary mt-2"><a href="cart.php"
                    style="text-decoration: none; color: white">View Cart</a></button>
              </div>

          </div>

          <div class="right-bar">
            <h3 class="mb-4">Order Summary</h3>

            <p>Subtotal : <span>₱
                <?= $grand_total; ?>
              </span></p>

            <p><span>Shipping</span> <span>₱ 40</span></p>
            <hr />

            <p class="grand-total"><span class="name">Order Total: </span><span class="price">₱
                <?= $grand_total + 40; ?>
              </span></p>

            <input type="submit" value="Place Your Order"
              class="btn <?php echo ($fetch_profile['address'] == '') ? 'disabled' : ''; ?>"
              style="width: 100%; background-color: #986c4a; color: #fff; display: block; text-align: center; font-weight: 900;"
              name="submit">
          </div>

          </form>
        </div>
      </div>
    </section>
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
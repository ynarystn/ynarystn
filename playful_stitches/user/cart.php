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

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- Bootstrap CSS v5.2.1 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

   <!-- Include Montserrat font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />

   <link rel="stylesheet" href="../css/admin.css" />
   <link rel="stylesheet" href="../css/cart.css" />
</head>

<body style="background: #f8f7f6">

   <?php include 'header.php'; ?>

   <main class="products">

      <div class="container">
         <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mt-4">
               <li class="breadcrumb-item"><a href="category.php">Continue shopping</a></li>
               <li class="breadcrumb-item active" aria-current="page">
                  Cart
               </li>
            </ol>
         </nav>

         <div class="wrapper">
            <h1>Your Cart</h1>
            <div class="project">
               <div class="shop">
                  <?php
                  $grand_total = 0;
                  $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $select_cart->execute([$user_id]);
                  if ($select_cart->rowCount() > 0) {
                     while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form action="" method="post" class="box2">
                           <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

                           <img src="../uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                           <div class="content">
                              <div class="row">
                                 <div class="col">
                                    <h5 class="name">
                                       <?= $fetch_cart['name']; ?>
                                    </h5>
                                 </div>

                                 <div class="col d-flex justify-content-end">
                                    <h6 class="sub-total"> Sub Total : <span>₱
                                          <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                                       </span> </h6>
                                 </div>
                              </div>
                              <div class="flex">
                                 <h5 class="price"><span>Price: ₱</span>
                                    <?= $fetch_cart['price']; ?>
                                 </h5>

                                 <div class="update">
                                    <p>Quantity: <input type="number" name="qty" class="qty" min="1" max="99"
                                          value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                                       <button type="submit" name="update_qty">Update</button>
                                    </p>
                                 </div>

                                 <p class="btn-area">
                                    <button type="submit" class="bi bi-trash-fill" name="delete"
                                       onclick="return confirm('delete this item?');"></button>
                                 </p>

                              </div>

                           </div>
                        </form>
                        <?php
                        $grand_total += $sub_total;
                     }
                  } else {
                     echo '<p class="empty">Your cart is empty</p>';
                  }
                  ?>

               </div>
               <div class="right-bar">

                  <div class="cart-total">
                     <p>Cart Total : <span>₱
                           <?= $grand_total; ?>
                        </span></p>
                     <?php if ($select_cart->rowCount() > 0): ?>
                        <hr />
                        
                        <a href="checkout.php" class="btn-secondary <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i
                              class="bi bi-cart-fill"></i>Proceed to checkout</a>
                        <hr />
                        <form action="" method="post">
                           <button type="submit"
                              class="btn-primary d-flex justify-content-center w-100 <?= ($grand_total > 1) ? '' : 'disabled'; ?>"
                              name="delete_all" onclick="return confirm('delete all from cart?');"><i
                                 class="bi bi-trash-fill"></i>Delete all</button>
                        </form>
                     <?php endif; ?>
                  </div>

               </div>
            </div>
         </div>

   </main>

   <!-- shopping cart section ends -->

   <?php include '../user/footer.php' ?>



   <!-- Bootstrap JavaScript Libraries -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>

   <!-- Include navigation bar using JavaScript -->
   <script src="../js/admin.js"></script>

</body>

</html>
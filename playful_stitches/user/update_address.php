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

if (isset($_POST['submit'])) {

  $address = $_POST['building'] . ', ' . $_POST['province'] . ', ' . $_POST['city'] . ', ' . $_POST['barangay'];
  $address = filter_var($address, FILTER_SANITIZE_STRING);

  $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
  $update_address->execute([$address, $user_id]);

  $message[] = 'Address saved!';

  sleep(1);

  header('Location: checkout.php');
  exit;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Address</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    type="text/css" />

  <!-- style.css -->

  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="../css/form_input.css" />

</head>

<body style="background: #f8f7f6">

  <?php include 'header.php'; ?>

  <div class="container">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item"><a href="checkout.php">Back to checkout</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          Update Address
        </li>
      </ol>
    </nav>

    <section class="form-container">

      <div class="container mt-5">
        <div class="wrapper">
          <div class="project">
            <div class="shop">
              <div class="container2">
                <h5 class="mb-3">Your Address</h5>

                <form action="" method="post">

                  <div class="form-group">
                    <input type="text" placeholder="Street Name, Building, House No." required maxlength="50"
                      name="building">
                  </div>

                  <div class="form-group">
                    <input type="text" placeholder="Province" required maxlength="50" name="province">
                  </div>

                  <div class="form-group">
                    <input type="text" placeholder="City / Municipality" required maxlength="50" name="city">
                  </div>

                  <div class="form-group">
                    <input type="text" placeholder="Barangay" required maxlength="50" name="barangay">

                  </div>

                  <input type="submit" value="Save Address" name="submit" class="btn btn-secondary"
                    style="width: 100%; background-color: #986c4a; color: #fff; display: block; text-align: center; font-weight: 900;">
                </form>
              </div>
            </div>
          </div>
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
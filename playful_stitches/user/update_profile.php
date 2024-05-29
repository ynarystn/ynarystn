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

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);

  if (!empty($name)) {
    $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
    $update_name->execute([$name, $user_id]);
  }

  if (!empty($email)) {
    $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_email->execute([$email]);
    if ($select_email->rowCount() > 0) {
      $message[] = 'email already taken!';
    } else {
      $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
      $update_email->execute([$email, $user_id]);
    }
  }

  if (!empty($number)) {
    $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
    $select_number->execute([$number]);
    if ($select_number->rowCount() > 0) {
      $message[] = 'number already taken!';
    } else {
      $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
      $update_number->execute([$number, $user_id]);
    }
  }

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
  <title>Update Profile</title>

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
          Update Profile
        </li>
      </ol>
    </nav>

    <section class="form-container update-form">

      <div class="container mt-5">
        <div class="wrapper">
          <div class="project">
            <div class="shop">
              <div class="container2">
                <h5 class="mb-3">Update Profile</h5>

                <form action="" method="post">

                  <div class="form-group">
                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50">
                  </div>


                  <div class="form-group">
                    <input style="width: 100%" type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>"
                      maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                  </div>

                  <div class="form-group">
                    <input style="width: 100%" type="number" name="number"
                      placeholder="<?= $fetch_profile['number']; ?>" min="0" max="9999999999" maxlength="20">
                  </div>

                  <input type="submit" value="Save changes" name="submit" class="btn btn-secondary"
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

<!--

<form action="" method="post">
      <h3>your address</h3>

      <input type="text" class="box" placeholder="building no." required maxlength="50" name="building">


      <input type="text" class="box" placeholder="town name" required maxlength="50" name="town">

      <input type="text" class="box" placeholder="city name" required maxlength="50" name="city">


      <input type="text" class="box" placeholder="country name" required maxlength="50" name="country">

      <input type="number" class="box" placeholder="pin code" required max="999999" min="0" maxlength="6" name="pin_code">

      <input type="submit" value="save address" name="submit" class="btn">
   </form>




-->
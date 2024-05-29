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

  $old_password = sha1($_POST['old_pass']);
  $new_password = sha1($_POST['new_pass']);
  $confirm_password = sha1($_POST['confirm_pass']);

  // Verify old password
  $check_password = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND password = ?");
  $check_password->execute([$user_id, $old_password]);

  if ($check_password->rowCount() > 0) {
    if ($new_password == $confirm_password) {
      // Update password
      $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
      $update_password->execute([$new_password, $user_id]);

      echo "Password updated successfully!";
    } else {
      echo "New password and confirm password do not match.";
    }
  } else {
    echo "Incorrect old password.";
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    type="text/css" />

  <!-- style.css -->
  <link rel="stylesheet" href="../css/profile.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/admin.css" />

</head>

<body style="background: #f8f7f6">

  <?php include 'header.php'; ?>

  <div class="container">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb mt-4">
        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          Personal Information
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
                <h6><i class="bi bi-person"></i> <a href="#">Personal Information</a></h6>
                <h6><i class="bi bi-geo-alt"></i> <a href="address.php">Address</a></h6>
              </div>

              <div class="container2 mt-3 mb-3">
                <h6><i class="bi bi-box"></i> <a href="orders.php">My Orders</a></h6>
                <h6><i class="bi bi-check2-square"></i> <a href="user_completed.php">Completed Orders</a></h6>
              </div>

              <div class="container2 mt-3 mb-3">
                <h6><i class="bi bi-box-arrow-right"></i> <a href="logout.php"
                    onclick="return confirm('Are you sure you want to logout?');" style="text-decoration: none">Sign
                    Out</a></h6>
              </div>

            </div>

            <div class="right-bar">
              <h3 class="mb-4">Personal Information</h3>

              <form action="" method="post">

                <div class="form-group">
                  <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50">
                </div>


                <div class="form-group">
                  <input style="width: 100%" type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>"
                    maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="form-group">
                  <input style="width: 100%" type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"
                    min="0" max="9999999999" maxlength="20">
                </div>

                <div class="form-group">
                  <input style="width: 100%" type="password" name="old_pass" placeholder="Old password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="current-password">
                </div>

                <div class="form-group">
                  <input style="width: 100%" type="password" name="new_pass" placeholder="New password" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="new-password">
                </div>

                <div class="form-group">
                  <input style="width: 100%" type="password" name="confirm_pass" placeholder="Confirm new password"
                    maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="new-password">
                </div>

                <input type="submit" value="Save changes" name="submit" class="btn btn-secondary"
                  style="width: 100%; background-color: #986c4a; color: #fff; display: block; text-align: center; font-weight: 900;">
              </form>
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
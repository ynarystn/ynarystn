<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
  exit(); // Add exit to stop execution after redirect
}

// Fetch existing admin details from the database
$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
$select_admin->execute([$admin_id]);
$admin_details = $select_admin->fetch(PDO::FETCH_ASSOC);

// Process form submission for updating details
if (isset($_POST['update_details'])) {
  // Sanitize and get the new values from the form
  $newUsername = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
  $newEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $newPhoneNumber = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
  $newAddress = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

  // Update the database with the new values
  $update_admin = $conn->prepare("UPDATE `admin` SET username=?, email=?, number=?, address=? WHERE id = ?");
  $update_admin->execute([$newUsername, $newEmail, $newPhoneNumber, $newAddress, $admin_id]);

  $old_password_input = $_POST['old_pass'];
  $new_password = $_POST['new_pass'];
  $confirm_password = $_POST['confirm_pass'];

  // Retrieve the current password from the database
  $get_current_password = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
  $get_current_password->execute([$admin_id]);
  $current_password_row = $get_current_password->fetch(PDO::FETCH_ASSOC);

  $current_password = $current_password_row['password'];

  // Check if the entered old password matches the stored current password
  if ($old_password_input == $current_password) {
    if ($new_password == $confirm_password) {
      // Update password
      $update_password = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
      $update_password->execute([$new_password, $admin_id]);

      echo "Password updated successfully!";
      
    } else {
      echo "New password and confirm password do not match.";
    }
  } else {
    echo "Incorrect old password.";
  }

  sleep(1);
  
  // Redirect after update
  header('location:admin_profile.php');
  exit(); // Add exit to stop execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Profile</title>
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
          <a class="nav-link active" aria-current="page" href="#">Shop Information</a>
        </li>
      </ul>
    </div>

    <div class="container">
      <div class="box">
        <div class="container-form mx-auto">
          <form method="POST">
          <div class="mb-3">
              <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                maxlength="100" required value="<?= $admin_details['username']; ?>">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="email" placeholder="Email Address" name="email"
                maxlength="100" required value="<?= $admin_details['email']; ?>">
            </div>

            <div class="mb-3">
              <input type="tel" class="form-control" id="phoneNumber" placeholder="Number" name="number" maxlength="100"
                required value="<?= $admin_details['number']; ?>">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="address" placeholder="Address" name="address" maxlength="100"
                required value="<?= $admin_details['address']; ?>">
            </div>

            <div class="mb-3">
              <input type="password" class="form-control" name="old_pass" placeholder="Old password" maxlength="50"
                oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="current-password">
            </div>

            <div class="mb-3">
              <input type="password" class="form-control" name="new_pass" placeholder="New password" maxlength="50"
                oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="new-password">
            </div>

            <div class="mb-3">
              <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm new password"
                maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="new-password">
            </div>

            <div class="mb-3">
              <button type="submit" class="add-product-btn w-100" name="update_details">Submit</button>
            </div>
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
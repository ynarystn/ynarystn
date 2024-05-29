<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}
;

if (isset($_POST['submit'])) {

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);

  $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
  $select_user->execute([$email, $pass]);
  $row = $select_user->fetch(PDO::FETCH_ASSOC);

  if ($select_user->rowCount() > 0) {
    $_SESSION['user_id'] = $row['id'];
    header('location:home.php');
  } else {
    $message[] = 'Incorrect username or password!';
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <!-- Include Montserrat font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />

  <!-- style.css -->
  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>

<body style="background-color: #f8f7f6">
  <?php include '../user/header.php' ?>

  <section class="form-container container mt-5">

    <form action="" method="post">
      <h3>Sign in</h3>
      <input type="email" name="email" required placeholder="Email" class="box" maxlength="50"
        oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Password" class="box" maxlength="50"
        oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Sign in" name="submit" class="btn btn-primary w-50 mt-3">
      <p class="mt-3">Don't have an account? <a href="register.php">Sign up</a></p>

      <div class="mt-2">
        <?php
        if (isset($message)) {
          foreach ($message as $message) {
            echo '
                <span>' . $message . '</span>';
          }
        }
        ?>
      </div>
    </form>


  </section>





  <!-- custom js file link  -->
  <script src="../js/user.js"></script>

</body>

</html>
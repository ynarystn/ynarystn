<?php

include '../components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}
;

// Retrieve unread notifications for the user
$get_notifications = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$get_notifications->execute([$user_id]);
$notifications = $get_notifications->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

  <!-- Include Montserrat font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" />

  <link rel="stylesheet" href="../css/admin.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/cart.css" />
</head>

<body style="background: #f8f7f6">

  <?php include '../user/header.php'; ?>

  <section class="products" style="min-height: 100vh; padding-top:0;">

    <div class="container">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mt-4">
          <li class="breadcrumb-item"><a href="home.php">Back to home</a></li>
          <li class="breadcrumb-item active" aria-current="page">
            Notification
          </li>
        </ol>
      </nav>

      <div class="wrapper">
        <div class="project">
          <div class="shop text-center">
            <h2 class="mt-4 mb-4">Notification</h2>
            <div class="row">
              <div class="col">
                <?php
                // Display notifications to the user
                foreach ($notifications as $notification) {
                  echo '<div class="notification-container bg-white mb-3 p-3">';
                  echo '<h5>' . $notification['message'] . '</h5>';
                  echo '<hr>'; // Add a line between notifications
                  echo '<p class="text-muted">' . date("F j, Y, g:i a", strtotime($notification['created_at'])) . '</p>';
                  echo '</div>';

                  // Mark the notification as read
                  $mark_as_read = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
                  $mark_as_read->execute([$notification['id']]);
                }
                ?>
              </div>
            </div>
          </div>
        </div>
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
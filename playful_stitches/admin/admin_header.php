<?php
if (isset($message)) {
  foreach ($message as $message) {
    echo '
        <span>' . $message . '</span>
      ';
  }
}
?>

<header class="header">

  <section class="flex">

    <nav class="navbar navbar-expand-lg" style="background-color: #e8d9c6">

      <div class="container">

        <img src="../logo/logo.png" alt="logo" width="200" />
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0 d-flex ms-auto align-items-center">

            <li class="nav-item">
              <a class="nav-link active" style="margin-right: 15px;" aria-current="page"
                href="admin_order.php">ORDERS</a>
            </li>

            <li class="nav-item">
              <a class="nav-link active" style="margin-right: 15px;" href="admin_product.php">PRODUCTS</a>
            </li>

            <div class="icons">
              <li class="nav-item">
                <div id="user-btn" class="bi bi-person-circle" style="font-size: 2em;"></div>
              </li>
            </div>

          </ul>

        </div>
      </div>
    </nav>

    <div class="profile">
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
      $select_profile->execute([$admin_id]);
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="buttons-container">
        <button type="button" class="btn btn-success mt-2">
          <a href="admin_profile.php" style="text-decoration: none">Update profile</a>
        </button>
        <button type="button" class="btn btn-danger mt-2">
          <a href="admin_logout.php" onclick="return confirm('logout from this website?');"
            style="text-decoration: none">Logout</a>
        </button>
      </div>
    </div>

  </section>
</header>
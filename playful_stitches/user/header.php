<header class="header">

  <section class="flex">

    <nav class="navbar navbar-expand-lg" style="background-color: #e8d9c6">

      <div class="container">
        <a href="home.php">
          <img src="../logo/logo.png" alt="logo" width="200" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search -->
          <!--<form class="d-flex ms-auto" role="search">
            <input class="form-control col-12 me-2" type="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>-->

          <form method="post" action="search.php" class="d-flex ms-auto">
            <input type="text" name="search_box" placeholder="Search..." class="form-control col-12 me-2">
            <button type="submit" name="search_btn" class="btn btn-outline-success d-none d-lg-inline">Search</button>
          </form>

          <ul class="navbar-nav mb-2 mb-lg-0 d-flex ms-auto align-items-center">

            <div class="icons">
              <li class="nav-item">
                <?php
                // Retrieve unread notifications count for the user
                $get_unread_notifications_count = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
                $get_unread_notifications_count->execute([$user_id]);
                $unread_notifications_count = $get_unread_notifications_count->fetchColumn();
                ?>
                <a class="nav-link" href="notification.php" style="margin-right: 15px">
                <span class="d-inline d-lg-none">Notifications</span>
                  <i class="bi bi-bell d-none d-lg-inline" style="font-size: 2em"></i><span>
                    <?php if ($unread_notifications_count > 0): ?>
                      <span class="badge bg-danger" style="margin-left: 5px;">
                        <?= $unread_notifications_count; ?>
                      </span>
                    <?php endif; ?>
                  </span>
                </a>
              </li>

            </div>

            <div class="icons">
              <li class="nav-item">
                <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
                ?>
                <a class="nav-link" href="cart.php" style="margin-right: 15px">
                <span class="d-inline d-lg-none">Cart</span>
                  <i class="bi bi-cart4 d-none d-lg-inline" style="font-size: 2em"></i><span>(
                    <?= $total_cart_items; ?>)
                  </span>
                </a>
              </li>
            </div>

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
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_profile->execute([$user_id]);
      if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="buttons-container">
          <p class="name">
            <?= $fetch_profile['name']; ?>
          </p>
          <button type="button" class="btn btn-success mt-2">
            <a href="profile.php" style="text-decoration: none">Profile</a>
          </button>
          <button type="button" class="btn btn-danger mt-2">
            <a href="logout.php" onclick="return confirm('logout from this website?');"
              style="text-decoration: none">Logout</a>
          </button>
        </div>
        <?php
      } else {
        ?>
        <div class="buttons-container">
          <p class="name">Login first!</p>
          <button type="button" class="btn btn-success mt-2">
            <a href="login.php" style="text-decoration: none">Login</a>
          </button>
        </div>
        <?php
      }
      ?>
    </div>

    <!-- Sign In Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="
        font-family: 'Open Sans', sans-serif;
        background-color: #ffffff;
        border: 4px solid #47371c;
        border-radius: 38px;
      ">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <!-- Sign-in form -->
            <form style="width: 100%; color: #a17d60">
              <div class="mb-3">
                <label for="email" class="form-label">EMAIL ADDRESS</label>
                <input type="text" class="form-control" id="email" name="email" style="
                border-radius: 15px;
                background-color: #a17d60;
                color: white;
              " required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">PASSWORD</label>
                <input type="password" class="form-control" id="password" name="password" style="
                border-radius: 15px;
                background-color: #a17d60;
                color: white;
              " required />
              </div>
              <button type="submit" class="btn btn-primary"
                style="border-radius: 15px; background-color: #a17d60; color: white">
                SIGN IN
              </button>
            </form>
            <div class="mt-4">
              <a href="#" class="text-black">Forgot Password?</a>
            </div>
            <!-- Sign Up -->
            <div class="mt-2 text-black">
              <p>
                Don't have an account?
                <a href="#" class="text-black" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</a>
              </p>
            </div>
            <div class="mt-3">
              <p class="text-black">Sign in with</p>
              <div class="d-flex justify-content-center">
                <a href="#" class="me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path
                      d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                  </svg>
                </a>
                <a href="#" class="me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-google" viewBox="0 0 16 16">
                    <path
                      d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                  </svg>
                </a>
                <a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path
                      d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sign Up Modal -->
    <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="
        font-family: 'Open Sans', sans-serif;
        background-color: #ffffff;
        border: 4px solid #47371c;
        border-radius: 38px;
      ">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center" style="font-family: 'Open Sans', sans-serif">
            <!-- Your sign-up form goes here -->
            <form style="width: 100%; color: #a17d60">
              <!-- Email address -->
              <div class="mb-3">
                <label for="signup-email" class="form-label">EMAIL ADDRESS</label>
                <input type="email" class="form-control" id="signup-email" name="signup-email" style="
                border-radius: 15px;
                background-color: #a17d60;
                color: white;
              " required />
              </div>
              <!-- Password -->
              <div class="mb-3">
                <label for="signup-password" class="form-label">PASSWORD</label>
                <input type="password" class="form-control" id="signup-password" name="signup-password" style="
                border-radius: 15px;
                background-color: #a17d60;
                color: white;
              " required />
              </div>
              <!-- Confirm Password -->
              <div class="mb-3">
                <label for="signup-cpassword" class="form-label">CONFIRM PASSWORD</label>
                <input type="password" class="form-control" id="signup-cpassword" name="signup-cpassword" style="
                border-radius: 15px;
                background-color: #a17d60;
                color: white;
              " required />
              </div>
              <!-- Sign up button -->
              <button type="submit" class="btn btn-primary btn-block"
                style="border-radius: 15px; background-color: #a17d60; color: white">
                SIGN UP
              </button>
            </form>
            <!-- Already have an account? Sign in link -->
            <div class="mt-4">
              <p style="font-family: 'Open Sans', sans-serif">
                Already have an account?
                <a href="#" class="text-black" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</a>
              </p>
            </div>
            <div class="mt-3">
              <p class="text-black">Sign up with</p>
              <div class="d-flex justify-content-center">
                <a href="#" class="me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path
                      d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                  </svg>
                </a>
                <a href="#" class="me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-google" viewBox="0 0 16 16">
                    <path
                      d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                  </svg>
                </a>
                <a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#986C4A"
                    style="font-size: 2em; width: 1em; height: 1em" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path
                      d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</header>
<footer class="mt-5 p-1">

  <div class="container upper">
    <div class="row">
      <div class="col-md-4 mt-5">
        <img src="../logo/logo.png" alt="Logo" class="img-fluid mb-3" />
      </div>

      <?php
      include '../components/connect.php';

      // Fetch admin details from the database
      $select_admin = $conn->prepare("SELECT * FROM `admin`");
      $select_admin->execute();
      $admin_details = $select_admin->fetch(PDO::FETCH_ASSOC);
      ?>

      <div class="col-md-4 p-5 text-center">
        <h5>CATEGORIES</h5>
        <ul class="list-unstyled">
          <li><a href="" style="color: #a17d60;">Crochet</a></li>
          <li><a href="" style="color: #a17d60;">Embroidery</a></li>
          <li><a href="" style="color: #a17d60;">Quilt</a></li>
          <li><a href="" style="color: #a17d60;">Rug Making</a></li>
        </ul>
      </div>

      <div class="col-md-4 p-5 text-center">
        <h5>CONTACT</h5>
        <p>Address:
          <?= $admin_details['address']; ?>
        </p>
        <p>Phone:
          <?= $admin_details['number']; ?>
        </p>
        <p>
          Email:
          <a href="mailto:<?= $admin_details['email']; ?>">
            <?= $admin_details['email']; ?>
          </a>
        </p>
      </div>
    </div>
  </div>

  <div class="bottom text-center">
    <p>&copy; Playful Stitches</p>
  </div>

</footer>
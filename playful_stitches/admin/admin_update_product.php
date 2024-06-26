<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}
;

if (isset($_POST['update'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, description = ?, category = ? WHERE id = ?");
   $update_product->execute([$name, $price, $description, $category, $pid]);

   $message[] = 'product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'images size is too large!';
      } else {
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/' . $old_image);
         $message[] = 'image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- Bootstrap CSS v5.2.1 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

   <link rel="stylesheet" href="../css/admin.css" />
   <link rel="stylesheet" href="../css/style.css" />

</head>

<body>

   <section class="update-product">

      <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $show_products->execute([$update_id]);
      if ($show_products->rowCount() > 0) {
         while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
               <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <h3 class="mt-4">Name</h3>
               <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box"
                  value="<?= $fetch_products['name']; ?>">
               <span>Price</span>
               <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price"
                  onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">

               <span>Description</span>
               <textarea required placeholder="enter product description" name="description"
                  class="box"><?= $fetch_products['description']; ?></textarea>

               <span>Category</span>
               <select name="category" class="box" required>
                  <option selected value="<?= $fetch_products['category']; ?>">
                     <?= $fetch_products['category']; ?>
                  </option>
                  <option value="crochet">Crochet</option>
                  <option value="embroidery">Embroidery</option>
                  <option value="quilt">Quilt</option>
                  <option value="rug making">Rug Making</option>
               </select>
               <span>Image</span>
               <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
               <div class="d-flex flex-column mb-2">
                  <input type="submit" value="Update" class="btn btn-warning w-100 mb-2" name="update">
                  <a href="category.php" class="btn btn-info w-100">Back</a>
               </div>
            </form>
            <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </section>

   <!-- custom js file link  -->
   <script src="../js/admin.js"></script>

</body>

</html>
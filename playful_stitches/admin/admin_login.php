<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = htmlspecialchars($username, ENT_QUOTES);
    $password = htmlspecialchars($password, ENT_QUOTES);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE username = ? AND password = ?");
    $select_admin->execute([$username, $password]);

    if ($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:admin_order.php');
    } else {
        $message[] = 'Incorrect username or password!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>

<body style="background-color: #CBB08D;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Montserrat', sans-serif;">

    <div class="login-container">

        <div class="login-title">Playful Stitches</div>

        <form action="" method="POST">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text">&#9993;</span>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                        autocomplete="username" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text">&#128273;</span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                        autocomplete="current-password" required>
                </div>
            </div>
            <button type="submit" name="submit" class="login-button btn">Login</button>

            <div class="mt-4">
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

    </div>

</body>

</html>
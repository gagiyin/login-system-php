<?php include "partials/header.php" ?>
<?php include "partials/navbar.php" ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($users->loginUser($email, $password)) {
        $redirect = $_SESSION['redirectToWhenLogged'];
        unset($_SESSION['redirectToWhenLogged']);
        redirect($redirect);
    }
}

?>

<div class="center">
    <form class="user" method="POST">
        <h1>Bejelentkezés</h1>
        <?php if (isset($_SESSION['notice'])): ?>
        <div class="notice">
            <h3><?php echo $_SESSION['notice'] ?></h3>
        </div>
        <?php endif; ?>
        <label for="email">E-mail cím:</label>
        <input type="email" name="email" placeholder="| ">
        <label for="password">Jelszó:</label>
        <input type="password" name="password" placeholder="| ">
        <div class="center" style="display: flex; flex-direction: column;">
            <input class="button default" type="submit" value="Bejelentkezés" style="width: 50%">
            <a href="register.php">Nincs még fiókod?</a>
        </div>
    </form>
</div>

<?php
include "partials/footer.php";
?>
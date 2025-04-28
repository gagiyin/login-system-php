<?php

// Redirect function (i usually put it in the header or into the init file if you have partials created)
function redirect($path) {
    header("Location: ". $path);
    exit();
}

// Processing the login
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

<div>
    <form method="POST">
        <h1>Bejelentkezés</h1>
        <?php if (isset($_SESSION['notice'])): ?>
        <div>
            <h3><?php echo $_SESSION['notice'] ?></h3>
        </div>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="| ">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="| ">
        <div class="center">
            <input type="submit" value="Bejelentkezés">
            <a href="register.php">Register</a>
        </div>
    </form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['submit']) {
        if (isset($_POST['aszf'])) {
            $email = $_POST['email'];
            $familyname = $_POST['family-name'];
            $firstname = $_POST['first-name'];
            $password = $_POST['password'];
            $passwordAgain = $_POST['password-again'];
            if($password!== $passwordAgain) {
                $_SESSION['notice'] = "The passwords are not the same!";
                return false;
            } else if ($users->registerUser($email, $familyname, $firstname, $password)) {
                $_SESSION['notice'] = "Successfully registrated!";
            } else {
                if (!isset($_SESSION['notice'])) {
                    $_SESSION['notice'] = "Error while registrating!";
                }
            }
        } else {
            $_SESSION['notice'] = "You have to accept the terms and conditions!";
            redirect("register.php");
        }
    }
    $_SESSION['first-name'] = $_POST['first-name'] ?? "";
    $_SESSION['family-name'] = $_POST['family-name']?? "";
    $_SESSION['email'] = $_POST['email']?? "";
}

?>

<div class="center">
    <form class="user" method="post">
        <h1>Registration</h1>
        <?php if (isset($_SESSION['notice'])): ?>
        <div class="notice">
            <h3><?php echo $_SESSION['notice'] ?></h3>
        </div>
        <?php endif; ?>
        <div class="give-name" style="display: flex;">
            <div>
                <label for="family-name">Lastname:</label>
                <input type="text" name="family-name" placeholder="| <?php echo $_SESSION['family-name'] ?? "" ?>">
            </div>
            <div>
                <label for="first-name">Firstname:</label>
                <input type="text" name="first-name" placeholder="| <?php echo $_SESSION['first-name'] ?? "" ?>">
            </div>
        </div>
        <label for="email">E-mail:</label>
        <input type="email" name="email" placeholder="| <?php echo $_SESSION['email'] ?? "" ?>">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="| ">
        <label for="password">Password:</label>
        <input type="password" name="password-again" placeholder="| ">
        <div style="display: grid; align-items: center; justify-content: center;">
            <label for="aszf">I read and accept the <a class="red" href="aszf">terms and conditions</a>.</label>
            <input type="checkbox" name="aszf" style="height: 1rem;">
        </div>
        <div class="center" style="display: flex; flex-direction: column;">
            <input class="button default" name="submit" type="submit" value="Regisztráció" style="width: 50%">
            <a href="login.php">Login</a>
        </div>
    </form>
</div>

<?php
unset($_SESSION['first-name'], $_SESSION['family-name'], $_SESSION['email']);
?>

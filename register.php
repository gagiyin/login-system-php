<?php include "partials/header.php" ?>
<?php include "partials/navbar.php" ?>

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
                $_SESSION['notice'] = "A két jelszó nem egyezik!";
                return false;
            } else if ($users->registerUser($email, $familyname, $firstname, $password)) {
                $_SESSION['notice'] = "Sikeres regisztráció!";
            } else {
                if (!isset($_SESSION['notice'])) {
                    $_SESSION['notice'] = "Sikertelen regisztráció!";
                }
            }
        } else {
            $_SESSION['notice'] = "Az ASZF elfogadása kötelező!";
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
        <h1>Regisztráció</h1>
        <?php if (isset($_SESSION['notice'])): ?>
        <div class="notice">
            <h3><?php echo $_SESSION['notice'] ?></h3>
        </div>
        <?php endif; ?>
        <div class="give-name" style="display: flex;">
            <div>
                <label for="family-name">Vezetéknév:</label>
                <input type="text" name="family-name" placeholder="| <?php echo $_SESSION['family-name'] ?? "" ?>">
            </div>
            <div>
                <label for="first-name">Keresztnév:</label>
                <input type="text" name="first-name" placeholder="| <?php echo $_SESSION['first-name'] ?? "" ?>">
            </div>
        </div>
        <label for="email">E-mail cím:</label>
        <input type="email" name="email" placeholder="| <?php echo $_SESSION['email'] ?? "" ?>">
        <label for="password">Jelszó:</label>
        <input type="password" name="password" placeholder="| ">
        <label for="password">Jelszó ismét:</label>
        <input type="password" name="password-again" placeholder="| ">
        <div style="display: grid; align-items: center; justify-content: center;">
            <label for="aszf">Elolvastam, és elfogadom az <a class="red" href="aszf">ÁSZF</a>-t.</label>
            <input type="checkbox" name="aszf" style="height: 1rem;">
        </div>
        <div class="center" style="display: flex; flex-direction: column;">
            <input class="button default" name="submit" type="submit" value="Regisztráció" style="width: 50%">
            <a href="login.php">Van már fiókod?</a>
        </div>
    </form>
</div>

<?php
include "partials/footer.php";
unset($_SESSION['first-name'], $_SESSION['family-name'], $_SESSION['email']);
?>
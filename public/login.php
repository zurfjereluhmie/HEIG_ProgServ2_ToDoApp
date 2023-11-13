<?php
session_start();

require_once "../app/autoload.php";

use ch\comem\todoapp\flash\Flash;

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));

if (isset($_POST["submit"])) require_once "../controllers/validate-login.php";

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead("Login", ["login"]);
?>


<body class="d-flex justify-content-center align-items-center">

    <form class="form-signin" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">

        <?= Flash::displayFlashMessage("global") ?>
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center loginCard">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" class="formInput" placeholder="Email address" required autofocus name="email" autocomplete="new-password">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="formInput" placeholder="Password" required name="password" autocomplete="new-password">
            <button class="btn-lgb btn-block" type="submit" name="submit">Sign in</button>
            <p>Don't have an account ? <a href="register.php">Register here</a></p>

            <p class="small"><a href="reset-password.php">Forgot password ?</a></p>
        </div>
    </form>

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>
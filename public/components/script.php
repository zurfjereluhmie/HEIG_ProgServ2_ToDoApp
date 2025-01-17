<?php

function loadScript(array $scripts = [], array $module = []): void
{
?>
    <!-- Lib -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Custom common-->
    <!-- <script src="js/navScript.js"></script>
    <script src="js/profilePicture.js"></script>
    <script src="js/searchBar.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/taskScript.js"></script> -->


    <!-- Custom specific-->
    <?php foreach ($scripts as $script) : ?>
        <script src="./scripts/<?= $script ?>.js"></script>
    <?php endforeach; ?>

    <!-- Module -->
    <?php foreach ($module as $script) : ?>
        <script src="./scripts/<?= $script ?>.js" type="module"></script>
    <?php endforeach; ?>
<?php
}

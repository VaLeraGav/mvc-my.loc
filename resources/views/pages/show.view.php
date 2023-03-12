<?php

use App\Application\Views\View;

?>

<?php View::component('header'); ?>

    <body>
        show
        <?= $name ?>
    </body>

<?php View::component('footer'); ?>
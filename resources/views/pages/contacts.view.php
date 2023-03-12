<?php

use App\Application\Views\View;

?>

<?php View::component('header'); ?>

    <body>
        <form action="../../../index.php" method="post" class="form-example">
            <div class="form-example">
                <label for="name">Enter your name: </label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-example">
                <input type="submit" value="Subscribe!">
            </div>
        </form>
    </body>

<?php View::component('footer'); ?>
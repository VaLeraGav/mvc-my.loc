<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <h4><?= $title ?? '' ?></h4>

        <?php if(!empty($arrayName)): ?>
            <p class="text-danger"><?php dpre($arrayName); ?></p>
        <?php endif; ?>
        <p><?php dpre($_SESSION); ?></p>

        <a href="/services?id=5">About</a>
    </div>
</div>
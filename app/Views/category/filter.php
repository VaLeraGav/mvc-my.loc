<?php if (!empty($products)): ?>
        <?php $curr = \Core\App::$app->getProperty('currency'); ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 product-left p-left">
                <div class="product-main simpleCart_shelfItem">
                    <a href="product/<?= $product->alias; ?>" class="mask"><img
                                class="img-responsive zoom-img" src="images/<?= $product->img; ?>"
                                alt=""/></a>
                    <div class="product-bottom">
                        <h3><a href="product/<?= $product->alias; ?>"><?= $product->title; ?></a></h3>
                        <p>Explore now</p>
                        <h4>
                            <a data-id="<?= $product->id; ?>" class="add-to-cart-link"
                               href="cart/add?id=<?= $product->id; ?>"><i></i></a>
                            <span class="item_price"><?= $curr['symbol_left']; ?><?= $product->price * $curr['value']; ?> <?= $curr['symbol_right']; ?></span>
                            <?php if ($product->old_price): ?>
                                <small>
                                    <del><?= $product->old_price * $curr['value']; ?></del>
                                </small>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="srch srch1">
                        <?php if($product->old_price): ?>
                            <div class="srch">
                                <span>-<?=100-round(($product->price)/($product->old_price), 2)*100;?>%</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>

        <div class="text-center">
            <?php if($pagination->countPages > 1): ?>
                <h5><?=$pagination;?></h5>
            <?php endif; ?>
        </div>
<?php else: ?>
    <h3>There are no products in this category...</h3>
<?php endif; ?>

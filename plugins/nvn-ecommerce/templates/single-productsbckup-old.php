<?php
require_once(PLUGIN_DIR . 'class.helper.php');

$allow_review = get_option('product_review');

// mettaboxio
$product_images_metaboxio = rwmb_get_value( 'images_Arr' );
$product_images_metaboxio_arr =  explode(',', $product_images_metaboxio);
$product_price_metaboxio = rwmb_get_value( 'product_price' );

$product_images = get_post_meta($post->ID, '_product_images', true);
$product_price = get_post_meta($post->ID, '_product_price', true);
$product_images_arr = explode(',', $product_images);
$product_price_rupiah = Helper::convert_number_to_rupiah($product_price);


get_header(); ?>
<header class="entry-header alignwide">
    <h1 class="entry-title"><?= the_title(); ?></h1>
</header>

<div class="entry-content">
    <?php
    foreach ($product_images_metaboxio_arr as $image) : if ($image) : ?>
            <img src="<?= $image ?>" alt="images">
    <?php endif;
    endforeach;
    ?>

    <p><?= the_content(); ?></p>


    <div class="add-to-cart">
        <input type="number" class="add-to-cart__value">
        <input type="hidden" class="add-to-cart__id" value="<?= $post->ID ?>">
        <input type="hidden" class="add-to-cart__title" value="<?= the_title() ?>">
        <input type="hidden" class="add-to-cart__price" value="<?= the_title() ?>">
        <button type="button" class="add-to-cart__button">add to cart</button>
    </div>

</div>


<?php
if ($allow_review)
    comments_template();
get_footer();

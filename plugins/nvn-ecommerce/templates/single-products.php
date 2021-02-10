<?php
require_once(PLUGIN_DIR . 'class.helper.php');

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
    foreach ($product_images_arr as $image) : ?>
        <img src="<?= $image ?>" alt="images">
    <?php endforeach;
    ?>
    <p><?= the_content(); ?></p>

</div>


<?php
comments_template();
get_footer();

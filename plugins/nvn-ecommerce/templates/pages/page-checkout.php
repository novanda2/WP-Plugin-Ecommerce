<?php
require_once(PLUGIN_DIR . 'class.helper.php');

get_header();

$products = explode(",", $_POST['nvn-products']);
$amounts = explode(",", $_POST['nvn-amounts']);

$total = 0;

$args = array(
  'post_type' => 'products',
  'post_status' => 'publish',
  'post__in' => $products
);
$posts = new WP_Query($args);


if ($posts->have_posts()) : ?>

  <div class="ecom-container">
    <div class="ecom-row">
      <div class="ecom-row__single-1/2">
        <h3>Checkout</h3>
        <ul class="p-0 mt-sm">
          <?php $i = 0;
          while ($posts->have_posts()) : $i++;
            $posts->the_post();

            $product_images_metaboxio = rwmb_get_value('images_Arr');
            $product_images_metaboxio_arr =  explode(',', $product_images_metaboxio);
            $product_price_metaboxio = rwmb_get_value('product_price');
            $product_price_metaboxio_rupiah = rwmb_get_value('product_price_show');

            $total = $total + ($product_price_metaboxio * $amounts[$i - 1]);
          ?>

            <li><?= the_title() ?> ( <?= $amounts[$i - 1] ?> ) </li>


          <?php endwhile; //end the while loop
          ?>
        </ul>
        <h5 class="mt-lg">Total : <?= Helper::convert_number_to_rupiah($total) ?></h5>
      </div>
    </div>
  </div>
<?php endif; // end of the loop. 
?>

<?php get_footer(); ?>
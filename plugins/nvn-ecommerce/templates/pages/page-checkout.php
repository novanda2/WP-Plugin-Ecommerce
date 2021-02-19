<?php

/**
 * first, query products in checkout
 * then add post to order and payment
 */


require_once(PLUGIN_DIR . 'class.helper.php');

class CheckoutSinglePage
{
  /**this checkout page var */
  public $products;
  public $amounts;
  public $total = 0;
  public $args;
  public $posts;

  /** post to order var */
  public $orders;


  public function __construct()
  {
    $this->products = explode(",", $_POST['nvn-products'] ?? '');
    $this->amounts  = explode(",", $_POST['nvn-amounts'] ?? '');
    $this->args =  array(
      'post_type' => 'products',
      'post_status' => 'publish',
      'post__in' => $this->products
    );
    $this->posts =  new WP_Query($this->args);
    $this->html();


    var_dump($_POST);
  }

  public function add_order_post()
  {
  }

  public function html()
  {

    get_header();


    if ($this->posts->have_posts()) : ?>

      <div class="ecom-container">
        <div class="ecom-row">
          <div class="ecom-row__single-1/2">
            <h3>Checkout</h3>
            <div id="checkout"></div>
            <ul class="p-0 mt-sm">
              <?php $i = 0;
              while ($this->posts->have_posts()) : $i++;
                $this->posts->the_post();

                $product_images_metaboxio = rwmb_get_value('images_Arr');
                $product_images_metaboxio_arr =  explode(',', $product_images_metaboxio);
                $product_price_metaboxio = rwmb_get_value('product_price');
                $product_price_metaboxio_rupiah = rwmb_get_value('product_price_show');

                $this->total = $this->total + ($product_price_metaboxio * $this->amounts[$i - 1]);
              ?>

                <li><?= the_title() ?> ( <?= $this->amounts[$i - 1] ?> ) </li>


              <?php endwhile; //end the while loop
              ?>
            </ul>
            <h5 class="mt-lg">Total : <?= Helper::convert_number_to_rupiah($this->total) ?></h5>

            <div class="mt-sm">
              <form action=""></form>
              <button>Process To Payments</button>
            </div>
          </div>
        </div>
      </div>
    <?php
    endif; // end of the loop. 
    get_footer();
    ?>

<?php
  }
}


new CheckoutSinglePage;

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
  public $product_title_list;

  /** post to order, var */
  public $orders;

  /** current user information */
  public $current_user;
  public $personal_info;

  /** form */
  public $products_form;
  public $amounts_form;

  public function __construct()
  {
    $this->current_user = wp_get_current_user();
    $this->personal_info = [
      'id' => $this->current_user->ID,
      'fullname' => $this->current_user->display_name,
      'email' => $this->current_user->user_email,
      'phone' => get_the_author_meta('phone', $this->current_user->ID),
      'address' => get_the_author_meta('address', $this->current_user->ID),
      'city' => get_the_author_meta('city', $this->current_user->ID),
      'postalcode' => get_the_author_meta('postalcode', $this->current_user->ID),
    ];

    $this->products = explode(",", $_POST['nvn-products'] ?? '');
    $this->amounts  = explode(",", $_POST['nvn-amounts'] ?? '');
    $this->total = $_POST['nvn-total'] ?? '';

    $this->args =  array(
      'post_type' => 'products',
      'post_status' => 'publish',
      'post__in' => $this->products
    );

    for ($i = 0; $i < count($this->products); $i++) $this->products_form[$i] = $this->products[$i];
    for ($i = 0; $i < count($this->amounts); $i++) $this->amounts_form[$i] = $this->amounts[$i];
    $this->products_form = json_encode($this->products_form);
    $this->amounts_form = json_encode($this->amounts_form);

    $this->posts = new WP_Query($this->args);

    $i = 0;
    while ($this->posts->have_posts()) : $i++;
      $this->posts->the_post();
      $this->product_title_list[$i] = get_the_title();
    endwhile;

    $this->handle_checkout();
    $this->html();
  }

  public function handle_checkout()
  {
    $guid = wp_generate_uuid4();

    $order_args = [
      'guid' => $guid,
      'post_title' => $guid,
      'post_type' => 'orders',
      'post_status'  => 'publish',
      'post_author'  => get_current_user_id(),
      'meta_input' => [
        'order_id' => $guid,
        'order_products_id' => $this->products_form,
        'order_products_amount' => $this->amounts_form,
        'order_name' => $this->personal_info['fullname'],
        'order_email' =>  $this->personal_info['email'],
        'order_phone' =>  $this->personal_info['phone'],
        'order_address' =>  $this->personal_info['address'],
        'order_city' =>  $this->personal_info['city'],
        'order_postalcode' =>  $this->personal_info['postalcode'],
        'order_payment_id' =>  $guid,
        'order_payment_amount' => $_POST['total'] ?? '',
        'order_product_type' => '',
        'order_payment_status' => 'pending'
      ]
    ];

    if (isset($_POST['action'])) {
      $order_post = wp_insert_post($order_args);
      if (is_wp_error($order_post))
        $order_post->get_error_message();
      else {
        wp_redirect(home_url() . '/orders/' . $guid);
        exit();
      }
    }
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
              ?>

                <li><?= the_title() ?> ( <?= $this->amounts[$i - 1] ?> ) </li>


              <?php endwhile; //end the while loop
              ?>
            </ul>
            <h5 class="mt-lg">Total : <?= Helper::convert_number_to_rupiah($this->total) ?></h5>

            <div class="mt-sm">
              <form action="checkout" method="POST">
                <input type="hidden" name="action" value="submit-order">
                <input type="hidden" name="total" value="<?= Helper::convert_number_to_rupiah($this->total) ?>">
                <button>Process To Payments</button>
              </form>
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

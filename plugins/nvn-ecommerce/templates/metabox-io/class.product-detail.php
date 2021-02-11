<?php

/**
 * 
 * the idea to upload images is
 * run uploader js
 * if user select, add to array
 * 
 * array foreach to show images what user select
 * 
 * save value to some hidden input
 *
 * 
 */
class ProductMetaboxHTML
{
  public static function html($post)
  {
    // $product_images = get_post_meta($post->ID, '_product_images', true);
    // $product_price = get_post_meta($post->ID, '_product_price', true);
?>

    <div class="nvn-metabox">
      <div class="nvn-metabox__product-image">
        <h4 class="">Product Images <small>(multiple)</small></h4>
        <input type="hidden" class="nvn-uploader__input-images" name="product_images" value="<?php #echo $product_images; ?>">
        <div id="nvn-uploader__preview-image__parent" class="nvn-uploader__preview-image__parent"></div>
        <input id="upload_image_button" class="nvn-uploader__upload-button" type="button" value="+" /><br />
      </div>
      <!-- <div class="nvn-metabox__product-price">
        <h4 class="nvn-metabox__title">Product Price</h4>
        <input type="hidden" class="nvn-metabox__product-price__input-value" value="<?php #echo $product_price; ?>" name="product_price">
        <input type="text" class="nvn-metabox__product-price__input" placeholder="Product Price">
      </div> -->
    </div>

<?php
  }
}

<?php
$data = json_decode(file_get_contents("php://input"), true);

function update_post()
{
    if (isset($data)) {
        $order_post = wp_update_post(array(
            'ID' => '10133',
            'post_type' => 'orders',
            'post_status'  => 'publish',
            'meta_input'  => array(
                'order_payment_status' => 'paid'
            )
        ));

        if (is_wp_error($order_post))
            $order_post->get->get_error_message();
    }
}

update_post();

if (isset($data))
    echo $order_post;
// echo json_encode(array('message' => $order_post ?? 'success'));
<?php
//Hook into order completion event
add_action('woocommerce_order_status_completed', 'trigger_code_on_order_completion');

function trigger_code_on_order_completion($order_id) {
// Get the order object
    $order = wc_get_order($order_id);

// Get ordered items
    $items = $order->get_items();

    foreach ($items as $item) {
        $product_id = $item->get_product_id();
        $product = wc_get_product($product_id);
        $api_value = $product->get_attribute('laposta_api_id');
        if ($api_value) {
// If the custom field 'api_url' is set for this product, proceed
// Data to send
            $data = array(
                'list_id' => $api_value,
                'ip' => 'SOURCE_IP',
                'email' => $order->get_billing_email(),
                'source_url' => 'SOURCE_URL',
            );

            $data_string = http_build_query($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://api.laposta.nl/v2/member");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode("API_KEY" . ':')
            ));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                error_log('Error: ' . curl_error($ch));
            }
            curl_close($ch);
            error_log($response);
        }
    }
}

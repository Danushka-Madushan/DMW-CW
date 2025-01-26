<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function addToCart($product_id, $amount) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['amount'] += $amount; // Update amount if item exists
            return;
        }
    }
    $_SESSION['cart'][] = ['product_id' => $product_id, 'amount' => $amount];
}

function removeFromCart($product_id) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
        return $item['product_id'] != $product_id;
    });
}
?>

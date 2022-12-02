<?php
/*
 * Template Name: Корзина
 */
use Controllers\WC\WCController;
$cart = WCController::get_cart();

get_header();
renderBlock('pages/basket',
    [
        'notification'  => get_field('notification')['switch']?
                        get_field('notification')['content']:
                        null,
        'title'         => get_field('title')['switch']?
                            get_field('title')['content']:
                            null,
        'products'      => $cart['basket'],
        'total_price'   => $cart['price'],
        'total_quantity'=> $cart['quantity'],
        'shop_link'     => get_permalink( wc_get_page_id( 'shop' ) )
    ]);
get_footer();
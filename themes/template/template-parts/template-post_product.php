<?php

global $post;
$product = \Controllers\PostsAndTax\PostProduct::init($post->ID);

get_header();

renderBlock('pages/product',
    [
        'id'=>$product->get_id(),
        'title'=>$product->get_title(),
        'gallery'=>$product->get_gallery(),
        'article'=>$product->get_article(),
        'price'=>$product->get_price(),
        'currency'=>$product->get_currency(),
        'image'=>$product->get_image(),
        'attributes'=>$product->get_attributes(),

        'upsell'=>false === get_field('related',ACF_PAGE_SLUG_COMMON)['switch']?null:
            [
                'items'=>$product->get_upsell(),
                'title'=>get_field('related',ACF_PAGE_SLUG_COMMON)['title']
            ],
        'cross_sail'=>false === get_field('simillar',ACF_PAGE_SLUG_COMMON)['switch']?null:
            [
                'items'=>$product->get_cross_sell(),
                'title'=>get_field('simillar',ACF_PAGE_SLUG_COMMON)['title']
            ],
        //        'compatibility'=>$product->get_compatibility(),
//        'count_stock'=>$product->get_count_stock(),
//        'characteristics'=>$product->get_characteristics(),
//        'delivery_description'=>get_field('shop','options')['delivery_description'],
//        'warranty'=>$product->get_warranty(),
//        'return'=>$product->get_returns(),
        'description'=>$product->get_description(),

//        'drawing'=>$product->get_drawing()
        'pickup'=>get_field('pickup',ACF_PAGE_SLUG_COMMON),
        'courier'=>get_field('courier',ACF_PAGE_SLUG_COMMON),
    ],null);

get_footer();
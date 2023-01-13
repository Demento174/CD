<?php
//dd(\Controllers\FrontMenu\FrontMenu::header());
$header = get_field('header',ACF_PAGE_SLUG_OPTIONS);
$shop = get_field('shop',ACF_PAGE_SLUG_OPTIONS);
$cities = \Controllers\GEO\Cities::init(get_domain());

renderBlock('base/header',
    [
        'logo'      => $header['logo'],
        'logo_link' => true === is_front_page()?'#':'/',
        'slogan'    => $header['slogan'],
        'phone'     => $cities->get_current_contacts()['phone'],
        'email'     => $cities->get_current_contacts()['email'],
        'address'   => $cities->get_current_contacts()['address'],
        'menu'      => \Controllers\FrontMenu\FrontMenu::header(),
        'basket'    => $shop['basket'],
        'search'    => $shop['search'],
        'cart_url'=>wc_get_cart_url(),
        'cart_count_items'=>\Controllers\WC\WCController::get_countItemInTheBasket(),
        'cities'=>$cities->get_sort_cities(),
        'current_city'=>$cities->get_current_city()['title'],
        'get_parameter_search'=>GET_PARAMETERS['search'],
        'get_search_value'=>$_GET[GET_PARAMETERS['search']],
        'classes'=>is_cart()?'cart color':'',
    ],null);
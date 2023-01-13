<?php
use Controllers\Blocks\Blocks\Breadcrumbs;
use Controllers\Blocks\Blocks\SearchField;

return
    [
        'dirname'=>'Views',
        'functions'=>
            [
                'get_field'=>'get_field',
                'wp_head'=>'wp_head',
                'wp_footer'=>'wp_footer',
                'get_permalink'=>'get_permalink',
                'GET'=>fn()=>GET_PARAMETERS,
                'social_networks'=>function(){ return \Controllers\Blocks\BlocksControllers\Details\SocialNetworks::get_data(); },
                'form_modal'=>function(){  return \Controllers\Blocks\BlocksControllers\Forms\FormModalBlock::get_data(); },
                'menu_header'=>function(){wp_nav_menu( ['menu'  => 'header','container'=>false,'menu_class'=>'navigation flex_row justify_around align_center']);} ,
                'public_dir'=>function(){return get_template_directory_uri().'/public/';},
                'current_url'=>function(){return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";},
                'item_in_the_cart'=>function(){return \Controllers\WC\WCController::item_in_the_cart();},
                'form_settings'=>function(){return get_field('forms','options');},
                'generate_hash'=>fn($str)=>hash('ripemd160', $str),

                'pagination_render'=>function()
                {
                    $pagination = \Controllers\Pagination::init();
                    $pagination->render();
                },
                'block_breadcrumbs'=>function()
                {
                    $breadcrumbs = new Breadcrumbs(get_queried_object());
                    $breadcrumbs->render();
                },
                'block_search_form'=>function()
                {
                    $search_form = new SearchField();
                    $search_form->render();
                },
            ],

    ];
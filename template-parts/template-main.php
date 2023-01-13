<?php
/*
Template Name: Главная
*/

//$terms = \Controllers\PostsAndTax\TaxCat::get_termFirstLevel();
//$welcome = get_field('welcome',ACF_PAGE_SLUG_COMMON);
$benefits = get_field('benefits',ACF_PAGE_SLUG_COMMON);

get_header();

renderBlock('intro_slider',
    get_field('intro_slider'));

renderBlock('content/block_content',
    get_field('block_content'));

if($benefits['switch'])
    renderBlock('Grids/benefits',
        [
            'title'=>$benefits['title'],
            'items'=>$benefits['items']
        ]);

get_footer();
<?php
/*
Template Name: Каталог
*/

//$products = \Controllers\PostsAndTax\PostProduct::get_include_posts(
//    [
//        70860,70857,70858,70860,70862,70859,70861,70852,
//    ]);
$products = [];
$title = '';

if(is_shop())
{
    $products = \Controllers\PostsAndTax\PostProduct::get_all_posts();
    $title =  get_the_title(SHOP_PAGE_ID);

}elseif (is_tax('product_cat'))
    {
        $title = get_queried_object()->name;
        $products = \Controllers\PostsAndTax\PostProduct::get_taxonomy_posts(get_queried_object()->term_taxonomy_id);

    }elseif (isset($_GET[GET_PARAMETERS['search']]) and !empty($_GET[GET_PARAMETERS['search']]))
        {
            $title = 'Поиск: '.$_GET[GET_PARAMETERS['search']];
            $products = \Controllers\PostsAndTax\PostProduct::get_by_search($_GET[GET_PARAMETERS['search']]);
        }

if(\Controllers\Pagination::get_current_page() > 1)
    $title.=' Страница №'.\Controllers\Pagination::get_current_page();



get_header();


renderBlock('pages/catalog',
    [
        'items'=>$products,
        'title'=>$title
    ],null,false);


get_footer();

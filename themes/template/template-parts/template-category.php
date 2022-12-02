<?php
/*
 * Template-Name: Категории, подкатегории
 */

use Controllers\PostsAndTax\TaxCat;
use Controllers\WC\WCController;


$currentTax= new TaxCat(get_queried_object()->term_taxonomy_id);

$children = $currentTax->get_children();

$title = $currentTax->title;

$other_cats =!$currentTax->is_second_level()?false:$currentTax->get_other_cats();

get_header();

renderBlock('pages/categories',
    [
        'second_level_category'=>TaxCat::get_termSecondLevel(),
        'manufacturers'=>WCController::get_all_values_attribute('manufacturer'),
        'refer'=>wp_get_referer(),
        'children'=>$children,
        'title'=>$title,
        'other_cats'=>$other_cats
    ],null);
get_footer();

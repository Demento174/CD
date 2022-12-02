<?php
/*
 * Template Name: О нас
 */


get_header();

renderBlock('pages/about',
    [
        'seo',
        'brands'=>['title'=>get_field('brands')['title'],'items'=>get_field('brands','options')],
        'middle',
        'bottom',

    ],null);

get_footer();
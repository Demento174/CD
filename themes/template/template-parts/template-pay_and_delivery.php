<?php
/*
 * Template Name: Оплата и доставка
 */

get_header();

renderBlock('pages/delivery',
    [
        'title'=>get_field('title'),
        'items'=>get_field('pay_and_cash')
    ],null);

get_footer();
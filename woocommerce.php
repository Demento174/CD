<?php


if(get_queried_object() && get_queried_object()->taxonomy=='product_cat')
{

    get_template_part('template-parts/template-category');
}
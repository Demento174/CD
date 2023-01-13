<?php
$footer = get_field('footer',ACF_PAGE_SLUG_OPTIONS);
$forms = get_field('forms',ACF_PAGE_SLUG_COMMON);


renderBlock('base/footer',
    [

        'menu'=>\Controllers\FrontMenu\FrontMenu::footer(),
        'image'=>$footer['image'],
        'forms'=>$forms
    ],null
);
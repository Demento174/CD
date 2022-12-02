<?php

if(is_shop() or is_tax('product_cat'))
    get_template_part('template-parts/template-catalog');
else
    get_template_part('template-parts/template-content');

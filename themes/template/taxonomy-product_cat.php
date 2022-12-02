<?php


$term = new \Controllers\PostsAndTax\TaxCat(get_queried_object()->term_id);
$terms = \Controllers\PostsAndTax\TaxCat::get_termFirstLevel();

$filters =
    [
            'price'=>
                [
                        'from'=>$_GET[GET_PARAMETERS['filters']['price']['from']],
                        'to'=>$_GET[GET_PARAMETERS['filters']['price']['to']]
                ],
            'sorting'=>
                [
                        'price'=>$_GET[GET_PARAMETERS['sorting']['price']],
                        'title'=>$_GET[GET_PARAMETERS['sorting']['title']],
                ]
    ];


$_products = \Controllers\PostsAndTax\PostProduct::get_taxonomy_posts(get_queried_object()->term_id,$filters);

$items = null === $term->get_children()?$_products:$term->get_children();


get_header();
?>
    <div class="container">
        <div class="inner">
            <?php
            renderBlock('base/sidebar',
                [

                    'term_id'=>$term->get_id(),
                    'products'=>$items,
                    'title'=>'Каталог',
                    'links'=>$terms
                ],null);

            if(null === $term->get_children())
            {

                renderBlock('Grids/products',
                    [
                        'items'=>$_products,
                        'breadcrumbs' => \Controllers\BreadcrumbsYoast::DATA(),
                        'filters'=>$filters
                    ]);

            }else
                {

                    $items = $term->get_children();
                    renderBlock('Grids/items',
                        [
                            'items'=>$items,

                        ]);



                }


            ?>


        </div>
    </div>
<?php
get_footer();
<?php


/**
 * Template functions and definitions
 *
 * @link https:developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Template
 * @since 1.0
 */


const ADMINITSTRATOR = 1;
const GET_PARAMETERS =
[
    'filters'=>
        [
            'price'=>
                [
                    'from'=>'filter_price_from',
                    'to'=>'filter_price_to'
                ]
        ],
    'sorting'=>
        [
            'price'=>'sort_price',
            'title'=>'sort_title',
        ],
    'search'=>'s'
];
const SHOP_PAGE_ID =7;



/**
 * Вся магия тут
 */
require_once (get_template_directory().'/controllers.php');

/**
 * Функции
 */
function logs($txt,$directory=null,$settings=null)
{
    \Controllers\LogsClass\Logs::write($txt,$directory,$settings);
}

function renderBlock($block,$options=[],bool $id=null,$debug=false)
{

    $class = new \Controllers\Blocks\BlockController($block,$options,$id,$debug);

    return $class->render();
}

function renderAcfBlock($block,$options=[],bool $id=false,$debug=false)
{
    $options = 'array'!==gettype($options)?[$options]:$options;
    $class = new \Controllers\Blocks\BlockController($block,$options,$id,$debug);

    return $class->render();
}

function _get_product($id=null)
{
    return new Controllers\PostsAndTax\PostProduct($id);
}

function get_domain():string
{
    return $_SERVER['SERVER_NAME'];
}
function get_full_domain():string
{
    return $_SERVER['REQUEST_SCHEME'].'://'.get_domain().$_SERVER['REQUEST_URI'];
}

function _is_shop()
{
    global $wp;
    $current_url = '/'=== substr(get_full_domain(), -1)?
                    substr(get_full_domain(),0,-1):
                    get_full_domain();

    $shop_url = '/'=== substr(get_page_link(SHOP_PAGE_ID),-1)?
        substr(get_page_link(SHOP_PAGE_ID),0,-1):
        get_page_link(SHOP_PAGE_ID);

    return $current_url === $shop_url;
}
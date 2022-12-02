<?php
namespace Controllers\Blocks\Blocks;

use Controllers\PostsAndTax\PostProduct;
use \Controllers\PostsAndTax\TaxCat;

class Breadcrumbs
{
    static $template = 'breadcrumbs';

    private $taxonomy= false;
    private $page= false;
    private $product= false;

    private $breadcrubs = [];

    public function __construct($query_object)
    {
        $this->set_taxonomy($query_object);
        $this->set_product($query_object);
        $this->set_page($query_object);

        $this->set_breadcrumbs();
    }

    private function set_taxonomy($object)
    {
        if(isset($object->taxonomy) && $object->taxonomy == 'product_cat')
        {
            $this->taxonomy = new TaxCat($object->term_id);
        }
    }

    private function set_page($object)
    {

        if($object instanceof \WP_Post)
        {
            $this->page = $object;
        }else
            {
                $this->page =  false;
            }

    }

    private function set_product($object)
    {
        if($object->post_type == 'product')
        {
            $this->product = new PostProduct($object->ID);
        }else
            {
                $this->product = false;
            }

    }


    private function set_breadcrumbs_taxonomy()
    {
        if($this->taxonomy->is_first_level())
        {

            $this->breadcrubs[]=
                [
                    'title'=>$this->taxonomy->title,
                    'link'=>$this->taxonomy->link,
                ];
        }else if($this->taxonomy->is_second_level())
            {
                $this->breadcrubs[]=
                    [
                        'title'=>$this->taxonomy->parent->title,
                        'link'=>$this->taxonomy->parent->link,
                    ];
                $this->breadcrubs[]=
                    [
                        'title'=>$this->taxonomy->title,
                        'link'=>$this->taxonomy->link,
                    ];
            }
    }

    private function set_breadcrumbs_product()
    {

        $this->breadcrubs[] =
            [
                'title'=>get_the_title(wc_get_page_id('shop')),
                'link'=>get_permalink(wc_get_page_id('shop'))
            ];
        foreach ($this->product->get_taxonomy() as $item)
        {

            $this->breadcrubs[] =
                [
                    'title'=>$item['term']->title,
                    'link'=>$item['term']->link
                ];
        }
        $this->breadcrubs[] =
            [
                'title'=>$this->product->title,

            ];
    }

    private function set_breadcrumbs_page()
    {

        if($this->page->ID == wc_get_page_id('shop'))
        {
            $this->breadcrubs[] =
                [
                    'title'=>$this->page->post_title,
                    'link'=>get_permalink($this->page->ID)
                ];

            if($_GET['cat'] && $tax = get_term_by('slug',$_GET['cat'],'product_cat'))
            {
                
                $this->breadcrubs[] =
                    [
                        'title'=>$tax->name,
//                    'link'=>get_permalink($this->page->ID)
                ];
            }

        }
    }

    private function set_breadcrumbs()
    {


        $this->breadcrubs[]=
            [
                'title'=>get_the_title(get_option('page_on_front')),
                'link'=>get_page_link(get_option('page_on_front'))
            ];

        if($this->taxonomy)
        {
            $this->set_breadcrumbs_taxonomy();
        }elseif ($this->product)
            {
                $this->set_breadcrumbs_product();
            }elseif ($this->page)
                {
                    $this->set_breadcrumbs_page();
                }
    }

    public function render()
    {
        renderBlock(self::$template,
            [
                'breadcrumbs'=>$this->breadcrubs
            ]);
    }

}
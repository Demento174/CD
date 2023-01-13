<?php
namespace Controllers\PostsAndTax;

use Controllers\Pagination;

class PostAbstract{
    static private $required_variables = [ 'postType' ];


    protected           string $type;
    protected           int $id;
    protected           string|null $title      = null;
    protected           string|null $link       = null;
    protected            array|null $image      = null;
    protected            array|null $taxonomies   = null;

    protected            array|null $acf        = null;

    protected function __construct(string $type,$id=null)
    {

        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");

        $this->type = $type;
        $this->id = self::query_id($id);
        $this->title = $this->set_title($this->id);
        $this->link = $this->set_link($this->id);
    }

    private static function check_static_variables($called_class):bool
    {
        foreach (self::$required_variables as $variable)
        {
            if(!property_exists($called_class,$variable)) return false;
        }
        return true;
    }

    public static function query_id($id=null):?int
    {
        $result = $id;

        if(null === $id)
        {
            global $post;
            $result = (int) $post->ID;
        }

        return (int) $result;
    }

    protected function set_acf($id,$acf=null):?array
    {

        if(null === $acf || [] === $acf )return[];
        return \Controllers\ACF\GetACF::getACF($acf,$id);
    }


    protected function set_title($id):?string
    {
        return get_the_title($id);
    }

    protected function set_link($id):?string
    {
        return get_permalink($id);
    }

    protected function set_image($id):?array
    {

        return !get_the_post_thumbnail_url($id)?null:['url'=>get_the_post_thumbnail_url($id,'full'),'alt'=>$this->title];
    }

    protected function set_taxonomy($taxonomy,string $className):?array
    {

        if(!get_the_terms( $this->id, $taxonomy ))return null;

        $result = [];

        foreach (get_the_terms( $this->id, $taxonomy ) as $item)
        {
            $result[] = new $className($item->term_id);
        }

        return $result;
    }

    public static function convert_post($input,$className)
    {

        if(gettype($input) === 'array')
        {
            $result = [];
            foreach ($input as $item)
            {
                if('integer'===gettype($item))
                {
                    $result[] = new $className($item);
                    continue;
                }
                $result[] = property_exists($item,'ID')?new $className($item->ID):new $className($item->id);
            }
        }else
            {
                $result = property_exists($input,'ID')?new $className($input->ID):new $className($input->id);;
            }
        return $result;
    }

    public static function get_all_posts()
    {

        $args =
            [
                'post_type' => get_called_class()::$postType,
                'posts_per_page' => get_option('posts_per_page'),
                'paged'         => Pagination::get_current_page(),
            ];
        global $wp_query;
        query_posts( $args );
        $result = [];
        while ( $wp_query->have_posts() )
        {
            $wp_query->the_post();
            $result[]= $wp_query->post->ID;

        }
        return self::convert_post($result,get_called_class());
    }

    public static function get_include_posts($include)
    {
        return self::convert_post(
            get_posts(
                [
                    'post_type'=>get_called_class()::$postType,
                    'include'=>$include,'numberposts'=>-1
                ]),
            get_called_class()
        );


    }

    public static function get_taxonomy_posts($tax_id,array $filters=null):?Array
    {

        $input =  get_posts(
            [
                'post_type' => get_called_class()::$postType,
                'posts_per_page' => get_option('posts_per_page'),
                'paged'         => Pagination::get_current_page(),
                'tax_query' =>
                    [
                        [
                            'taxonomy' => get_called_class()::$taxClass::$taxType,
                            'field' => 'id',
                            'terms' => $tax_id
                        ]
                    ]
            ]
        );
        if (null===$filters)
            return self::convert_post($input,get_called_class());
        $result = [];
        foreach ($input as $_product)
        {
            $product = wc_get_product( $_product->ID );

            if(
                key_exists('from',$filters)
                and $filters['from'] !== '0'
                and  $product->get_price()>=$filters['from']
            ) $result[]=$product;

            if(
                key_exists('to',$filters)
                and
                $filters['to'] !== '0'
                and
                $product->get_price()<=$filters['to']
            ) $result[]=$product;
        }

        return self::convert_post($result,get_called_class());
    }

    public static function get_by_search(string $text):?array
    {
        global $wp_query;
        $input = [];
        query_posts(
            [
                'post_type'=>get_called_class()::$postType,
                'posts_per_page' => get_option('posts_per_page'),
                'paged'         => Pagination::get_current_page(),
                's'=>$text,
            ]);
        while ( $wp_query->have_posts() )
        {
            $wp_query->the_post();
            $input[]= $wp_query->post;

        }

        return self::convert_post($input,
            get_called_class());

    }
}
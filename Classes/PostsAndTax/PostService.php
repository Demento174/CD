<?php
namespace Controllers\PostsAndTax;

use Controllers\PostsAndTax\Interfaces\Content;
use Controllers\PostsAndTax\Interfaces\Images;
use Controllers\PostsAndTax\Interfaces\Price;


class PostService extends PostAbstract implements Content,Price,Images {

    static $postType = 'service';
    static $taxClass = '\Controllers\PostsAndTax\TaxService';
    static $fields =
        [];
    private \Controllers\PostsAndTax\TaxService|null $mainCategory = null;
    private                              string|null $short_description = null;
    private                                 int|null $price = null;
    public function __construct($id=null)
    {
        parent::__construct(self::$postType,$id);

        $this->mainCategory = $this->set_main_category($this->id,self::$taxClass::$taxType);

        $this->short_description = $this->set_short_description($this->id);
        $this->image = $this->set_image($this->id);
        $this->price = get_field('price',$this->id)['value'];
    }

    private function set_short_description($id)
    {
        return get_field('short_description',$id);
    }



    private function set_main_category($id,$taxonomy):?TaxService
    {
        $primary_cat_id=get_post_meta($id,'_yoast_wpseo_primary_' . $taxonomy, true);


        if(!$primary_cat_id)
            return null;

        $primary_cat = get_term($primary_cat_id, $taxonomy);

        return new self::$taxClass($primary_cat->term_id);
    }

    public function get_title():?string
    {
        return $this->title;
    }

    public function get_content():?string
    {
        return null;
    }

    public function get_description():?string
    {
        return $this->short_description;
    }

    public function get_currency(): ?string
    {
        // TODO: Implement get_currency() method.
        return null;
    }

    function get_price():?string
    {
        return (string) $this->price;
    }

    function get_regular_price():?int
    {
        return null;
    }

    function get_sale_price():?int
    {
        return null;
    }

    function check_sale():bool
    {
        return false;
    }

    public function get_link():?string
    {
        return $this->link;
    }

    public function get_main_taxonomy_title():?string
    {
        return null===$this->mainCategory? null: $this->mainCategory->get_title();
    }
    public function get_image():?array
    {
        return $this->image;
    }

    public function get_gallery(): ?array
    {
        // TODO: Implement get_gallery() method.
        return null;
    }





}
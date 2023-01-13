<?php
namespace Controllers\PostsAndTax;
use \Controllers\ACF\GetACF as GetACF;


abstract class TaxonomyAbstract{

    static private $required_variables = [ 'taxType','postClass' ];

    protected $type;
    protected $term;
    protected $id;
    public           string|null $title         = null;
    public           string|null $slug          = null;
    public           string|null $description   = null;
    public           string|null $link          = null;
    public TaxonomyAbstract|null $parent        = null;
    public TaxonomyAbstract|null $children      = null;

    public function __construct($id)
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");

        $this->type = get_called_class()::$taxType;

        if(!$this->term = $this->set_term($id,$this->type))
            throw new \Exception("term for ID ".$id." from class name ".get_called_class()." does not exist");


        $this->id  = $this->set_id($this->term);

        $this->title = $this->set_title($this->term);

        $this->slug = $this->set_slug($this->term);

//        $this->description = $this->set_description($this->term);

        $this->link =$this->set_link($this->id,$this->type);



    }

    private static function check_static_variables($called_class):bool
    {
        foreach (self::$required_variables as $variable)
            if(!property_exists($called_class,$variable))
                return false;

        return true;
    }

    /**
     * -------------------------[ SETTERS ]-------------------------
     */

    protected  function set_term($id,$type):\WP_Term|\WP_Error|bool
    {
        return  get_term_by( 'id', $id, $type);
    }

    private function set_id($term):int|null
    {
        return $term->term_id;
    }

    protected function set_title($term):?string
    {
        return $term->name;
    }

    protected  function set_slug($term):?string
    {
        return $term->slug;
    }

    protected  function set_description($term):?string
    {
        return $term->description;
    }

    protected function set_link($id,$type):?string
    {

        return get_term_link((int)$id, $type );
    }

    protected function set_parent():?TaxonomyAbstract
    {
        $className = get_called_class();
        return []===get_ancestors( $this->id, $this->type, 'taxonomy' )?
                            null:
                            new $className(get_ancestors( $this->id, $this->type, 'taxonomy' )[0]);

    }

    protected function set_children():?array
    {
        $result = [];
        $className = get_called_class();
        foreach (get_terms( $this->type,['hide_empty' => true,'parent'=>$this->id]) as $item)
        {
            $result[] = new $className($item->term_id);
        }
        return []===$result?null:$result;
    }

    /**
     * -------------------------[ OTHER METHODS ]-------------------------
     */

    protected static function get_termParent()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");

        $type=get_called_class()::$taxType;

        $className=get_called_class();

        $result = [];

        foreach (get_terms( $type,['hide_empty' => true,'parent'=>0]) as $item)
        {
            $result[] = new $className($item->term_id);
        }

        return $result;
    }

    public function is_first_level():bool
    {
        return !$this->parent?true:false;
    }

    public function is_second_level():bool
    {
        if(!$this->parent)
            return false;

        if($this->parent->is_first_level())
            return true;

        return false;
    }

    public function is_third_level():bool
    {
        if(!$this->parent)
            return false;

        if($this->parent->is_second_level())
            return true;

        return false;
    }

    private function get_main_level():?TaxonomyAbstract
    {
        if($this->is_first_level())
        {
            return null;
        }elseif($this->is_second_level())
        {
            return $this->parent;
        }

        return $this->parent->parent;

    }

    public function get_other_cats():?array
    {

        if(!$this->get_main_level())
            return null;

        $result= [];
        $called_class = get_called_class();
        $parents = get_terms( $this->type,['hide_empty' => true,'parent'=>0]);


        foreach ($parents as $parent)
        {
            if($parent->term_id == $this->get_main_level()->get_id())
            {
                foreach (get_terms($this->type,['hide_empty' => true,'parent'=>$parent->term_id]) as $children)
                {
                    if($children->term_id !== $this->id)
                        $result[] = new $called_class($children->term_id);
                    continue;
                }
            }
        }
        return  $result;
    }

    /**
     * -------------------------[ STATIC FUNCTIONS ]-------------------------
     */

    public static function get_termHierarchical()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $type=get_called_class()::$taxType;
        $className=get_called_class();

        $result = [];

        foreach (get_terms( $type,['hide_empty' => true,'parent'=>0,'exclude'=>15]) as $key=>$item)
        {
            $parent = new $className($item->term_id);
            $result[$key]['term'] = $parent;
            foreach (get_terms( $type,['hide_empty' => false,'parent'=>$item->term_id]) as $keyKey=>$tax)
            {
                $children = new $className($tax->term_id);
                $result[$key]['children'][$keyKey]['term'] = $children;

                foreach (get_terms( $type,['hide_empty' => false,'parent'=>$tax->term_id]) as $taxTax)
                {
                    
                    $childrenChildren = new $className($taxTax->term_id);

                    $result[$key]['children'][$keyKey]['children'][]['term']=$childrenChildren;
                }
            }
        }

        return $result;
    }

    public static function get_all()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $type=get_called_class()::$taxType;
        $className=get_called_class();

        $result = [];

        foreach (get_categories( ['taxonomy'=>$type, 'hide_empty'   => false] ) as $item)
        {
            $result[] = new $className($item->term_id);
        }

        return $result;
    }

    public static function get_include_terms(array $include)
    {

        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $type=get_called_class()::$taxType;
        $className=get_called_class();

        $result = [];
        foreach (get_categories( ['taxonomy'=>$type, 'hide_empty'=>false,'include'=>$include] ) as $item)
        {
            $result[] = new $className($item->term_id);
        }

        return $result;
    }

    public  function get_posts_by_term():?array
    {

        $calledClassTaxonomy = get_called_class();
        $calledClassPost = $calledClassTaxonomy::$postClass;

        $result = [];
        $args =
            [
                'post_type'=>$calledClassPost::$postType,
                'tax_query' =>
                    [
                        [
                            'taxonomy' => $this->type,
                            'field'    => 'term_id',
                            'terms'     =>  [$this->id],
                            'operator'  => 'IN',
                        ]
                    ],

            ];

        if(!$query = get_posts($args))
            return $result;

        foreach ($query as $item)
        {
            $result[]= new $calledClassPost($item->ID);
        }
        return $result;
    }



    public static function get_termFirstLevel()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $result = [];
        $className=get_called_class();
        foreach (get_terms( $className::$taxType,['hide_empty' => true,'parent'=>0,]) as $key=>$item)
        {
            $result[] = new $className($item->term_id);
        }
        return $result;
    }

    public static function get_termSecondLevel()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $result = [];
        $className=get_called_class();
        foreach (get_terms( self::$options['type'],['hide_empty' => false,'parent'=>0]) as $key=>$item)
        {

            foreach (get_terms( self::$options['type'],['hide_empty' => false,'parent'=>$item->term_id]) as $keyKey=>$tax)
            {
                $children = new $className($tax->term_id);
                $result[] = $children;
            }

        }
        return $result;
    }

    public static function get_termThirdLevel()
    {
        if(!self::check_static_variables(get_called_class()))
            throw new \Exception(get_called_class()." don't have required static variable");
        $result = [];
        $className=get_called_class();
        foreach (get_terms( self::$options['type'],['hide_empty' => true,'parent'=>0]) as $key=>$item)
        {

            foreach (get_terms( self::$options['type'],['hide_empty' => false,'parent'=>$item->term_id]) as $keyKey=>$tax)
            {

                foreach (get_terms( self::$options['type'],['hide_empty' => false,'parent'=>$tax->term_id]) as $taxTax)
                {

                    $childrenChildren = new $className($taxTax->term_id);

                    $result[$key]=$childrenChildren;
                }
            }
        }

        return $result;
    }

}
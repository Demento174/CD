<?php
namespace Controllers\CPT;

class CustomTaxonomyController{
    private $settings;
    private $slug;
    private $postSlug;
    private $labels;
    private $args;


    public function __construct($settings=null)
    {
        $this->settings = !$settings?require('settings.php'):$settings;

        if(array_key_exists('taxonomy',$this->settings) && null !== $this->settings['taxonomy'])
        {
            add_action('init', [$this,'handler']);
        }
    }

    private function set_labels($labels)
    {
        $this->labels = array(
            'name' =>  $labels['name'] ,
            'singular_name' => $labels['singular_name'],
            'search_items' =>  $labels['search_items'],
            'all_items' => $labels['all_items'],
            'parent_item' => $labels['parent_item'],
            'parent_item_colon' => $labels['parent_item_colon'],
            'edit_item' =>  $labels['edit_item'],
            'update_item' =>  $labels['update_item'],
            'add_new_item' =>  $labels['add_new_item'],
            'new_item_name' => $labels['new_item_name'],
            'menu_name' =>  $labels['menu_name'],
        );
    }

    private function set_args($args)
    {
        $this->args = $args;
        $this->args['labels'] = $this->labels;
    }


    private function register_post_type($slug,$args)
    {
        register_taxonomy($this->slug, $this->postSlug , $this->args);
    }

    public function handler()
    {
        if(null === $this->settings['taxonomy'])
        {
            return;
        }
        foreach ($this->settings['taxonomy'] as $item)
        {
            $this->slug = $item['slug'];
            $this->postSlug = $item['postSlug'];
            $this->set_labels($item['labels']);
            $this->set_args($item['args']);
            $this->register_post_type($this->slug,$this->args);
        }
    }
}
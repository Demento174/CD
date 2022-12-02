<?php
namespace Controllers\ACF;

class ACFController{
    private $settings;

    public function __construct($settings=null)
    {
        if($this->checkPlugin())
        {
            $this->settings = !$settings?require_once('settings.php'):$settings;
            $this->handler();
        }
    }

    private function checkPlugin()
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ){
            return true;
        }
        return false;
    }

    private function add_optionsPage($title,$slug,$position,$icon,$id)
    {
        $args = array(

            'page_title' => $title,

            'menu_title' => $title,

            'menu_slug' => $slug,

            'position' => $position,

            'parent_slug' => '',

            'icon_url' => $icon,

            'redirect' => true,

            'post_id' => $id,

            'autoload' => false,

            'update_button'		=> __('Update', 'acf'),

            'updated_message'	=> __("Options Updated", 'acf')
        );

        acf_add_options_page( $args );
    }

    private function add_optionsSubPage($id,$title,$slug,$parentSlug)
    {
        $args = array(

            'post_id' => $id,

            'page_title' => $title,

            'menu_title' => $title,

            'menu_slug' => $slug,

            'parent_slug' => $parentSlug,


        );

        acf_add_options_sub_page( $args );
    }

    private function handler()
    {
        if($this->settings['optionsPage'])
        {
            foreach ($this->settings['optionsPage'] as $item)
            {
                $this->add_optionsPage($item['title'],$item['slug'],$item['position'],$item['icon'],$item['id']);
            }
        }

        if($this->settings['optionsSubPage'])
        {
            foreach ($this->settings['optionsSubPage'] as $item)
            {
                $this->add_optionsSubPage($item['id'],$item['title'],$item['slug'],$item['parent_slug']);
            }
        }
    }
}
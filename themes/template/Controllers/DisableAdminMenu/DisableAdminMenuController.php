<?php

namespace Controllers\DisableAdminMenu;

class DisableAdminMenuController{

    private $settings;
    public function __construct($settings=null)
    {



        $this->settings = !$settings?require_once('settings.php'):$settings;

        if(!is_admin() || wp_get_current_user()->ID == $this->settings['administrator'])
        {
            return;
        }
        add_action('admin_menu', [$this,'handler']);
    }

    public function handler()
    {
        foreach ($this->settings['pages'] as $item)
        {
            remove_menu_page($item);
        }
    }
}
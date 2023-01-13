<?php
namespace Controllers;

class PluginCheck
{
    private $plugin;
    public function __construct($plugin)
    {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $this->plugin = $plugin;
        return $this->handler($this->plugin);
    }

    public static function handler($plugin)
    {
        if(!function_exists('is_plugin_active'))
        {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        return is_plugin_active($plugin);
    }
}
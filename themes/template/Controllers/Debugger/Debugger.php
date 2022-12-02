<?php

namespace Controllers\Debugger;
class Debugger{
    static $plugin_class_name = 'Symfony\Component\ErrorHandler\Debug';

    public function __construct()
    {
        if($this->check_plugin())
        {
            $this->handler();
        }

    }

    private function check_plugin()
    {
        return class_exists(self::$plugin_class_name);
    }

    private function handler()
    {
        /**
         * Dump variable.
         */
        if ( ! function_exists('d') ) {

            function d() {
                call_user_func_array( 'dump' , func_get_args() );
            }

        }

        /**
         * Dump variables and die.
         */
        if ( ! function_exists('dd') ) {

            function dd() {
                call_user_func_array( 'dump' , func_get_args() );
                die();
            }

        }
    }

    public static function Index()
    {
        $classController = new self();
    }
}
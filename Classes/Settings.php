<?php


namespace Controllers;


class Settings
{
    protected $settings;
    protected $file;
    private $errors =
        [
            'empty'=>'Input data is null and file is null',
            'file' => 'File not found',
            'type'=>'returns type settings is not array'
        ];



    protected function  __construct($input=null,$file=null)
    {


        if (empty($input) && empty($file))
        {
            throw new \Exception($this->errors['empty']);
        }



        if(empty($input))
        {
            $this->set_file($file);
            $data = $this->file;
        }else
            {
                $data = $input;
            }

        if($data=== true)
        {
            /*---------------------------[ START ]---------------------------*/
            echo '<pre class="debug" style="
                                    background-color: rgba(0,0,0,0.8);
                                    display: inline-block;
                                    border: 5px solid springgreen;
                                    color: white;
                                    padding: 1rem;">';

            var_dump($this->file);
            echo '</pre>';
            die;
            /*---------------------------[ END ]---------------------------*/
        }

        $this->set_settings($data);

    }


    private function set_file($path)
    {
        if(!file_exists($path))
        {
            throw new \Exception($this->errors['file'].' '.$path);
        }

        $this->file = require $path;


    }

    private function set_settings($data)
    {

        if (gettype($data) !== 'array')
        {

            throw new \Exception($this->errors['type']);
        }

        $this->settings = $data;
    }



}
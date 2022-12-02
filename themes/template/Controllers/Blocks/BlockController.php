<?php


namespace Controllers\Blocks;


class BlockController extends \Controllers\Blocks\BlockAbstractController
{

    static $VIEW_TEMPLATE = './blocks/';

    public function __construct($template,$input,$id = null,$debug=false)
    {

        parent::__construct(static::$VIEW_TEMPLATE.$template, $id, $input,$debug);
    }
}
<?php
namespace Controllers\ACF;
use \Controllers\PostsAndTax\PostAbstract as PostAbstract;


class GetACF{

    public static function getACF(array $selectors,$id=null,$dataInput=[])
    {
        $data=$dataInput;
//        $id = PostAbstract::query_id($id);

        foreach ($selectors as $key=>$item)
        {


            if( gettype($key) === 'string')
            {
                if( gettype($item) === 'string' && get_field($item,$id) )
                {
                    $data[$key] = get_field($item,$id);
                }else
                    {
                        $data[$key] = $item;
                    }

            }else if('string'=== gettype($item))
                {

                   $data[$item]= get_field($item,$id);
                }else
                    {
                        $data[$key]=$item;
                    }
        }
        return $data;
    }


}
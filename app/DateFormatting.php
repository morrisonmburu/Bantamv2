<?php
namespace App;

use Carbon\Carbon;

trait DateFormatting
{
    protected function dateFields()
    {
        return [];
    }

    public function getAttribute($key)
    {

        if ( in_array( $key, $this->dates ) ) {

            return  Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format('Y-m-d');
        }
        return parent::getAttribute($key);
    }

    public  function toArray(){
        $arr =  parent::toArray();
        foreach ($arr as $key => $value){

            if ( in_array( $key, $this->dates ) ) {


                $arr[$key] =  Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format('Y-m-d');
//                $arr[$key] =  "hello";
            }
        }
        return $arr;
    }
}
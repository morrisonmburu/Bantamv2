<?php
namespace App;

use Carbon\Carbon;

trait DateFormatting
{
    protected function dateFields()
    {
        return [];
    }

//    public function getAttribute($key)
//    {
//        if ( array_key_exists( $key, $this->dates ) ) {
//            return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('hello');
//        }
//        return parent::getAttribute($key);
//    }

//    public  function toArray(){
//        $arr =  parent::toArray();
//        foreach ($arr as $key => $value){
//
//            if ( in_array( $key, $this->dates ) ) {
//
//                $arr[$key] =  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
////                $arr[$key] =  "hello";
//            }
//        }
//        return $arr;
//    }
}
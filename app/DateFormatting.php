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
        try{
            if ( in_array( $key, $this->dates ) ) {

                return  Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format('Y-m-d');
            }
        }
        catch (\Exception $e){}

        return parent::getAttribute($key);
    }

    public  function toArray(){
        $arr =  parent::toArray();
        try{
            foreach ($arr as $key => $value){
                if ( in_array( $key, $this->dates ) ) {
                    $arr[$key] =  Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format('Y-m-d');
                }
            }
        }
        catch (\Exception $e) {}
        return $arr;
    }
}
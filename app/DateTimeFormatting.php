<?php
namespace App;

use Carbon\Carbon;

trait DateTimeFormatting
{
    protected function dateFields()
    {
        return [];
    }

    public function getAttribute($key)
    {
        try{
            if ( in_array( $key, $this->dates ) ) {

                return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
            }
        }
        catch (\Exception $e){}
        return parent::getAttribute($key);
    }

    public function toArray(){

        $arr =  parent::toArray();

        try {


            foreach ($arr as $key => $value) {

                if (in_array($key, $this->dates)) {
                    try {
                        $arr[$key] = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        catch (\Exception $e){}
        return $arr;
    }
}
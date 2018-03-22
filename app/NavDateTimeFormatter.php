<?php
namespace App;

use Carbon\Carbon;

trait NavDateTimeFormatter
{
    public function setNavTime($value, $name){
        try{
            $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
        }
        catch (\Exception $e){
            try{
                $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $value)->format('Y-m-d H:i:s');
            }
            catch (\Exception $e){
                try {
                    $this->attributes[$name] = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $value)->format('Y-m-d H:i:s');
                }catch (\InvalidArgumentException $iae){
                    $this->attributes[$name] = null;
                }
            }
        }
    }

    public function toArray(){
        $arr =  parent::toArray();
        foreach ($arr as $key => $value){
            if ( isset($this->dates) && in_array( $key, $this->dates ) ) {
                try {
                    $formatted = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
                    $arr[$key] = $formatted;
                }
                catch (\Exception $e){
                    try{
                        $formatted = Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format('Y-m-d\TH:i:s');
                        $arr[$key] = $formatted;
                    }
                    catch (\Exception $e){
                    }
                }
            }
        }
        return $arr;
    }
}
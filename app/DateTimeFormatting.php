<?php
namespace App;

use Carbon\Carbon;

trait DateTimeFormatting
{

    public function getAttribute($key)
    {
        if ( isset($this->dates) && in_array( $key, $this->dates ) ) {
            try{
                return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
            }
            catch (\Exception $e){
            }
        }
        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if ( isset($this->dates) && in_array( $key, $this->dates ) ) {
            try{
                $this[$key] =  Carbon::createFromFormat('Y-m-d\ H:i:s', $value)->format('Y-m-d H:i:s');
            }
            catch (\Exception $e){
                $this[$key] =  Carbon::createFromFormat('Y-m-d\TH:i:s', $value)->format('Y-m-d H:i:s');
            }
        }
        parent::setAttribute($key, $value);
    }


    public function toArray()
    {

        $arr = parent::toArray();
        foreach ($arr as $key => $value) {
            if (isset($this->dates) && in_array($key, $this->dates)) {
                try {
                    $arr[$key] = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
                } catch (\Exception $e) {
                }
            }
            return $arr;
        }
    }
}
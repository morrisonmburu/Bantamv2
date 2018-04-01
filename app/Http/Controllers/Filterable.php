<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait Filterable{

    private function filter($filters, $filter_model = null, $query = null){
        $specials = [
            '@month' =>  function ($query, $args) {
                $args = explode(",", $args, 2);
                return $query->whereRaw( " MONTH($args[0]) = $args[1] ");
            },
            '@year' =>  function ($query, $args) {
                $args = explode(",", $args, 2);
                return $query->whereRaw( " YEAR($args[0]) = $args[1] ");
            },
            '@day' =>  function ($query, $args) {
                $args = explode(",", $args, 2);
                return $query->whereRaw(" DAY($args[0]) = $args[1] ");
            },
            '@order_by' =>  function ($query, $args) {
                $args = explode(",", $args, 2);
                $sort = count($args) > 1 ?   $args[1] : 'ASC';
                return $query->orderBy($args[0], $sort);
            },
        ];

        $filters = $filters instanceof Request ? $filters->all() : $filters;
        $original_filters = $filters;
        $model = $filter_model? $filter_model : $this->filter_model;
        $query = $query? $query : $model::query();
        $count = 0;

        $columns = Schema::getColumnListing((new $model())->getTable());
        foreach ($filters as $key => $val){
            if(!$this->in_arrayi($key, $columns)){
                unset($filters[$key]);
            }
        }

        foreach ((new $model())->getHidden() as $hidden){
            if(key_exists($hidden, $filters)){
                unset($filters[$hidden]);
            }
        }
        foreach ($filters as $key => $value){
            if(is_array($value)){
                $query->where(function($arr_query) use ($value, $key){
                    $arr_count = 0;
                    foreach ($value as $item){
                        if($arr_count == 0){
                            $arr_query->where($key, $item);
                        }
                        else{
                            $arr_query->orWhere($key, $item);
                        }
                        $arr_count++;
                    }
                });

            }
            else{
                if($count == 0){
                    $query = $query->where($key, $value);
                }
                else{
                    $query = $query->where($key, $value);
                }
            }
            $count++;
        }


        foreach($original_filters as $key => $value){
            if($this->in_arrayi( $key, array_keys($specials))){
                try{
                    if (is_array($value)){
                        foreach ($value as $item){
                            $query = $specials[$key]($query, $item);
                        }
                    }
                    else $query = $specials[$key]($query, $value);
                } catch (\Exception $e){
                }

            }

        }

        return $query;
    }

    function in_arrayi($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
<?php

namespace App\Providers;

use App\Employee;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\ServiceProvider;

class EmployeeUserProvider extends \Illuminate\Auth\EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();
//        foreach ($credentials as $key => $value) {
//            if (! Str::contains($key, 'password')) {
//                $query->where($key, $value);
//            }
//        }

        $query->where('email', $credentials['login']);

        if($query->count() > 0){
            return $query->first();
        }



        $emloyee_query = Employee::where('No', $credentials['login']);


        if($emloyee_query->count() < 1){
            return $query->first();
        }

        $employee = $emloyee_query->first();
        return $employee->user;
//        return parent::retrieveByCredentials($credentials);
    }
}

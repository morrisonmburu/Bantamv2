<?php

namespace Tests\Feature;

use App\Employee;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsersCreated(){
        factory(Employee::class, 3)->create();
        $this->assertEquals(3, Employee::all()->count());
        $this->assertEquals(3, User::all()->count());
    }
}

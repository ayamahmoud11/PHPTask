<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
{
    parent::setUp();
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'customer']);
}
}

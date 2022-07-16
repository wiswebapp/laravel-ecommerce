<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

Route::get('create-permission',function(){

    $term = ['Role','Admin','User','Category','SubCategory','Product','Pages'];

    foreach ($term as $itemValue) {

        Permission::create([
            'name' => 'Create ' . $itemValue,
            'guard_name' => 'admin'
        ]);

        Permission::create([
            'name' => 'View ' . $itemValue,
            'guard_name' => 'admin'
        ]);

        Permission::create([
            'name' => 'Edit ' . $itemValue,
            'guard_name' => 'admin'
        ]);

        Permission::create([
            'name' => 'Delete ' . $itemValue,
            'guard_name' => 'admin'
        ]);
    }
});

?>

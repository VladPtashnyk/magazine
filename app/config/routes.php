<?php 
    $urlRoutes = [
        '' => 'site/home/index',
        'home' => 'site/home/index',
        'home/basket' => 'site/home/basket',
        'home/order' => 'site/home/createOrder',
        'admin' => 'admin/admin/index',
        'admin/login' => 'admin/admin/login',
        'admin/register' => 'admin/admin/register',
        'admin/dashboard' => 'admin/admin/dashboard',
        
        //status
        'admin/status' => 'admin/status/status',
        'admin/status/check' => 'admin/status/check',

        //products
        'admin/products' => 'admin/product/products',
        'admin/product' => 'admin/product/open',
        'admin/product/create' => 'admin/product/create',
        'admin/product/update' => 'admin/product/update',
        'admin/product/delete' => 'admin/product/delete',

        //category
        'admin/categories' => 'admin/category/categories',
        'admin/category' => 'admin/category/open',
        'admin/category/create' => 'admin/category/create',
        'admin/category/update' => 'admin/category/update',
        'admin/category/delete' => 'admin/category/delete',

        //subCategories
        'admin/subCategories' => 'admin/subCategory/subCategories',
        'admin/subCategory' => 'admin/subCategory/open',
        'admin/subCategory/create' => 'admin/subCategory/create',
        'admin/subCategory/update' => 'admin/subCategory/update',
        'admin/subCategory/delete' => 'admin/subCategory/delete',

        //orders
        'admin/orders' => 'admin/order/order',
    ];
<?php
/*
|    Routes
|    structure: {method}:{path}
|    e.g: get:products/all
|         post:products/new
*/
return [
    'get' => [
        'wikis/find/{id}' => [\App\Controllers\WikisController::class, 'find'],
        'wikis/search' => [\App\Controllers\WikisController::class, 'search'],
    ],
    'post' => [
        'wikis/new' => [\App\Controllers\WikisController::class, 'store']
    ]
];
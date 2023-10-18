<?php
/*
|    Routes
|    structure: {method}:{path}
|    e.g: get:products/all
|         post:products/new
*/
return [
    'get' => [
        'api/wikis/find/{id}' => [\App\Controllers\WikisController::class, 'find'],
        'api/wikis/search' => [\App\Controllers\WikisController::class, 'search'],
    ],
    'post' => [
        'api/wikis/new' => [\App\Controllers\WikisController::class, 'store']
    ]
];
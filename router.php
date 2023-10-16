<?php
/*
|    Routes
|    structure: {method}:{path}
|    e.g: get:products/all
|         post:products/new
*/
return [
    'post:wikis/new' => [\App\Controllers\WikisController::class, 'new']
];
<?php

namespace App\Controllers;

use App\models\Wiki;
use src\Controller;
use src\database\adapters\MysqliAdapter;
use src\database\Connections\MysqliConnection;
use src\helpers\ConfigReader;
use src\helpers\DBHelper;
use src\helpers\JsonResponse;
use src\helpers\RequestHelper;

class WikisController
{
    private Wiki $wikiModel;

    public function __construct()
    {
        $this->wikiModel = new Wiki();
    }

    public function store(RequestHelper $request)
    {
        $request->validate(['title', 'description']);

        $this->wikiModel->create([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]);

        return JsonResponse::create([
            'hasError' => false,
            'message' => 'ویکی جدید با موفقیت ساخته شد'
        ]);
    }
}
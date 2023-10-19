<?php

namespace App\Controllers;

use app\Helpers\StringHelper;
use App\models\Wiki;
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

    public function store(RequestHelper $request): string
    {
        $request->checkNotEmpty(['title', 'description']);

        $this->wikiModel->create([
            'title' => $request->get('title'),
            'keyword' => $request->get('keyword'),
            'description' => $request->get('description'),
            'image' => $request->get('image')
        ]);

        return JsonResponse::create([
            'status' => 200,
            'message' => 'ویکی جدید با موفقیت ساخته شد'
        ]);
    }

    public function find(RequestHelper $request)
    {
        if ($request->hasQueryParam('id')) {
            $wiki = $this->wikiModel->getById(intval($request->getQueryParams()['id']));
            $relatedWikis = []; // based on description
            $keyword = trim($wiki['keyword']);
            $wikisTableName = $this->wikiModel->getTableName();
            $query = "SELECT id,description FROM {$wikisTableName} 
                      WHERE description LIKE '%{$keyword}%'
                      AND id != " . $wiki['id'];
            $results = DBHelper::getInstance()->fetchAll($query);

            $keywordFirstPart = explode(' ', $keyword)[0];
            foreach ($results as $item) {
                $descriptionWords = explode(' ', trim($item['description']));
                $descriptionWords = array_filter($descriptionWords, function ($item) {
                    return trim($item) !== '';
                });
                $descriptionWords = array_values($descriptionWords);
                $relatedWikis[$item['id']] = array_search($keywordFirstPart, $descriptionWords);
            }

            if ($wiki) {
                return JsonResponse::create([
                    'status' => 200,
                    'results' => [
                        'id' => $wiki['id'],
                        'title' => $wiki['title'],
                        'description' => $wiki['description'],
                        'image' => $wiki['image'],
                        'related' => $relatedWikis
                    ]
                ]);
            }

            return JsonResponse::create([
                'status' => 404,
                'message' => 'هیچ ویکی‌ای با آیدی مورد نظر شما پیدا نشد'
            ]);
        }
    }

    public function search(RequestHelper $request)
    {
        $request->checkNotEmpty(['query']);
        $results = $this->wikiModel
            ->where(
                'title',
                'LIKE',
                sprintf("%%%s%%", $request->get('query')), // %{query}%
                ['id', 'title']
            );
        return JsonResponse::create([
            'status' => 200,
            'results' => $results
        ]);
    }
}
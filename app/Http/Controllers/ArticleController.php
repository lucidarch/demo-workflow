<?php

namespace App\Http\Controllers;

use Lucid\Foundation\Http\Controller;
use App\Features\UpdateArticleFeature;

class ArticleController extends Controller
{
    public function update($articleId)
    {
        return $this->serve(UpdateArticleFeature::class, ['articleId' => intval($articleId)]);
    }
}

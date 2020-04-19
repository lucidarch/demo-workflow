<?php

namespace App\Domains\Article\Tests\Jobs;

use App\Data\Models\Article;
use App\Domains\Article\Jobs\SaveArticleJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SaveArticleJobTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_save_article_job()
    {
        $title = 'New Unique Title';
        $content = 'Replaced content with this new piece.';

        $article = factory(Article::class)->create();

        $job = new SaveArticleJob($article->id, $title, $content);

        // we expect one record to be updateed only.
        $this->assertEquals(1, $job->handle());
    }
}

<?php

namespace App\Domains\Article\Tests\Jobs;

use App\Data\Models\Article;
use App\Data\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Domains\Article\Jobs\AuthoriseArticleUpdateJob;
use Tests\TestCase;

class AuthoriseArticleUpdateJobTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_authorise_article_update_job()
    {
        $article = factory(Article::class)->create();

        $user = $article->user;

        $job = new AuthoriseArticleUpdateJob($user, $article->id);

        // this usually throws ModelNotFoundException
        // if the user was not found. Not having anything returned is a good sign
        $this->assertNull($job->handle());
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_fails_authorisation_for_different_user()
    {
        $article = factory(Article::class)->create();

        $anotherUser = factory(User::class)->create();

        $job = new AuthoriseArticleUpdateJob($anotherUser, $article->id);

        $job->handle();
    }
}

<?php

namespace App\Tests\Features;

use Tests\TestCase;
use App\Data\Models\User;
use App\Data\Models\Article;
use App\Features\UpdateArticleFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateArticleFeatureTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_updating_article_feature()
    {
        $article = factory(Article::class)->create();
        $user = $article->user;

        $this->actingAs($user)->put("/articles/$article->id", [
            'title' => 'My Updated New Title',
            'content' => 'Shiny shiny, shiny new content.',
        ])->assertJson([
            'status'=> 200,
            'data' => [
                'success' => true,
            ]
        ]);

        $retrieved = Article::find($article->id);

        $this->assertEquals('My Updated New Title', $retrieved->title);
        $this->assertEquals('Shiny shiny, shiny new content.', $retrieved->content);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_updating_article_fails_when_unauthorised()
    {
        $article = factory(Article::class)->create();
        $anotherUser = factory(User::class)->create();

        $this->actingAs($anotherUser)->put("/articles/$article->id", [
            'title' => 'My Updated New Title',
            'content' => 'Shiny shiny, shiny new content.',
        ])->assertJson([
            'status'=> 200,
            'data' => [
                'success' => true,
            ]
        ]);
    }
}

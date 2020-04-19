<?php


namespace App\Domains\Article\Tests\Jobs;

use App\Domains\Article\Jobs\ValidateArticleInputJob;
use Lucid\Foundation\Validator;
use Tests\TestCase;

class ValidateArticleInptJobTest extends TestCase
{
    public function test_validate_article_input_job()
    {
        $job = new ValidateArticleInputJob([
            'title' => 'The Title',
            'content' => 'The content of the article goes here.',
        ]);

        $this->assertTrue($job->handle(app(Validator::class)));
    }

    /**
     * @dataProvider articleInputValidationProvider
     * @expectedException \Lucid\Foundation\InvalidInputException
     */
    public function test_validating_article_input_job_rules($title = null, $content = null)
    {
        $job = new ValidateArticleInputJob(compact('title', 'content'));
        $job->handle(app(Validator::class));
    }

    public function articleInputValidationProvider()
    {
        return [
            'without title' => [
                'content' => 'The content of the article.',
            ],
            'title is empty' => [
                'title' => '',
                'content' => 'The content of the article.',
            ],
            'without content' => [
                'title' => 'The Title Only',
            ],
            'content is empty' => [
                'title' => 'The Title Here',
                'content' => '',
            ],
            'max title length' => [
                'title' => str_repeat('a', 101),
                'content' => 'Content goes here',
            ],
            'max content length' => [
                'title' => 'Title here',
                'content' => str_repeat('a', 1001),
            ],
        ];
    }
}

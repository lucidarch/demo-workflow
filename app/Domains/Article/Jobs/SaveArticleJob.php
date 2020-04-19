<?php

namespace App\Domains\Article\Jobs;

use Lucid\Foundation\Job;
use App\Data\Models\Article;

class SaveArticleJob extends Job
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;
    /**
     * @var int
     */
    private $articleId;

    /**
     * Create a new job instance.
     *
     * @param int $articleId
     * @param string $title
     * @param string $content
     */
    public function __construct(int $articleId, string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
        $this->articleId = $articleId;
    }

    /**
     * Execute the job.
     *
     * @return int The number of records that were changed.
     *              It will be 1 if update was successful.
     *              Otherwise it's a 0.
     */
    public function handle() : int
    {
        return Article::where('id', $this->articleId)->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);
    }
}

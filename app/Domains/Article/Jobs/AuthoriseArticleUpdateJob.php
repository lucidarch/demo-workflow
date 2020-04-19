<?php

namespace App\Domains\Article\Jobs;

use Lucid\Foundation\Job;
use App\Data\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthoriseArticleUpdateJob extends Job
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var int
     */
    private $articleId;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param int $articleId
     */
    public function __construct(User $user, int $articleId)
    {
        $this->user = $user;
        $this->articleId = $articleId;
    }

    /**
     * Execute the job.
     *
     * @throws ModelNotFoundException
     */
    public function handle()
    {
        User::where('id', $this->user->id)->whereHas('articles', function ($query) {
            $query->where('id', $this->articleId);
        })->firstOrFail();
    }
}

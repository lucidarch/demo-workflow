<?php

namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use App\Notifications\ArticlePublished;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class NotifyFollowersJob extends Job
{
    /**
     * @var Collection
     */
    private $followers;

    /**
     * Create a new job instance.
     *
     * @param Collection $followers of User models
     */
    public function __construct(Collection $followers)
    {
        $this->followers = $followers;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Notification::send($this->followers, new ArticlePublished());
    }
}

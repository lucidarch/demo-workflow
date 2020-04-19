<?php

namespace App\Domains\User\Jobs;

use Lucid\Foundation\Job;
use App\Data\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetUserFollowersJob extends Job
{
    /**
     * @var int
     */
    private $userId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return Collection of User models
     */
    public function handle() : Collection
    {
        return User::find($this->userId)->followers;
    }
}

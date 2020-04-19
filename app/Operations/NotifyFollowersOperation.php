<?php

namespace App\Operations;

use Lucid\Foundation\QueueableOperation;
use Illuminate\Http\Request;
use App\Domains\User\Jobs\NotifyFollowersJob;
use App\Domains\User\Jobs\GetUserFollowersJob;

class NotifyFollowersOperation extends QueueableOperation
{
    /**
     * @var int
     */
    private $userId;

    /**
     * NotifyFollowersOperation constructor.
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $followers = $this->run(GetUserFollowersJob::class, [
            'userId' => $this->userId
        ]);

        $this->run(NotifyFollowersJob::class, compact('followers'));
    }
}

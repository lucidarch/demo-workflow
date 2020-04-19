<?php

namespace App\Domains\Activity\Jobs;

use App\Data\Models\ActivityLog;
use Lucid\Foundation\QueueableJob;

class LogActivityJob extends QueueableJob
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $description;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param string $description
     */
    public function __construct(int $userId, string $description)
    {
        $this->userId = $userId;
        $this->description = $description;
    }

    /**
     * Execute the job.
     *
     * @return ActivityLog
     */
    public function handle() : ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $this->userId,
            'description' => $this->description,
        ]);
    }
}

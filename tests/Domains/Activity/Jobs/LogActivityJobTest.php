<?php

namespace App\Domains\Activity\Tests\Jobs;

use App\Data\Models\ActivityLog;
use App\Data\Models\User;
use App\Domains\Activity\Jobs\LogActivityJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogActivityJobTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_log_activity_job()
    {
        $user = factory(User::class)->create();

        $job = new LogActivityJob($user->id, "tested logging activity");

        $activity = $job->handle();
        $this->assertInstanceOf(ActivityLog::class, $activity);
        $this->assertEquals($activity->user_id, $user->id);
        $this->assertEquals($activity->description, "tested logging activity");

    }
}

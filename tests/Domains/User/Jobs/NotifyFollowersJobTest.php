<?php

namespace App\Domains\User\Tests\Jobs;

use App\Data\Models\User;
use App\Notifications\ArticlePublished;
use Illuminate\Support\Facades\Notification;
use App\Domains\User\Jobs\NotifyFollowersJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotifyFollowersJobTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_notify_followers_job()
    {
        $users = factory(User::class, 5)->create();

        $job = new NotifyFollowersJob($users);

        Notification::shouldReceive('send')
            ->once()->with($users, ArticlePublished::class);

        $job->handle();
    }
}

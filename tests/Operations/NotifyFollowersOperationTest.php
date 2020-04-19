<?php

namespace App\Tests\Operations;

use Mockery;
use Tests\TestCase;
use App\Data\Models\User;
use App\Operations\NotifyFollowersOperation;
use App\Domains\User\Jobs\NotifyFollowersJob;
use App\Domains\User\Jobs\GetUserFollowersJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotifyFollowersOperationTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function test_notifying_followers()
    {
        $user = factory(User::class)->create();
        $followers = factory(User::class, 5)->create();

        $op = Mockery::mock(NotifyFollowersOperation::class, [$user->id])
            ->makePartial();

        $op->shouldReceive('run')
            ->once()->with(GetUserFollowersJob::class, ['userId' => $user->id])
            ->andReturn($followers);

        $op->shouldReceive('run')
            ->once()->with(NotifyFollowersJob::class, compact('followers'));

        $op->handle();
    }
}

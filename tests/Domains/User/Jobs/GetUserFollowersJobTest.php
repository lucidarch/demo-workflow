<?php

namespace App\Domains\User\Tests\Jobs;

use App\Data\Models\User;
use App\Domains\User\Jobs\GetUserFollowersJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GetUserFollowersJobTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_get_user_followers_job()
    {
        // prepare
        $user = factory(User::class)->create();

        $followers = factory(User::class, 5)->create();

        $user->followers()->saveMany($followers);

        // test
        $job = new GetUserFollowersJob($user->id);

        $retreived = $job->handle();

        $this->assertEquals($followers->toArray(),
            $retreived->makeHidden(['pivot', 'email_verified_at'])->toArray());
    }
}

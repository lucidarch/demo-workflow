<?php

namespace App\Features;

use Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;
use App\Domains\Article\Jobs\SaveArticleJob;
use App\Operations\NotifyFollowersOperation;
use App\Domains\Activity\Jobs\LogActivityJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Article\Jobs\ValidateArticleInputJob;
use App\Domains\Article\Jobs\AuthoriseArticleUpdateJob;

class UpdateArticleFeature extends Feature
{
    /**
     * @var int
     */
    private $articleId;

    /**
     * CreateArticleFeature constructor.
     *
     * @param int $articleId
     */
    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $this->run(new ValidateArticleInputJob($request->input()));

        $this->run(AuthoriseArticleUpdateJob::class, [
            'user' => Auth::user(),
            'articleId' => $this->articleId,
        ]);

        $isSuccess = $this->run(SaveArticleJob::class, [
            'articleId' => $this->articleId,
            'title'=> $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $this->run(LogActivityJob::class, [
            'userId' => Auth::user()->id,
            'description' => "Article updated ".$this->articleId,
        ]);

        $this->run(NotifyFollowersOperation::class, [
            'userId' => Auth::user()->id,
        ]);

        return $this->run(new RespondWithJsonJob(['success' => $isSuccess]));
    }
}

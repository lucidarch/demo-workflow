<?php

namespace App\Domains\Article\Jobs;

use Lucid\Foundation\Job;
use Lucid\Foundation\Validator;

class ValidateArticleInputJob extends Job
{
    /**
     * @var array
     */
    private $input;

    /**
     * @var array
     */
    private $rules = [
        'title' => ['required', 'string', 'max:100'],
        'content' => ['required', 'string', 'max:1000'],
    ];

    /**
     * Create a new job instance.
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @param Validator $validator
     * @return bool
     *
     * @throws \Lucid\Foundation\InvalidInputException
     */
    public function handle(Validator $validator) : bool
    {
        return $validator->validate($this->input, $this->rules);
    }
}

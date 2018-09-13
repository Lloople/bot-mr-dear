<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_answer_With_a_help_message()
    {
        $this->bot->receives('/help')
            ->assertReply(trans('ohdear.help.title'))
            ->assertReply(file_get_contents(resource_path('markdown/help.md')));
    }

}
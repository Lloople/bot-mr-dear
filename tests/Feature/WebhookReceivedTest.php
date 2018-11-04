<?php

namespace Tests\Feature;

use App\Jobs\Webhook\BrokenLinksFound;
use App\Jobs\Webhook\UptimeCheckFailed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class WebhookReceivedTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function uptime_check_failed_is_queued_for_the_specific_user()
    {
        Queue::fake();

        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $response = $this->postJson(route('webhook', $user), $this->uptimeCheckFailedPayload(), ['OhDear-Signature' => 'secret']);

        $response->assertSuccessful();

        Queue::assertPushed(UptimeCheckFailed::class, function ($job) {
            return $job->user->telegram_id === 'ohdearapp';
        });
    }

    /** @test */
    public function broken_links_found_is_queued_for_the_specific_user()
    {
        Queue::fake();

        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $response = $this->postJson(route('webhook', $user), $this->brokenLinksFoundPayload(), ['OhDear-Signature' => 'secret']);

        $response->assertSuccessful();

        Queue::assertPushed(BrokenLinksFound::class, function ($job) {
            return $job->user->telegram_id === 'ohdearapp';
        });
    }

    private function uptimeCheckFailedPayload()
    {
        return [
            'type' => 'uptimeCheckFailed',
            'site' => [
                'url' => 'https://foo.bar'
            ],
        ];
    }

    private function brokenLinksFoundPayload()
    {
        return [
            'type' => 'brokenLinksFound',
            'site' => [
                'url' => 'https://foo.bar'
            ],
            'run' => [
                'result_payload' => [
                    [
                        'cralwed_url' => 'https://foo.bar/foo',
                        'status_code' => 404,
                        'found_on_url' => 'https://foo.bar'
                    ]
                ]
            ]
        ];
    }
}
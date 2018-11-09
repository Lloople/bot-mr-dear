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
    public function it_fails_if_missing_header_signature()
    {

        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $response = $this->postJson(route('webhook', $user));

        $response->assertStatus(400);

        $response->assertSeeText('The request did not contain a header named `OhDear-Signature`.');
    }

    /** @test */
    public function it_fails_if_user_does_not_set_the_webhook_secret()
    {
        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => null]);

        $response = $this->postJson(route('webhook', $user), [], ['OhDear-Signature' => 'not-in-use-right-now']);

        $response->assertStatus(400);

        $response->assertSeeText('The OhDear webhook signing secret is not set.');

    }

    /** @test */
    public function it_fails_if_signature_is_not_valid()
    {
        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $response = $this->postJson(route('webhook', $user), [], ['OhDear-Signature' => 'it-will-fail']);

        $response->assertStatus(400);

        $response->assertSeeText("The signature `it-will-fail` found in the header");
    }

    /** @test */
    public function it_fails_if_type_is_not_in_the_payload()
    {
        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $signature = hash_hmac('sha256', '{"foo":"bar"}', 'secret');

        $response = $this->postJson(route('webhook', $user), ['foo' => 'bar'], ['OhDear-Signature' => $signature]);

        $response->assertStatus(400);

        $response->assertSeeText('The webhook call did not contain a type.');
    }

    /** @test */
    public function it_fails_if_the_type_job_does_not_exists()
    {
        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $signature = hash_hmac('sha256', '{"type":"notFoundJob"}', 'secret');

        $response = $this->postJson(route('webhook', $user), ['type' => 'notFoundJob'], ['OhDear-Signature' => $signature]);

        $response->assertStatus(400);

        $response->assertSeeText("The type notFoundJob is not currently supported.");
    }

    /** @test */
    public function uptime_check_failed_is_queued_for_the_specific_user()
    {
        Queue::fake();

        $user = factory(User::class)->create(['username' => 'foobar', 'telegram_id' => 'ohdearapp', 'webhook' => encrypt('secret')]);

        $signature = hash_hmac('sha256', json_encode($this->uptimeCheckFailedPayload()), 'secret');

        $response = $this->postJson(route('webhook', $user), $this->uptimeCheckFailedPayload(), ['OhDear-Signature' => $signature]);

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

        $signature = hash_hmac('sha256', json_encode($this->brokenLinksFoundPayload()), 'secret');

        $response = $this->postJson(route('webhook', $user), $this->brokenLinksFoundPayload(), ['OhDear-Signature' => $signature]);

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
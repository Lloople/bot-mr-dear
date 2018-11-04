<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\WebhookException;

class WebhookReceivedController extends Controller
{

    public function __invoke(Request $request, User $user)
    {
        $signature = $request->header('OhDear-Signature');

        if (! $signature) {
            throw WebhookException::missingSignature();
        }

        if (decrypt($user->webhook) !== $signature) {
            throw WebhookException::invalidSignature($signature);
        }

        $eventPayload = json_decode($request->getContent());

        if (! isset($eventPayload->type)) {
            throw WebhookException::missingType();
        }

        $jobClass = $this->determineJobClass($eventPayload->type);

        if (! class_exists($jobClass)) {
            throw WebhookException::unrecognizedType($eventPayload->type);
        }

        dispatch(new $jobClass($eventPayload, $user));

        return response('User will be notified. Thank you OhDear!');
    }

    protected function determineJobClass(string $type): string
    {
        return '\\App\\Jobs\\Webhook\\'.ucfirst($type);
    }
}

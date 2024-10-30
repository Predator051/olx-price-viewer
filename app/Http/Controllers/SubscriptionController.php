<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{

    public function __construct(private SubscriptionService $priceSubscriber)
    {
    }

    public function index(SubscribeRequest $request): RedirectResponse
    {
        ['link' => $link, 'email' => $email] = $request->all();
        $this->priceSubscriber->subscribe($link, $email);

        return Redirect::back()->with('status', 'You have successfully subscribed to price alerts!');
    }
}

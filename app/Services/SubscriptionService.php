<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\OlxPriceParser;
use App\Models\OlxPrice;
use App\Models\OlxPriceSubscriber;

readonly class SubscriptionService
{
    public function __construct(private OlxPriceParser $parser)
    {
    }

    public function subscribe(string $link, string $email): void
    {
        $price = $this->parser->parse($link);
        $olxPrice = OlxPrice::query()->firstOrCreate(
            [
                'link' => $link,
                'price' => $price
            ]
        );

        $subscribed = OlxPriceSubscriber::query()->firstOrCreate(['email' => $email]);
        $subscribed->prices()->syncWithoutDetaching($olxPrice->id);
//        if (!$subscribed->prices->contains($olxPrice->id)) {
//            $subscribed->prices()->attach($olxPrice->id);
//        }
    }
}

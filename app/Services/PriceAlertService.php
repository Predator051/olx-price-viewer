<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\OlxPriceParser;
use App\Mail\PriceChanged;
use App\Models\OlxPrice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

readonly class PriceAlertService
{
    public function __construct(private OlxPriceParser $parser)
    {
    }

    public function notifySubscribersOnPriceChange(): int
    {
        $changedPrices = $this->getChangedPrices();

        return $this->sendNotificationsAndUpdatePrices($changedPrices);
    }

    private function getChangedPrices(): Collection
    {
        $changedPrices = new Collection();

        /** @var OlxPrice $price */
        foreach (OlxPrice::query()->cursor() as $price) {
            try {
                $fetchedPrice = $this->parser->parse($price->link);
            } catch (\Exception $e) {
                Log::error("Failed to fetch price for link {$price->link}: {$e->getMessage()}");
                continue;
            }

            if ($fetchedPrice != $price->price) {
                $changedPrices->push(['price' => $price, 'newPrice' => $fetchedPrice]);
            }
        }

        return $changedPrices;
    }

    private function sendNotificationsAndUpdatePrices(Collection $changedPrices): int
    {
        $countOfPlannedRecipients = 0;

        foreach ($changedPrices as $data) {
            $price = $data['price'];
            $newPrice = $data['newPrice'];

            $countOfPlannedRecipients += $this->notifySubscribers($price, $newPrice);

            $this->updatePrice($price, $newPrice);
        }

        return $countOfPlannedRecipients;
    }

    private function notifySubscribers(OlxPrice $price, string $newPrice): int
    {
        try {
            Mail::to($price->subscribers)
                ->queue(new PriceChanged($price->price, $newPrice, $price->link));

            return $price->subscribers->count();
        } catch (\Exception $e) {
            Log::error("Failed to send email for link {$price->link}: {$e->getMessage()}");

            return 0;
        }
    }

    private function updatePrice(OlxPrice $price, string $newPrice): void
    {
        $price->price = $newPrice;
        $price->save();
    }
}

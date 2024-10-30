<?php

namespace Tests\Feature;

use App\Mail\PriceChanged;
use App\Models\OlxPrice;
use App\Models\OlxPriceSubscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PriceChangeNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that no emails are sent if the price has not changed.
     */
    public function test_no_email_sent_when_price_does_not_change(): void
    {
        Mail::fake();

        OlxPrice::factory()->has(OlxPriceSubscriber::factory(2), 'subscribers')->create([
            'price' => '500 uah'
        ]);

        $this->mockOlxPriceParser('500 uah');

        $this->artisan('app:price-change-notification')->assertOk();

        Mail::assertNotQueued(PriceChanged::class);
    }

    /**
     * Test that email is sent to multiple subscribers when price changes.
     */
    public function test_email_sent_to_multiple_subscribers_on_price_change(): void
    {
        Mail::fake();

        OlxPrice::factory()->has(OlxPriceSubscriber::factory(5), 'subscribers')->create([
            'price' => '500 uah'
        ]);

        $this->mockOlxPriceParser('600 uah');

        $this->artisan('app:price-change-notification')->assertOk();

        Mail::assertQueued(PriceChanged::class, 1);
    }

    /**
     * Test that no emails are sent when there are no subscribers.
     */
    public function test_no_email_sent_when_no_subscribers_exist(): void
    {
        Mail::fake();

        OlxPrice::factory()->create([
            'price' => '500 uah'
        ]);

        $this->mockOlxPriceParser('500 uah');

        $this->artisan('app:price-change-notification')->assertOk();

        Mail::assertNotQueued(PriceChanged::class);
    }

    /**
     * Test that notification is sent only to subscribers of items with changed prices.
     */
    public function test_email_sent_only_for_items_with_price_changes(): void
    {
        Mail::fake();

        OlxPrice::factory()->has(OlxPriceSubscriber::factory(3), 'subscribers')->create([
            'price' => '500 uah',
            'link' => 'https://example.com/item1'
        ]);

        OlxPrice::factory()->has(OlxPriceSubscriber::factory(2), 'subscribers')->create([
            'price' => '300 uah',
            'link' => 'https://example.com/item2'
        ]);

        $this->mockOlxPriceParser('600 uah', 'https://example.com/item1');

        $this->artisan('app:price-change-notification')->assertOk();

        Mail::assertQueued(PriceChanged::class, 1);
    }
}

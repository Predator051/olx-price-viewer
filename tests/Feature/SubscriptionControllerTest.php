<?php

namespace Tests\Feature;

use App\Models\OlxPrice;
use App\Models\OlxPriceSubscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $validEmail = 'example@gmail.com';
    private string $validLink = 'https://www.olx.ua/d/uk/obyavlenie/opel-astra-2013-roku-IDVrJ2P.html';

    /**
     * Test successful subscription and redirection.
     */
    public function test_subscribe_creates_subscription_and_redirects(): void
    {
        $response = $this->post('/subscribe', [
            'email' => $this->validEmail,
            'link' => $this->validLink,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status', 'You have successfully subscribed to price alerts!');
    }

    /**
     * Test that subscription saves new OlxPrice and OlxPriceSubscriber to the database.
     */
    public function test_subscribe_stores_price_and_subscriber_in_database(): void
    {
        $this->mockOlxPriceParser('0 uah');
        $this->post('/subscribe', [
            'email' => $this->validEmail,
            'link' => $this->validLink,
        ]);

        $this->assertDatabaseCount(OlxPrice::class, 1);
        $this->assertDatabaseCount(OlxPriceSubscriber::class, 1);
    }

    /**
     * Test validation failure with invalid email format.
     */
    public function test_subscribe_fails_with_invalid_email(): void
    {
        $response = $this->post('/subscribe', [
            'email' => 'invalid-email',
            'link' => $this->validLink,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test validation failure with invalid link format.
     */
    public function test_subscribe_fails_with_invalid_link(): void
    {
        $response = $this->post('/subscribe', [
            'email' => $this->validEmail,
            'link' => 'https://www.example.com/not-an-olx-link',
        ]);

        $response->assertSessionHasErrors(['link']);
    }

    /**
     * Test validation failure when email is missing.
     */
    public function test_subscribe_fails_without_email(): void
    {
        $response = $this->post('/subscribe', [
            'link' => $this->validLink,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test validation failure when link is missing.
     */
    public function test_subscribe_fails_without_link(): void
    {
        $response = $this->post('/subscribe', [
            'email' => $this->validEmail,
        ]);

        $response->assertSessionHasErrors(['link']);
    }
}

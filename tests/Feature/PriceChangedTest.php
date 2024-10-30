<?php

namespace Tests\Feature;

use App\Mail\PriceChanged;
use Tests\TestCase;

class PriceChangedTest extends TestCase
{
    /**
     * Test that the email has the correct subject in the envelope.
     */
    public function test_envelope_has_correct_subject(): void
    {
        $mail = new PriceChanged('100 uah', '120 uah', 'https://www.olx.ua/d/uk/obyavlenie/test');

        $this->assertEquals('Price Changed!', $mail->envelope()->subject);
    }

    /**
     * Test that the email uses the correct view.
     */
    public function test_email_uses_correct_view(): void
    {
        $mail = new PriceChanged('100 uah', '120 uah', 'https://www.olx.ua/d/uk/obyavlenie/test');

        $this->assertEquals('mail.price.changed', $mail->content()->view);
    }

    /**
     * Test that the email passes the correct data to the view.
     */
    public function test_email_passes_correct_data_to_view(): void
    {
        $oldPrice = '100 uah';
        $newPrice = '120 uah';
        $link = 'https://www.olx.ua/d/uk/obyavlenie/test';

        $mailable = new PriceChanged($oldPrice, $newPrice, $link);
        $mailable->assertSeeInHtml($oldPrice);
        $mailable->assertSeeInHtml($newPrice);
        $mailable->assertSeeInHtml($link);
    }

    /**
     * Test that the email has no attachments.
     */
    public function test_email_has_no_attachments(): void
    {
        $mail = new PriceChanged('100 uah', '120 uah', 'https://www.olx.ua/d/uk/obyavlenie/test');

        $this->assertEmpty($mail->attachments());
    }
}

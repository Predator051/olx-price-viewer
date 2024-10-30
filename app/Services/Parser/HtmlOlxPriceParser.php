<?php

declare(strict_types=1);

namespace App\Services\Parser;

use App\Contracts\OlxPriceParser;
use Spatie\Browsershot\Browsershot;

class HtmlOlxPriceParser implements OlxPriceParser
{
    private function getHtmlPrice(string $url): string
    {
        $priceSelector = 'div[data-testid="ad-price-container"] h3';

        return Browsershot::url($url)
            ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox'])
            ->setChromePath('/usr/bin/google-chrome')
            ->timeout(60)
            ->waitForFunction(
                "
                () => {
                    const priceElement = document.querySelector('$priceSelector');
                    return priceElement && priceElement.innerText.trim() !== '';
                }
            "
            )
            ->evaluate("document.querySelector('$priceSelector').innerText");
    }

    public function parse(string $link): string
    {
        return trim($this->getHtmlPrice($link));
    }
}

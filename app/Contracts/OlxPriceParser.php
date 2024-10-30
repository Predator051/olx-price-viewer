<?php

namespace App\Contracts;

interface OlxPriceParser
{
    public function parse(string $link): string;
}

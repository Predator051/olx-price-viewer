<?php

namespace Tests;

use App\Contracts\OlxPriceParser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    protected function mockOlxPriceParser(string $returnValue, $expectLink = ''): void
    {
        $this->mock(
            OlxPriceParser::class,
            function (MockInterface $mock) use ($returnValue, $expectLink) {
                $mockExpectation = $mock->shouldReceive('parse')->once()->andReturn($returnValue);
                if (!empty($expectLink)) {
                    $mockExpectation->with($expectLink);
                }
            }
        );
    }
}

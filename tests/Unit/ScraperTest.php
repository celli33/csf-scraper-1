<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PhpCfdi\CsfScraper\Tests\Unit;

use GuzzleHttp\Client;
use PhpCfdi\CsfScraper\Scraper;
use PhpCfdi\CsfScraper\Tests\TestCase;
use ReflectionProperty;

final class ScraperTest extends TestCase
{
    public function test_create_with_specific_openssl_cipher_list(): void
    {
        /**
         * Problem: The scraper does not have a method to get the client, obtained by reflection
         */
        $scraper = Scraper::create();
        $property = new ReflectionProperty(Scraper::class, 'client');
        $property->setAccessible(true);
        /** @var Client $client */
        $client = $property->getValue($scraper);
        $this->assertInstanceOf(Client::class, $client);

        /**
         * Problem: The method getConfig is deprecated
         * @see Client::getConfig()
         */
        $this->assertSame(
            [CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1'],
            $client->getConfig('curl')
        );
    }
}

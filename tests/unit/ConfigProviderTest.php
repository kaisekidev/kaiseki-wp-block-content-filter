<?php

declare(strict_types=1);

namespace Kaiseki\Test\Unit\WordPress\BlockContentFilter;

use Kaiseki\WordPress\BlockContentFilter\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testConfig(): void
    {
        $config = (new ConfigProvider())();

        self::assertArrayHasKey('dependencies', $config);
        self::assertArrayHasKey('hook', $config);
    }
}

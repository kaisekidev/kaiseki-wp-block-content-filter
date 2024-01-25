<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'block_content_filter' => [
                'feature_notice' => 'wp-block-content-filter',
            ],
            'hook' => [
                'provider' => [
                    BlockContentFilterRegistry::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    BlockContentFilterRegistry::class    => BlockContentFilterRegistryFactory::class,
                ],
            ],
        ];
    }
}

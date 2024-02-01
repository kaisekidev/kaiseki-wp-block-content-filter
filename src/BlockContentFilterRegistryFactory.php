<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

use function array_map;

/**
 * @phpstan-type FilterPipeline list<BlockContentFilterInterface|class-string<BlockContentFilterInterface>>
 */
final class BlockContentFilterRegistryFactory
{
    public function __invoke(ContainerInterface $container): BlockContentFilterRegistry
    {
        return new BlockContentFilterRegistry(
            $this->getFilter($container)
        );
    }

    /**
     * @param ContainerInterface $container
     *
     * @return array<string, BlockContentFilterInterface>
     */
    public function getFilter(ContainerInterface $container): array
    {
        $config = Config::get($container);
        /** @var array<string, FilterPipeline> $filterSettings */
        $filterSettings = $config->array('block_content_filter', []);
        return array_map(
            fn (array $value): BlockContentFilterInterface
            => new BlockContentFilterPipeline(...Config::initClassMap($container, $value)),
            $filterSettings,
        );
    }
}

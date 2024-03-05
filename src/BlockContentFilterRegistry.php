<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_filter;
use function array_filter;
use function fnmatch;
use function is_string;

use const ARRAY_FILTER_USE_BOTH;

final class BlockContentFilterRegistry implements HookProviderInterface
{
    /**
     * @param array<string, BlockContentFilterInterface> $filter
     */
    public function __construct(private readonly array $filter)
    {
    }

    public function addHooks(): void
    {
        add_filter('render_block', [$this, 'updateBlock'], 20, 2);
    }

    /**
     * @param string       $blockContent
     * @param array<mixed> $block
     */
    public function updateBlock(string $blockContent, array $block): string
    {
        $blockName = $block['blockName'] ?? null;

        if (!is_string($blockName) || $blockName === '') {
            return $blockContent;
        }

        $filters = $this->getApplicableFilters($blockName);

        foreach ($filters as $filter) {
            $blockContent = ($filter)($blockContent, $block);
        }

        return $blockContent;
    }

    /**
     * @param string $blockName
     *
     * @return array<BlockContentFilterInterface>
     */
    private function getApplicableFilters(string $blockName): array
    {
        return array_filter(
            $this->filter,
            fn($filter, $key) => fnmatch($key, $blockName),
            ARRAY_FILTER_USE_BOTH
        );
    }
}

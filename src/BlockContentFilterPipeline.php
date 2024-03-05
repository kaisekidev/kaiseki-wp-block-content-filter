<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

final class BlockContentFilterPipeline implements BlockContentFilterInterface
{
    /** @var array<BlockContentFilterInterface> */
    private array $filter;

    public function __construct(BlockContentFilterInterface ...$filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(string $content, array $block): string
    {
        foreach ($this->filter as $filter) {
            $content = ($filter)($content, $block);
        }

        return $content;
    }
}

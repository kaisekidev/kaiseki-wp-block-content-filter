<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

interface BlockContentFilterInterface
{
    /**
     * @param string       $content
     * @param array<mixed> $block
     */
    public function __invoke(string $content, array $block): string;
}

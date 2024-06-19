<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter\Filter;

use Kaiseki\WordPress\BlockContentFilter\BlockContentFilterInterface;

use function sprintf;

final class CoreHtmlWrapFilter implements BlockContentFilterInterface
{
    /**
     * @param string $className
     */
    public function __construct(
        private readonly string $className = 'wp-block-html'
    ) {
    }

    public function __invoke(string $content, array $block): string
    {
        return sprintf(
            '<div class="%s">%s</div>',
            $this->className,
            $content
        );
    }
}

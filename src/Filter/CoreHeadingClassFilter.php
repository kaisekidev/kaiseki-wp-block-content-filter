<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter\Filter;

use Kaiseki\WordPress\BlockContentFilter\BlockContentFilterInterface;
use Kaiseki\WordPress\BlockContentFilter\Util\AddClassToOutermostElement;

final class CoreHeadingClassFilter implements BlockContentFilterInterface
{
    private AddClassToOutermostElement $util;

    /**
     * @param string       $className
     * @param list<string> $allowedHeadings
     */
    public function __construct(
        private readonly string $className = 'wp-block-heading',
        private readonly array $allowedHeadings = ['h2', 'h3', 'h4', 'h5', 'h6']
    ) {
        $this->util = new AddClassToOutermostElement();
    }

    public function __invoke(string $content, array $block): string
    {
        return $this->util->addClass($content, $this->className, $this->allowedHeadings);
    }
}

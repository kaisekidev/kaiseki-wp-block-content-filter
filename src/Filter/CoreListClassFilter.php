<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter\Filter;

use Kaiseki\WordPress\BlockContentFilter\BlockContentFilterInterface;
use Kaiseki\WordPress\BlockContentFilter\Util\AddClassToOutermostElement;

final class CoreListClassFilter implements BlockContentFilterInterface
{
    private AddClassToOutermostElement $util;

    public function __construct(private readonly string $className = 'wp-block-list')
    {
        $this->util = new AddClassToOutermostElement();
    }

    public function __invoke(string $content, array $block): string
    {
        return $this->util->addClass($content, $this->className, ['ul', 'ol']);
    }
}

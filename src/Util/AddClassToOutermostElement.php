<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter\Util;

use Masterminds\HTML5;

use function in_array;
use function trim;

final class AddClassToOutermostElement
{
    private HTML5 $html5;

    public function __construct()
    {
        $this->html5 = new HTML5();
    }

    /**
     * @param string       $content
     * @param string       $className
     * @param list<string> $tagNames
     */
    public function addClass(string $content, string $className, array $tagNames = []): string
    {
        if ($content === '') {
            return $content;
        }

        $document = $this->html5->loadHTMLFragment($content);
        $outermostElement = $document->firstElementChild;

        if (
            $outermostElement === null
            || (
                $tagNames !== []
                && !in_array($outermostElement->tagName, $tagNames, true)
            )
        ) {
            return $content;
        }

        $existingClass = $outermostElement->getAttribute('class');

        $outermostElement->setAttribute(
            'class',
            trim(trim($existingClass) . ' ' . trim($className))
        );

        $modifiedContent = $this->html5->saveHTML($document);

        return $modifiedContent;
    }
}

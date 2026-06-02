# kaiseki/wp-block-content-filter

Filter and transform WordPress block render output through a configurable pipeline of per-block
filters.

`BlockContentFilterRegistry` hooks into the `render_block` filter and, for each rendered block, runs
the filters whose block-name pattern matches the block's `blockName` (matched with `fnmatch`, so
`core/*` matches every core block). Each filter implements `BlockContentFilterInterface` and receives
the rendered HTML plus the block's data, returning the (possibly transformed) HTML.

The package ships a few ready-made filters:

- **`CoreParagraphClassFilter` / `CoreHeadingClassFilter` / `CoreListClassFilter`** — add a CSS class
  to the outermost element of the rendered block.
- **`CoreHtmlWrapFilter`** — wrap the rendered block in a `<div class="…">`.
- **`DisableFullscreenMode`** — a standalone hook provider that turns off the block editor's
  fullscreen mode.

## Installation

```bash
composer require kaiseki/wp-block-content-filter
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator, then declare a
`block_content_filter` map of `fnmatch` block-name patterns to a list of filter class-strings (or
instances). `ConfigProvider` already wires `BlockContentFilterRegistry` into `hook.provider`, so the
registry runs automatically once `ConfigProvider` is registered — you only need to supply the filter
map (do **not** add `BlockContentFilterRegistry` to `hook.provider` yourself, or it will be registered
twice and the pipeline will run twice):

```php
use Kaiseki\WordPress\BlockContentFilter\Filter\CoreHeadingClassFilter;
use Kaiseki\WordPress\BlockContentFilter\Filter\CoreParagraphClassFilter;

return [
    'block_content_filter' => [
        // Each key is an fnmatch pattern matched against the block's blockName.
        // Each value is a list of BlockContentFilterInterface class-strings (or
        // instances) run as a pipeline over the rendered block HTML.
        'core/paragraph' => [
            CoreParagraphClassFilter::class,
        ],
        'core/heading' => [
            CoreHeadingClassFilter::class,
        ],
    ],
];
```

Each filter class-string is resolved through the container (`Config::initClassMap`), so a filter that
needs constructor arguments can be registered as a container service; the bundled filters work out of
the box with sensible defaults.

The standalone `DisableFullscreenMode` provider is **not** registered by `ConfigProvider` — opt into it
explicitly by adding it to your own `hook.provider` list:

```php
use Kaiseki\WordPress\BlockContentFilter\DisableFullscreenMode;

return [
    'hook' => [
        'provider' => [
            DisableFullscreenMode::class,
        ],
    ],
];
```

Write your own filter by implementing `BlockContentFilterInterface`:

```php
use Kaiseki\WordPress\BlockContentFilter\BlockContentFilterInterface;

final class MyFilter implements BlockContentFilterInterface
{
    /**
     * @param array<mixed> $block
     */
    public function __invoke(string $content, array $block): string
    {
        return $content . '<!-- filtered -->';
    }
}
```

## Development

```bash
composer install
composer check    # check-deps, cs-check, phpstan
composer phpunit
```

## License

MIT — see [LICENSE](LICENSE).

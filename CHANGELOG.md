# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `BlockContentFilterRegistry` — hooks `render_block` and runs the configured filter pipeline for each
  block whose name matches an `fnmatch` pattern (config `block_content_filter`).
- `BlockContentFilterPipeline` and the `BlockContentFilterInterface` contract for composing filters.
- Bundled filters: `CoreParagraphClassFilter`, `CoreHeadingClassFilter`, `CoreListClassFilter` (add a
  CSS class to the outermost element), `CoreHtmlWrapFilter` (wrap the block in a `<div>`), and the
  `AddClassToOutermostElement` HTML5 utility.
- `DisableFullscreenMode` hook provider — disables the block editor fullscreen mode.
- `ConfigProvider` wiring the registry factory.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2 at level max, PHPUnit 11 schema, composer-require-checker 4);
  now depends on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config`
  and `kaiseki/wp-hook` pinned to `^2.0`; `masterminds/html5` to `^2.10`. CI now runs via the reusable
  workflow in `kaisekidev/.github`.

### Fixed

- `license` corrected to `MIT` (the `LICENSE` file was already MIT; `composer.json` said `proprietary`)
  and a `description` was added.

### Known limitations

- Line coverage is ~19% (only `ConfigProvider` is directly tested). The CI coverage gate is set to a
  `19` regression floor; ratchet back to 100 as filter/registry tests are added.

<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\BlockContentFilter;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

final class DisableFullscreenMode implements HookCallbackProviderInterface
{
    public function registerHookCallbacks(): void
    {
        add_action('enqueue_block_editor_assets', [$this, 'disableFullScreenEditor']);
    }

    public function disableFullScreenEditor(): void
    {
        $script = <<<JS
jQuery( window ).load(function() {
    const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );
    if ( isFullscreenMode ) {
        wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' );
    }
});
JS;
        wp_add_inline_script('wp-blocks', $script);
    }
}

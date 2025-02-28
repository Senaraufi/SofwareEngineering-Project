<?php

namespace App;

class Controller {
    protected function render($template, $data = []) {
        return [
            'template' => $template,
            'data' => array_merge($data, [
                'cart_count' => $this->getCartCount(),
                'current_track' => $this->getCurrentTrack()
            ])
        ];
    }

    protected function getCartCount() {
        // TODO: Implement cart functionality
        return 3;
    }

    protected function getCurrentTrack() {
        // TODO: Implement music player functionality
        return [
            'title' => 'Sample Track',
            'artist' => 'Sample Artist'
        ];
    }
}

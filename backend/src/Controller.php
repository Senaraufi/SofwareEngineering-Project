<?php

namespace App;

class Controller {
    protected function render($template, $data = []) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $defaultData = [
            'cart_count' => $this->getCartCount(),
            'current_track' => $this->getCurrentTrack(),
            'is_logged_in' => isset($_SESSION['Active']) && $_SESSION['Active'] === true,
            'user_initials' => isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 1)) : 'U'
        ];

        return [
            'template' => $template,
            'data' => array_merge($defaultData, $data)
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

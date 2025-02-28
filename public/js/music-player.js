/**
 * Music Player Toggle Functionality
 *
 * References:
 * - DOM manipulation: https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model
 * - LocalStorage usage: https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage
 * - Event handling: https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
 * - classList API: https://developer.mozilla.org/en-US/docs/Web/API/Element/classList
 * 
 * Works with:
 * - footer.html.twig: Contains the music player HTML structure
 * - style.css: Defines the collapsed/expanded states and animations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get references to elements defined in footer.html.twig
    const musicPlayer = document.getElementById('musicPlayer');
    const toggleButton = document.getElementById('togglePlayer');
    
    // Load the saved state from localStorage
    // This works with the 'collapsed' class defined in style.css
    const isCollapsed = localStorage.getItem('musicPlayerCollapsed') === 'true';
    if (isCollapsed) {
        musicPlayer.classList.add('collapsed'); // Triggers CSS transform
    }

    // Handle toggle button clicks (button defined in footer.html.twig)
    toggleButton.addEventListener('click', function() {
        musicPlayer.classList.toggle('collapsed');
        
        // Save the state to localStorage
        localStorage.setItem(
            'musicPlayerCollapsed', 
            musicPlayer.classList.contains('collapsed')
        );
    });
});

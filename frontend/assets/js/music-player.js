class MusicPlayer {
    constructor() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }

    init() {
        this.initializeElements();
        this.initializeAudio();
        this.setupEventListeners();
        this.setupPlayerToggle();
    }

    initializeElements() {
        // Main container
        this.container = document.getElementById('musicPlayer');
        if (this.container) {
            // Set initial state - hidden by default
            this.container.style.display = 'block';
            this.container.style.visibility = 'hidden';
            this.container.style.opacity = '0';
            this.container.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out';
            this.container.style.transform = 'translateY(100%)';
        }
        
        // Playback controls
        this.playButton = document.querySelector('.play-button');
        this.prevButton = document.querySelector('.prev-button');
        this.nextButton = document.querySelector('.next-button');
        
        // Progress bar
        this.progressContainer = document.querySelector('.track-progress');
        this.progressBar = document.querySelector('.track-progress-bar');

        // Toggle button (assuming you have a button with this class somewhere in your HTML)
        this.toggleButton = document.querySelector('.player-toggle-button');
    }

    initializeAudio() {
        this.audio = new Audio();
        this.isPlaying = false;
        
        // Sample track (replace with your actual track)
        this.currentTrack = {
            url: '/audio/sample.mp3'
        };
        
        // Set initial volume
        const savedVolume = localStorage.getItem('musicPlayerVolume');
        this.audio.volume = savedVolume ? parseFloat(savedVolume) : 0.7;
    }

    setupEventListeners() {
        if (!this.container) return;

        // Playback controls
        this.playButton?.addEventListener('click', () => this.togglePlayback());
        this.prevButton?.addEventListener('click', () => this.previousTrack());
        this.nextButton?.addEventListener('click', () => this.nextTrack());

        // Progress bar
        this.progressContainer?.addEventListener('click', (e) => this.seek(e));

        // Audio events
        this.audio.addEventListener('timeupdate', () => this.updateProgress());
        this.audio.addEventListener('ended', () => this.onTrackEnd());
    }

    setupPlayerToggle() {
        // Add toggle button event listener
        this.toggleButton?.addEventListener('click', () => this.togglePlayer());

        // Add keyboard shortcut (Space bar)
        document.addEventListener('keydown', (e) => {
            if (e.code === 'KeyP' && e.altKey) {  // Alt + P to toggle player
                e.preventDefault();
                this.togglePlayer();
            }
        });
    }

    togglePlayer() {
        if (!this.container) return;

        const isVisible = this.container.style.visibility === 'visible';
        
        if (isVisible) {
            // Hide player
            this.container.style.opacity = '0';
            this.container.style.transform = 'translateY(100%)';
            setTimeout(() => {
                this.container.style.visibility = 'hidden';
            }, 300); // Match the transition duration
        } else {
            // Show player
            this.container.style.visibility = 'visible';
            setTimeout(() => {
                this.container.style.opacity = '1';
                this.container.style.transform = 'translateY(0)';
            }, 10); // Small delay to ensure visibility is applied first
        }
    }

    togglePlayback() {
        if (!this.audio) return;

        if (this.audio.paused) {
            this.audio.play();
            this.isPlaying = true;
            this.updatePlayButton();
        } else {
            this.audio.pause();
            this.isPlaying = false;
            this.updatePlayButton();
        }
    }

    updatePlayButton() {
        if (!this.playButton) return;

        if (this.isPlaying) {
            this.playButton.innerHTML = `
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <rect x="6" y="4" width="4" height="16"></rect>
                    <rect x="14" y="4" width="4" height="16"></rect>
                </svg>`;
        } else {
            this.playButton.innerHTML = `
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5V19L19 12L8 5Z"></path>
                </svg>`;
        }
    }

    updateProgress() {
        if (!this.progressBar || !this.audio.duration) return;
        const progress = (this.audio.currentTime / this.audio.duration) * 100;
        this.progressBar.style.width = `${progress}%`;
    }

    seek(e) {
        if (!this.progressContainer || !this.audio.duration) return;
        const clickPosition = (e.pageX - this.progressContainer.offsetLeft) / this.progressContainer.offsetWidth;
        this.audio.currentTime = clickPosition * this.audio.duration;
    }

    previousTrack() {
        console.log('Previous track');
    }

    nextTrack() {
        console.log('Next track');
    }

    onTrackEnd() {
        this.isPlaying = false;
        this.updatePlayButton();
    }

    seek(event) {
        if (!this.progressContainer || !this.audio?.duration) return;
        
        try {
            const rect = this.progressContainer.getBoundingClientRect();
            const percent = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
            this.audio.currentTime = percent * this.audio.duration;
            this.updateProgress();
        } catch (error) {
            console.error('Error seeking:', error);
        }
    }

    previousTrack() {
        if (!this.audio) return;
        
        if (this.audio.currentTime > 3) {
            // If more than 3 seconds into the song, restart it
            this.audio.currentTime = 0;
        } else {
            // Otherwise, load previous track (placeholder for now)
            this.audio.currentTime = 0;
        }
        
        if (this.isPlaying) {
            this.audio.play().catch(error => {
                console.error('Error playing track:', error);
                this.isPlaying = false;
                this.updatePlayButton();
            });
        }
        this.updateProgress();
    }

    nextTrack() {
        if (!this.audio) return;
        
        // Reset track position
        this.audio.currentTime = 0;
        
        // Placeholder for loading next track
        if (this.isPlaying) {
            this.audio.play().catch(error => {
                console.error('Error playing track:', error);
                this.isPlaying = false;
                this.updatePlayButton();
            });
        }
        this.updateProgress();
    }

    onTrackEnd() {
        this.isPlaying = false;
        this.updatePlayButton();
        this.updateProgress();
        // Auto-play next track
        this.nextTrack();
        if (this.audio) {
            this.audio.play().catch(() => {
                // Silently handle auto-play errors
                this.isPlaying = false;
                this.updatePlayButton();
            });
        }
    }
}

// Initialize the music player
const player = new MusicPlayer();

// Export the player instance for global access if needed
window.musicPlayer = player;

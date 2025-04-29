/**
 * Client-side form validation
 * 
 * This script provides client-side validation for forms in the TalkTempo application
 * It validates input fields before form submission and provides immediate feedback
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all forms with the 'needs-validation' class
    const forms = document.querySelectorAll('.needs-validation');
    
    // Loop over them and prevent submission if validation fails
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Username validation
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            const username = this.value;
            const usernameError = document.getElementById('username-error');
            
            if (username.length < 3) {
                this.setCustomValidity('Username must be at least 3 characters');
                if (usernameError) usernameError.textContent = 'Username must be at least 3 characters';
            } else if (username.length > 50) {
                this.setCustomValidity('Username must be less than 50 characters');
                if (usernameError) usernameError.textContent = 'Username must be less than 50 characters';
            } else {
                this.setCustomValidity('');
                if (usernameError) usernameError.textContent = '';
            }
        });
    }
    
    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email)) {
                this.setCustomValidity('Please enter a valid email address');
                if (emailError) emailError.textContent = 'Please enter a valid email address';
            } else {
                this.setCustomValidity('');
                if (emailError) emailError.textContent = '';
            }
        });
    }
    
    // Password validation
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const passwordError = document.getElementById('password-error');
            
            if (password.length < 8) {
                this.setCustomValidity('Password must be at least 8 characters');
                if (passwordError) passwordError.textContent = 'Password must be at least 8 characters';
            } else {
                this.setCustomValidity('');
                if (passwordError) passwordError.textContent = '';
            }
        });
    }
    
    // Confirm password validation
    const confirmPasswordInput = document.getElementById('confirm_password');
    if (confirmPasswordInput && passwordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const confirmPassword = this.value;
            const password = passwordInput.value;
            const confirmPasswordError = document.getElementById('confirm-password-error');
            
            if (confirmPassword !== password) {
                this.setCustomValidity('Passwords do not match');
                if (confirmPasswordError) confirmPasswordError.textContent = 'Passwords do not match';
            } else {
                this.setCustomValidity('');
                if (confirmPasswordError) confirmPasswordError.textContent = '';
            }
        });
    }
});

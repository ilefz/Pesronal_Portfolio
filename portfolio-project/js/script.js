document.addEventListener('DOMContentLoaded', function() {

    // --- Mobile Menu Toggle ---
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('#primary-menu');

    if (menuToggle && primaryMenu) {
        menuToggle.addEventListener('click', function() {
            const expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
            menuToggle.setAttribute('aria-expanded', !expanded);
            primaryMenu.classList.toggle('toggled');
            // Optional: Change hamburger icon to 'X' when open
            // menuToggle.innerHTML = expanded ? '☰' : '✕';
        });

        // Close menu if clicking outside of it (on mobile)
        document.addEventListener('click', function(event) {
            const isClickInsideNav = primaryMenu.contains(event.target);
            const isClickOnToggle = menuToggle.contains(event.target);

            if (!isClickInsideNav && !isClickOnToggle && primaryMenu.classList.contains('toggled')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                primaryMenu.classList.remove('toggled');
                // menuToggle.innerHTML = '☰'; // Reset icon
            }
        });
    }

    // --- Simple Client-Side Form Validation Hint ---
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            let isValid = true;
            const requiredFields = contactForm.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red'; // Basic visual hint
                    // You could add more specific error messages near fields
                } else {
                    field.style.borderColor = ''; // Reset border color if valid
                }
            });

             // Check email format specifically
             const emailField = contactForm.querySelector('input[type="email"][required]');
             if (emailField && emailField.value.trim() && !validateEmail(emailField.value.trim())) {
                 isValid = false;
                 emailField.style.borderColor = 'red';
                 // Consider adding an error message element
             }

            if (!isValid) {
                event.preventDefault(); // Stop form submission
                // Optionally, scroll to the first invalid field or show a general message
                alert('Please fill out all required fields correctly.'); // Simple alert
            }
        });

        // Reset border color on input
        contactForm.querySelectorAll('[required]').forEach(field => {
            field.addEventListener('input', function() {
                if (field.style.borderColor === 'red') {
                    field.style.borderColor = '';
                }
            });
        });
    }

    // --- Add subtle fade-in animation on scroll (Optional) ---
    const fadeElements = document.querySelectorAll('.featured-projects, .quick-intro, .skills, .portfolio-item, .resume-section, .contact-form');

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = `fadeInUp 1s ease-out forwards`;
                    observer.unobserve(entry.target); // Stop observing once animated
                }
            });
        }, { threshold: 0.1 }); // Trigger when 10% visible

        fadeElements.forEach(el => {
            el.style.opacity = '0'; // Initially hide elements
            el.style.transform = 'translateY(20px)'; // Start slightly lower
            observer.observe(el);
        });

        // Add CSS for the animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

    } else {
        // Fallback for older browsers (just make elements visible)
        fadeElements.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });
    }

}); // End DOMContentLoaded

// Helper function for email validation
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
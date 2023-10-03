document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll('.section');
    const footerLinks = document.querySelectorAll('.footer-links a');

    footerLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default link behavior

            const target = link.getAttribute('href'); // Get the target section ID
            sections.forEach(section => {
                section.style.display = 'none'; // Hide all sections
            });

            document.querySelector(target).style.display = 'block'; // Display the target section
        });
    });
});

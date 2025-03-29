// Admin Dashboard Interactions
document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const menuButton = document.getElementById('admin-menu-button');
    const mobileMenu = document.getElementById('admin-mobile-menu');
    
    if(menuButton) {
        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Confirm before dangerous actions
    document.querySelectorAll('.confirm-action').forEach(button => {
        button.addEventListener('click', function(e) {
            if(!confirm('Are you sure you want to perform this action?')) {
                e.preventDefault();
            }
        });
    });

    // Chart initialization (example using Chart.js)
    if(document.getElementById('salesChart')) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [1200, 1900, 1500, 2000, 2300],
                    borderColor: '#3b82f6',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true
            }
        });
    }
});
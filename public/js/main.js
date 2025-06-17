document.addEventListener('DOMContentLoaded', function() {
    // AJAX for Admin: Toggle Sarkari HR
    const userTable = document.querySelector('.data-table');
    if (userTable) {
        userTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('toggle-sarkari-hr')) {
                const button = e.target;
                const userId = button.dataset.userid;
                if (!confirm('Are you sure you want to change this HR\'s permission?')) {
                    return;
                }

                const formData = new FormData();
                formData.append('user_id', userId);

                fetch('/ajax/admin_toggle_sarkari_hr.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        button.textContent = data.new_status_text;
                        const statusCell = button.closest('tr').querySelector('td:nth-child(4)');
                        statusCell.textContent = data.new_status_text.startsWith('Revoke') ? 'Yes' : 'No';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('An unexpected error occurred.');
                });
            }
        });
    }
});

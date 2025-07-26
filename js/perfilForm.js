document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('edit-form');
    const editButton = document.querySelector('.profile-actions button');

    if (editButton && editForm) {
        editButton.addEventListener('click', function() {
            if (editForm.style.display === 'block') {
                editForm.style.display = 'none';
            } else {
                editForm.style.display = 'block';
            }
        });
    }
});

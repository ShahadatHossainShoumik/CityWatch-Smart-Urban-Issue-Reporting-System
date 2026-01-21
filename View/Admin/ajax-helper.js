/**
 * AJAX Helper Functions for Admin Dashboard
 * Handles all AJAX operations with error handling
 */

// Show notification message
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        z-index: 9999;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-in;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Generic AJAX delete function
function ajaxDelete(id, action, containerSelector) {
    if(!confirm('Are you sure you want to delete this item?')) return;
    
    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    formData.append('ajax', '1');
    
    fetch('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Remove the row from the table
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if(row) {
                row.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => row.remove(), 300);
            }
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// Generic AJAX block/unblock function
function ajaxToggleBlockUser(id, action) {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    formData.append('ajax', '1');
    
    fetch('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Update the button and status
            const button = document.querySelector(`button[data-user-id="${id}"]`);
            if(button) {
                if(action === 'block_user') {
                    button.textContent = 'Unblock';
                    button.onclick = function() { ajaxToggleBlockUser(id, 'unblock_user'); };
                    button.style.backgroundColor = '#4CAF50';
                } else {
                    button.textContent = 'Block';
                    button.onclick = function() { ajaxToggleBlockUser(id, 'block_user'); };
                    button.style.backgroundColor = '#f44336';
                }
            }
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// AJAX edit form submission
function ajaxSubmitEditForm(formId, action) {
    const form = document.getElementById(formId);
    if(!form) return;
    
    const formData = new FormData(form);
    formData.append('action', action);
    formData.append('ajax', '1');
    
    fetch('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification(data.message, 'success');
            // Close the edit form
            const closeBtn = form.closest('.form-container').querySelector('.btn-cancel');
            if(closeBtn) closeBtn.click();
            // Optionally reload the table
            setTimeout(() => location.reload(), 500);
        } else {
            showNotification(data.message || 'Error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// AJAX add form submission
function ajaxSubmitAddForm(formId, action) {
    const form = document.getElementById(formId);
    if(!form) return;
    
    const formData = new FormData(form);
    formData.append('action', action);
    formData.append('ajax', '1');
    
    fetch('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification(data.message, 'success');
            form.reset();
            // Close the add form
            const closeBtn = form.closest('.form-container').querySelector('.btn-cancel');
            if(closeBtn) closeBtn.click();
            // Reload the table after short delay
            setTimeout(() => location.reload(), 500);
        } else {
            showNotification(data.message || 'Error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// CSS for fade out animation
const fadeStyle = document.createElement('style');
fadeStyle.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(fadeStyle);

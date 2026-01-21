//notification handeling function
// Function: showNotification(message, type)
// Displays a notification message on the screen
// Parameters: message (string), type ('success' or 'error')
// Usage: showNotification('Item deleted successfully', 'success');
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
    // Auto-remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations for notifications
(function injectNotificationStyles() {
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
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
})();

// Function: fetchJson(url, options)
// Unified fetch wrapper with error handling
// Returns: Promise with {ok: boolean, data: parsed JSON or empty object}
// Handles: Network errors, JSON parse errors, HTTP status codes
// Usage: Recommended over raw fetch() for all AJAX calls
function fetchJson(url, options) {
    return fetch(url, options)
        .then(response => response
            .json()
            .catch(() => ({}))
            .then(data => ({ ok: response.ok, data }))
        );
}

// Function: ajaxDelete(id, action)
// Deletes item via AJAX after user confirmation
// Parameters: id (item ID), action (delete_citizen, delete_authority, etc.)
// Returns: void (updates DOM or shows notification on success)
// Safety: Requires user confirmation before deletion
function ajaxDelete(id, action) {
    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }

    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    formData.append('ajax', '1');
    // Send AJAX request
    fetchJson('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
        .then(({ ok, data }) => {
            if (ok && data.success) {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => row.remove(), 300);
                }
                showNotification(data.message, 'success');
            } else {
                showNotification((data && data.message) || 'Error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error: ' + error.message, 'error');
        });
}
// Function: ajaxToggleBlockUser(id, action)
// Toggles block/unblock user via AJAX
// Parameters: id (user ID), action ('block_user' or 'unblock_user')
// Returns: void (updates button text and style on success)
function ajaxToggleBlockUser(id, action) {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('id', id);
    formData.append('ajax', '1');

    fetchJson('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
        .then(({ ok, data }) => {
            if (ok && data.success) {
                const button = document.querySelector(`button[data-user-id="${id}"]`);
                if (button) {
                    if (action === 'block_user') {
                        button.textContent = 'Unblock';
                        button.onclick = function () { ajaxToggleBlockUser(id, 'unblock_user'); };
                        button.style.backgroundColor = '#4CAF50';
                    } else {
                        button.textContent = 'Block';
                        button.onclick = function () { ajaxToggleBlockUser(id, 'block_user'); };
                        button.style.backgroundColor = '#f44336';
                    }
                }
                showNotification(data.message, 'success');
            } else {
                showNotification((data && data.message) || 'Error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error: ' + error.message, 'error');
        });
}
// Function: ajaxSubmitEditForm(formId, action)
// Submits edit form via AJAX
// Parameters: formId (ID of the form), action (edit_citizen, edit_authority, etc.)
// Returns: void (shows notification and reloads page on success)
function ajaxSubmitEditForm(formId, action) {
    const form = document.getElementById(formId);
    if (!form) {
        return;
    }

    const formData = new FormData(form);
    formData.append('action', action);
    formData.append('ajax', '1');
    // Send AJAX request
    fetchJson('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
        .then(({ ok, data }) => {
            if (ok && data.success) {
                showNotification(data.message, 'success');
                const closeBtn = form.closest('.form-container')?.querySelector('.btn-cancel');
                if (closeBtn) {
                    closeBtn.click();
                }
                setTimeout(() => location.reload(), 500);
            } else {
                showNotification((data && data.message) || 'Error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error: ' + error.message, 'error');
        });
}
// Function: ajaxSubmitAddForm(formId, action)
// Submits add form via AJAX
// Parameters: formId (ID of the form), action (add_citizen, add_authority, etc.)
// Returns: void (shows notification, resets form, and reloads page on success)
function ajaxSubmitAddForm(formId, action) {
    const form = document.getElementById(formId);
    if (!form) {
        return;
    }

    const formData = new FormData(form);
    formData.append('action', action);
    formData.append('ajax', '1');
    // Send AJAX request
    fetchJson('../../Controller/AdminController.php', {
        method: 'POST',
        body: formData
    })
        .then(({ ok, data }) => {
            if (ok && data.success) {
                showNotification(data.message, 'success');
                form.reset();
                const closeBtn = form.closest('.form-container')?.querySelector('.btn-cancel');
                if (closeBtn) {
                    closeBtn.click();
                }
                setTimeout(() => location.reload(), 500);
            } else {
                showNotification((data && data.message) || 'Error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error: ' + error.message, 'error');
        });
}

// User Preferences Management
// Functions to save and retrieve user preferences using cookies
// Prefix all cookies with 'citywatch_' to avoid conflicts
function savePref(key, value, days = 7) {
    const expiry = new Date();
    expiry.setTime(expiry.getTime() + days * 24 * 60 * 60 * 1000);
    const expiryString = 'expires=' + expiry.toUTCString();
    document.cookie = `citywatch_${key}=${value};${expiryString};path=/;SameSite=Lax`;
}
// Retrieve preference value by key, return defaultValue if not found
function getPref(key, defaultValue = '') {
    const name = `citywatch_${key}=`;
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    // Search for the cookie
    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return defaultValue;
}
// Specific preference functions
function saveSearchPref(searchTerm) {
    if (searchTerm) {
        savePref('last_search', encodeURIComponent(searchTerm));
    }
}
// Retrieve last search preference
function saveSortPref(sortBy) {
    savePref('sort_by', sortBy);
}
// Retrieve sort preference
function saveViewPref(viewType) {
    savePref('view_type', viewType);
}

function savePaginationPref(currentPage) {
    savePref('current_page', currentPage);
}
// Retrieve view preference
function getLastPage() {
    return getPref('current_page', '1');
}

function saveFilterPref(filterType, filterValue) {
    savePref(`filter_${filterType}`, filterValue);
}

// Retrieve filter preferences
function getFilters() {
    const filters = {};
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');

    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.indexOf('citywatch_filter_') === 0) {
            const [key, value] = cookie.split('=');
            filters[key.replace('citywatch_filter_', '')] = value;
        }
    }
    return filters;
}
// Clear all saved preferences
function clearAllPrefs() {
    const keys = ['last_search', 'sort_by', 'view_type', 'current_page'];
    keys.forEach(key => {
        savePref(key, '', -1);
    });

    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');

    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.indexOf('citywatch_filter_') === 0) {
            const key = cookie.split('=')[0];
            document.cookie = `${key}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;SameSite=Lax`;
        }
    }

    showNotification('Preferences cleared successfully', 'success');
}

// Apply saved preferences on load
(function applyPrefsOnLoad() {
    document.addEventListener('DOMContentLoaded', function () {
        const lastSearch = getPref('last_search', '');
        if (lastSearch) {
            const searchInput =
                document.querySelector('input[placeholder*="Search"]') ||
                document.querySelector('input[type="text"]');
            if (searchInput) {
                searchInput.value = decodeURIComponent(lastSearch);
            }
        }
        // Apply sort preference
        const sortPref = getPref('sort_by', '');
        if (sortPref) {
            const sortSelect = document.querySelector('select[name="sort_by"]');
            if (sortSelect) {
                sortSelect.value = sortPref;
            }
        }
        // Apply view preference
        const viewPref = getPref('view_type', 'list');
        if (viewPref === 'grid') {
            const viewToggle = document.querySelector('[data-view-toggle]');
            if (viewToggle && typeof applyGridView === 'function') {
                applyGridView();
            }
        }
    });
})();

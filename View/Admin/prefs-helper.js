/**
 * Admin Dashboard Preferences using Cookies
 * Stores user preferences like sorting, filtering, view type
 */

// Save preference to cookie
function savePref(key, value, days = 30) {
    const expiry = new Date();
    expiry.setTime(expiry.getTime() + (days * 24 * 60 * 60 * 1000));
    const expiryString = "expires=" + expiry.toUTCString();
    document.cookie = `citywatch_${key}=${value};${expiryString};path=/;SameSite=Lax`;
}

// Get preference from cookie
function getPref(key, defaultValue = '') {
    const name = `citywatch_${key}=`;
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    
    for(let cookie of cookies) {
        cookie = cookie.trim();
        if(cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return defaultValue;
}

// Save search/filter preferences
function saveSearchPref(searchTerm) {
    if(searchTerm) {
        savePref('last_search', encodeURIComponent(searchTerm));
    }
}

// Save sort preferences
function saveSortPref(sortBy) {
    savePref('sort_by', sortBy);
}

// Save view type preference (list or grid)
function saveViewPref(viewType) {
    savePref('view_type', viewType); // 'list' or 'grid'
}

// Load and apply preferences when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Apply saved search preference
    const lastSearch = getPref('last_search', '');
    if(lastSearch) {
        const searchInput = document.querySelector('input[placeholder*="Search"]') || 
                          document.querySelector('input[type="text"]');
        if(searchInput) {
            searchInput.value = decodeURIComponent(lastSearch);
        }
    }
    
    // Apply saved sort preference
    const sortPref = getPref('sort_by', '');
    if(sortPref) {
        const sortSelect = document.querySelector('select[name="sort_by"]');
        if(sortSelect) {
            sortSelect.value = sortPref;
        }
    }
    
    // Apply saved view preference
    const viewPref = getPref('view_type', 'list');
    if(viewPref === 'grid') {
        // Toggle to grid view if user prefers it
        const viewToggle = document.querySelector('[data-view-toggle]');
        if(viewToggle) {
            applyGridView();
        }
    }
});

// Save pagination preference
function savePaginationPref(currentPage) {
    savePref('current_page', currentPage);
}

// Get last visited page
function getLastPage() {
    return getPref('current_page', '1');
}

// Save filter preferences for dashboard
function saveFilterPref(filterType, filterValue) {
    savePref(`filter_${filterType}`, filterValue);
}

// Get all saved filters
function getFilters() {
    const filters = {};
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    
    for(let cookie of cookies) {
        cookie = cookie.trim();
        if(cookie.indexOf('citywatch_filter_') === 0) {
            const [key, value] = cookie.split('=');
            filters[key.replace('citywatch_filter_', '')] = value;
        }
    }
    return filters;
}

// Clear all admin preferences
function clearAllPrefs() {
    const keys = ['last_search', 'sort_by', 'view_type', 'current_page'];
    keys.forEach(key => {
        savePref(key, '', -1); // Negative days to delete
    });
    
    // Clear all filters
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    
    for(let cookie of cookies) {
        cookie = cookie.trim();
        if(cookie.indexOf('citywatch_filter_') === 0) {
            const key = cookie.split('=')[0];
            document.cookie = `${key}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
        }
    }
    
    showNotification('Preferences cleared successfully', 'success');
}

// Send POST request
function params(request_type, data) {
    return {
        method: request_type,
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: data
    }
}

function ftch(request_type, target_link, data) {
    fetch(window.location.origin + target_link, params(request_type, data))
}

// Reload window
function reload_page() {
    location.reload()
}

// Update style without reload
function noReloadChangeTheme() {
    var sheet;
    var theme = document.getElementById("pagestyle").getAttribute("href");
    if (theme == '/css/library/bootstrap-night.min.css') {
        sheet = '/css/library/bootstrap.min.css';
    } else {
        sheet = '/css/library/bootstrap-night.min.css';
    };
    document.getElementById("pagestyle").setAttribute("href", sheet);
}

// Change Theme
function changeTheme() {
    noReloadChangeTheme()
    document.getElementById("themeToggle").disabled = true;
    setTimeout(function () { document.getElementById("themeToggle").disabled = false; }, 250);
    ftch('PATCH', '/api/user_api.php', {"theme": true})
}
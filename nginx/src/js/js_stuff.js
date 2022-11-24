
function params(param) {
    return {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: param
    }
}

function ftch(param) {
    fetch(window.location.origin + '/api/settings.php', params(param))
}

function reload() {
    location.reload()
}

function noReloadChangeTheme() {
    var sheet;
    var theme = document.getElementById("pagestyle").getAttribute("href");
    if (theme == '/css/dark.css') {
        sheet = '/css/light.css';
    } else {
        sheet = '/css/dark.css';
    };
    document.getElementById("pagestyle").setAttribute("href", sheet);
}

// Change Theme
function changeTheme() {
    noReloadChangeTheme()
    document.getElementById("themeToggle").disabled = true;
    setTimeout(function () { document.getElementById("themeToggle").disabled = false; }, 250);
    ftch('action=theme')
}
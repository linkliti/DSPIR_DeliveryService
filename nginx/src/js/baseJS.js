// Send POST request
function params(request_type, data) {
    return {
        method: request_type,
        headers: { 'Content-Type': 'application/json' },
        body: data
    }
}
function params_result() {
    return {
        method: "GET",
        headers: { 'Content-Type': 'application/json' },
    }
}

async function ftch(request_type, target_link, data) {
    if (request_type === "GET") {
        var link = window.location.origin + target_link + "?" + new URLSearchParams(JSON.parse(data));
        var response = await fetch(link, params_result());
    } else {
        var link = window.location.origin + target_link;
        var response = await fetch(link, params(request_type, data));
    }
    if (response.ok) {
        var json = await response;
        return json.json();
    } else {
        var json = {"status": 2, "message": "Не удалось отправить запрос"};
        return json;
    }
}

function toggleFormButtons(bool_param) {
    var buttons = document.getElementsByClassName('formBTN')
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = bool_param;
    }
}

function displayError(id, msg = '') {
    var field = document.getElementById(id);
    if (msg) {
        field.innerHTML = '<span class="fw-bold text-danger">Ошибка: </span> ' + msg;
    } else {
        field.innerHTML = 'Отправка запроса...';
    }
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
    ftch('PATCH', '/api/user_api.php', '{"theme": true}')
}

// Cover string with commas
function wrap($str) {
    return '"' + $str + '"';
}
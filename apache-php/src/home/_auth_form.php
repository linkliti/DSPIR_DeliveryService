<script type="text/javascript">
    window.addEventListener("DOMContentLoaded", function () {
        document.getElementById('authForm').addEventListener("submit", function (e) {
            e.preventDefault();
            sendAuth();
        })
    });
    async function sendAuth() {
        var form = document.getElementById('authForm');
        var data = {};
        data["data"] = {};
        data["data"]["login"] = form.elements.login.value;
        data["data"]["pass"] = form.elements.pass.value;
        str_data = JSON.stringify(data);
        displayError('StatusMSGAuth');
        toggleFormButtons(true);
        var response = await ftch('POST', '/api/user_api.php', str_data);
        toggleFormButtons(false);
        if (response["status"] != 0) {
            displayError('StatusMSGAuth', response["message"]);
        } else {
            window.location.href = '/home/home.php'
        }
    }
</script>

<div class="modal-header p-5 pb-4 border-bottom-0">
    <h1 class="fw-bold mb-0 fs-2">Авторизация</h1>
    <?php if (!(currentFile() == 'auth.php')) {
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    }
    ?>
</div>

<div class="modal-body p-5 pt-0">
    <form class="" id="authForm">
        <div class="form-floating mb-3">
            <input required name="login" class="form-control rounded-3" id="floatingInput" placeholder="Login">
            <label for="floatingInput">Логин</label>
        </div>
        <div class="form-floating mb-3">
            <input required name="pass" type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Пароль</label>
        </div>
        <p id="StatusMSGAuth"></p>
        <button id="authSubmit" class="formBTN w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Войти</button>
        <small class="text-muted">Вход только для сотрудников службы доставки.</small>
    </form>
</div>
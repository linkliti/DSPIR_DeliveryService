<head>
  <title>Отслеживание</title>
</head>
<div class="container">
  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/images/logo.png" alt="" width="100" height="100">
    <h1 class="display-5 fw-bold">Отслеживание</h1>
    <div class="col-lg-6 mx-auto">
      <p id="StatusMSG" class="lead mb-4">Введите номер заказа для отображения его состояния</p>
      <form id="orderStatusForm">
        <div class="form-floating mb-3 mt-3">
          <input type="text" name="input_field" required class="form-control rounded-3" id="orderInput" placeholder="Номер заказа">
          <label for="orderInput">Номер заказа</label>
        </div>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <button type="submit" class="formBTN btn btn-primary btn-lg px-4 mt-3">Отследить</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  window.addEventListener("DOMContentLoaded", function () {
    document.getElementById('orderStatusForm').addEventListener("submit", function (e) {
      e.preventDefault();
      getOrderStatus();
    })
  });

  async function getOrderStatus() {
    var form = document.getElementById('orderStatusForm')
    var status = document.getElementById('StatusMSG')
    var order = form.input_field.value
    var data = {};
    data["order"] = order;
    str_data = JSON.stringify(data);
    displayError('StatusMSG');
    toggleFormButtons(true);
    var response = await ftch('GET', '/api/user_api.php', str_data);
    toggleFormButtons(false);
    if (response["status"] != 0) {
      displayError('StatusMSG', response["message"]);
    } else {
      status.innerHTML = "Заказ номер: " + order + "; Статус: " + response["result"];
    }
  }
</script>
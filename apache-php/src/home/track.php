<head>
  <title>Отслеживание</title>
</head>
<div class="container">
  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.graphicpie.com/wp-content/uploads/2020/11/red-among-us-png.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold">Отслеживание</h1>
    <div class="col-lg-6 mx-auto">
      <p id="orderStatusDisplay" class="lead mb-4">Введите номер заказа для отображения его состояния</p>
      <form id="orderStatusForm">
        <div class="form-floating mb-3 mt-3">
          <input type="text" name="input_field" required class="form-control rounded-3" id="orderInput" placeholder="Номер заказа">
          <label for="orderInput">Номер заказа</label>
        </div>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <button type="submint" class="btn btn-primary btn-lg px-4 mt-3">Отследить</button>
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
    var status = document.getElementById('orderStatusDisplay')
    var order = form.input_field.value
    var data = {};
    data["order"] = order;
    str_data = JSON.stringify(data);
    var response = await ftch_result('/api/user_api.php', str_data);
    //reload();
    status.innerHTML = "Заказ номер: " + order + "; Статус: " + response["result"];
  }
</script>
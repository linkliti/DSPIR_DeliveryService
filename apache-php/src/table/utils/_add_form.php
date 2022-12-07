<script type="text/javascript">
  window.addEventListener("DOMContentLoaded", function () {
    document.getElementById('addModalForm').addEventListener("submit", function (e) {
      e.preventDefault();
      addToTable();
    })
  });

  async function addToTable() {
    var form = document.getElementById('addModalForm')
    var data = {};
    data["data"] = {};
    for (let i = 0; i < form.elements.length-1; i++) {
      data["data"][form.elements[i].name] = form.elements[i].value;
    };
    data["table"] = <?php echo '"' . currentFile() . '";'; ?>
    str_data = JSON.stringify(data);
    displayError('StatusMSGAdd');
    toggleFormButtons(true);
    var response = await ftch('POST', '/api/table_api.php', str_data);
    toggleFormButtons(false);
    if (response["status"] != 0) {
     displayError('StatusMSGAdd', response["message"]);
    } else {
     reload_page();
    }
  }
</script>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 py-auto shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Добавление</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0">
        <form id="addModalForm">
          <?php
          foreach ($table_data as $i => $data) {
            if ($i>0) {
              echo '<div class="form-floating mb-3">';
              echo '<input type="text" required name="'. $table_data[$i] .'"  class="form-control rounded-3" id="floatingInput" placeholder="' . $table_headers_modify[$i] . '">';
              echo '<label for="floatingInput">' . $table_headers_modify[$i] . '</label>';
              echo '</div>';
            }
          }
          ?>
          <p id="StatusMSGAdd"></p>
          <button class="formBTN w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Отправить</button>
        </form>
      </div>
    </div>
  </div>
</div>
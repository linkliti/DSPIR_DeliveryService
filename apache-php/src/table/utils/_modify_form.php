<script type="text/javascript">
  window.addEventListener("DOMContentLoaded", function () {
    document.getElementById('updateModalForm').addEventListener("submit", function (e) {
      e.preventDefault();
      updateTable();
    })
  });
  async function updateTable() {
    var selected = getSelectedIDs();
    var form = document.getElementById('updateModalForm');
    var data = {};
    data["table"] = <?php echo '"' .currentFile(). '";'; ?>;
    data["data"] = {};
    data["data"]["var"] = document.getElementById('UpdateVariable').value;
    data["data"]["val"] = document.getElementById('UpdateValue').value;
    data["data"]["ids"] = selected;
    str_data = JSON.stringify(data);
    displayError('StatusMSGModify');
    toggleFormButtons(true);
    var response = await ftch('PATCH', '/api/table_api.php', str_data);
    toggleFormButtons(false);
    if (response["status"] != 0) {
      displayError('StatusMSGModify', response["message"]);
    } else {
      reload_page();
    }
  }
</script>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 py-auto shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Изменение выбранных</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0">
        <form id="updateModalForm" class="">
          <div class="d-flex">
            <div class="col-4 fs-5 align-items-center">
              <p class=""> Изменить: </p>
            </div>
            <div class="col-8">
              <select id="UpdateVariable" class="form-select">
                <?php
                foreach ($table_data as $i => $data) {
                  if ($i > 0) {
                    echo '<option value="' . $data . '">' . $table_headers_modify[$i] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-floating mb-3 mt-2">
            <input type="text" required class="form-control rounded-3" id="UpdateValue" placeholder="Значение">
            <label for="UpdateValue">Значение</label>
          </div>
          <p id="StatusMSGModify" class="fw-bold"></p>
          <button class="w-100 mb-2 mt-2 btn btn-lg rounded-3 btn-primary" type="submit">Отправить</button>
        </form>
      </div>
    </div>
  </div>
</div>
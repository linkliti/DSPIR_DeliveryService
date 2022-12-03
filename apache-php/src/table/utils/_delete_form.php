<?php
// $table_headers
// $table_data
?>
<script type="text/javascript">
  window.addEventListener("DOMContentLoaded", function () {
      document.getElementById('deleteModalForm').addEventListener("submit", function (e) {
        e.preventDefault();
        deleteFromTable();
      })
    });
  async function deleteFromTable() {
    var selected = getSelectedIDs();
    var data = {};
    data["table"] = <?php echo '"' .currentFile(). '";'; ?>;
    data["data"] = {};
    data["data"]["ids"] = selected;
    str_data = JSON.stringify(data);
    displayError('StatusMSGDelete');
    toggleFormButtons(true);
    var response = await ftch('DELETE', '/api/table_api.php', str_data);
    toggleFormButtons(false);
    if (response["status"] != 0) {
      displayError('StatusMSGDelete', response["message"]);
    } else {
      reload_page();
    }
  }
</script>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 py-auto shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Удаление выбранных</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0">
        <form id="deleteModalForm" class="">
          <p class="fs-5"> Вы уверены что хотите удалить выбранные записи? </p>
          <p id="StatusMSGDelete" class="fw-bold"></p>
          <button class="formBTN w-100 mb-2 mt-2 btn btn-lg rounded-3 btn-primary" type="submit">Подтвердить</button>
        </form>
      </div>
    </div>
  </div>
</div>
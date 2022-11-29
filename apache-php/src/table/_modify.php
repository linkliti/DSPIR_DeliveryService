<?php
// $table_headers
// $table_data
?>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 py-auto shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Добавление</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <form class="">
                    <?php
                    foreach ($table_data as $i => $data) {
                        if (!($i == 0)) {
                            echo '<div class="form-floating mb-3">';
                            echo '<input type="'. $data .'" class="form-control rounded-3" id="floatingInput" placeholder="'. $table_headers[$i] .'">';
                            echo '<label for="floatingInput">' . $table_headers[$i] . '</label>';
                            echo '</div>';
                        }
                    }
                    ?>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>
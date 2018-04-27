<div class="modal fade" id="editBloodTestResultsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="editbloodresults.php" id="needs-validation3" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="bloodTestResultsTitle">Edit Blood Test Results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Blood Taken On</label>
                        <input class="form-control" id="editBloodTestDatePicker" name="date" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" placeholder="dd/mm/yyyy" required>
                        <div class="invalid-feedback">Please provide a date the blood was received on.</div>
                    </div>
                    <div class="form-group">
                        <label for="editResultsNumber">Results Number</label>
                        <input type="text" class="form-control" id="editResultsNumber" name="resultsNumber" placeholder="Results Number" required>
                        <div class="invalid-feedback">Please provide a result number.</div>
                    </div>
                    <div class="form-group">
                        <label for="editPlasmaCreatinine">Plasma Creatinine Level</label>
                        <input type="number" class="form-control" min="20" id="editPlasmaCreatinine" name="plasmaCreatinine" placeholder="Plasma Creatinine Level" required>
                        <div class="invalid-feedback">Please provide a plasma creatinine level.</div>
                    </div>
                    <input type="hidden" id="patientCHI" name="patientCHI" value="<?php echo $patientID ?>"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#editBloodTestResultsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var date = button.data('date');
            $("#editBloodTestDatePicker").val(date);

            var number = button.data('number');
            $("#editResultsNumber").val(number);

            var plasma = button.data('plasma');
            $("#editPlasmaCreatinine").val(plasma);
        });

        $('#bloodTestResultsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var chi = button.data('chi'); // Extract info from data-* attributes
            $("#patientCHI").val(chi);
        });

        // Activates the jQuery dates picker
        $("#bloodTestDatePicker").datepicker({
            maxDate: '0', // doesn't allow dates from the future to be selected
            dateFormat: 'dd/mm/yy'
        });
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var form = document.getElementById('needs-validation3');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
</script>
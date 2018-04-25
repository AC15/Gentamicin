<div class="modal fade" id="bloodTestResultsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="bloodresults.php" id="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="bloodTestResultsTitle">Blood Test Results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Blood Taken On</label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" required>
                        <div class="invalid-feedback">Please provide a date the blood was received on.</div>
                    </div>
                    <div class="form-group">
                        <label for="resultsNumber">Results Number</label>
                        <input type="text" class="form-control" id="resultsNumber" name="resultsNumber" placeholder="Results Number" required>
                        <div class="invalid-feedback">Please provide a result number.</div>
                    </div>
                    <div class="form-group">
                        <label for="plasmaCreatinine">Plasma Creatinine Level</label>
                        <input type="text" class="form-control" id="plasmaCreatinine" name="plasmaCreatinine" placeholder="Plasma Creatinine Level" required>
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
        $('#bloodTestResultsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var chi = button.data('chi'); // Extract info from data-* attributes
            $("#patientCHI").val(chi);
        });
    });
</script>
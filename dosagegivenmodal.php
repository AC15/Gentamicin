<div class="modal fade" id="dosageGivenModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="dosagegiven.php" id="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="dosageGivenModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bloodTestDatePicker">Date</label>
                        <input class="form-control" id="dosageGivenDatePicker" name="date" placeholder="dd/mm/yyyy" required>
                        <div class="invalid-feedback">Please provide a date.</div>
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="text" class="form-control" id="time" name="time" pattern="^([0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" placeholder="Time (00:00)" required>
                        <div class="invalid-feedback">Please provide a time.</div>
                    </div>
                    <div class="form-group">
                        <label for="ward">Ward</label>
                        <select class="form-control" id="ward" name="ward" required>
                            <option selected disabled hidden value="">Choose...</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="person">Person</label>
                        <select class="form-control" id="person" name="person" required>
                            <option selected disabled hidden value="">Choose...</option>
<?php
$doctors = $Database->selectMany("SELECT staffID, staffTitle, staffFirstName, staffLastName
FROM staff
WHERE staffRole = 'Doctor'",
    null);

while ($row = $doctors->fetch_assoc()) {
    $id = $row["staffID"];
    $name = $row["staffTitle"] . " " . $row["staffFirstName"] . " " . $row["staffLastName"];
    echo '<option value="' . $id . '">' . $name . '</option>';
}
?>
                        </select>
                    </div>
                    <input type="hidden" id="patientCHI" name="patientCHI" value="">
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
        $('#dosageGivenModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var chi = button.data('chi'); // Extract info from data-* attributes
            $("#patientCHI").val(chi);
        });

        // Activates the jQuery dates picker
        $("#dosageGivenDatePicker").datepicker({
            maxDate: '0', // doesn't allow dates from the future to be selected
            dateFormat: 'dd/mm/yy'
        });
    });
</script>
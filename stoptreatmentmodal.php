<!-- This page displays a confirmation box to stop the gentamicin treatment -->

<div class="modal fade" id="stopTreatmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dosageGivenModalTitle">Do you want to stop gentamicin treatment for this patient?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="post" action="stoptreatment.php">
                        <button type="submit" class="btn btn-primary" data-toggle="modal" name="patientCHI" value="<?php echo $patientID ?>">Stop Gentamicin Treatment</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
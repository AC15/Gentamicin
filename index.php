<?php require "header.html" ?>

<div class="container">
    <h1>Current Gentamicin Patients</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#CHI</th>
            <th scope="col">Name</th>
            <th scope="col">Next Dosage</th>
            <th scope="col">Date Due</th>
            <th scope="col">Time Due</th>
            <th scope="col">Gentamicin Dosage</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1234567890</th>
            <td>John Doe</td>
            <td>Due</td>
            <td>15/09/2018</td>
            <td>17:00</td>
            <td>200mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#previousDosagesModal">Previous Dosages</button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        <tr>
            <th scope="row">1234567890</th>
            <td>Steven Doe</td>
            <td>1h 39m</td>
            <td>14/09/2018</td>
            <td>17:05</td>
            <td>150mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#previousDosagesModal">Previous Dosages</button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        <tr>
            <th scope="row">1234567890</th>
            <td>Jack Doe</td>
            <td>2d 1h 39m</td>
            <td>14/09/2018</td>
            <td>17:05</td>
            <td>160mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#previousDosagesModal">Previous Dosages</button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="previousDosagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Previous Dosages (#1234567890 John Doe)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Initial Gentamicin Dose: 200mg</p>
                    <p>Predicted Frequency: 24 hourly</p>
                    <p>Expected Stop Date: 16/09/2018</p>

                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Date Due</th>
                            <th scope="col">Time Due</th>
                            <th scope="col">Date Given</th>
                            <th scope="col">Time Given</th>
                            <th scope="col">Dosage</th>
                            <th scope="col">Ward</th>
                            <th scope="col">Given By #</th>
                            <th scope="col">Given By</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>15/09/2018</td>
                            <td>17:00</td>
                            <td>15/09/2018</td>
                            <td>17:05</td>
                            <td>200mg</td>
                            <td>2</td>
                            <td>1234567890</td>
                            <td>Dr. John Doe</td>
                        </tr>
                        <tr>
                            <td>14/09/2018</td>
                            <td>17:05</td>
                            <td>14/09/2018</td>
                            <td>17:10</td>
                            <td>200mg</td>
                            <td>2</td>
                            <td>1234567890</td>
                            <td>Dr. John Doe</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade" id="dosageGivenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Previous Dosages (#1234567890 John Doe)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                            <div class="invalid-feedback">Please provide a date.</div>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="text" class="form-control" id="time" name="time" placeholder="Time" required>
                            <div class="invalid-feedback">Please provide a time.</div>
                        </div>
                        <div class="form-group">
                            <label for="dosage">Dosage</label>
                            <input type="text" class="form-control" id="dosage" name="dosage" placeholder="Dosage" required>
                            <div class="invalid-feedback">Please provide a dosage.</div>
                        </div>
                        <div class="form-group">
                            <label for="person">Ward</label>
                            <select class="form-control" id="person" name="ward">
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
                            <select class="form-control" id="person" name="person">
                                <option selected disabled hidden value="">Choose...</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.html" ?>
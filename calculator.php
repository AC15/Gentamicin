<?php require "header.php" ?>

    <div class="container col-lg-6 offset-lg-3">
        <form id="needs-validation" onsubmit="event.preventDefault(); dose();" novalidate>
            <h1>Gentamicin Calculator</h1>
            <div class="form-group">
                <legend class="col-form-label">Sex</legend>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male" required>
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female" required>
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                </div>
                <div class="invalid-feedback">Please select a sex.</div>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" min="17" max="70" id="age" name="age" placeholder="Age" required>
                <div class="invalid-feedback">Please provide an age, between 17 and 70.</div>
            </div>
            <div class="form-group">
                <label for="weight">Actual Weight (kilograms)</label>
                <input type="number" class="form-control" min="0" id="weight" name="weight" placeholder="Actual Weight (kilograms)" required>
                <div class="invalid-feedback">Please provide a weight.</div>
            </div>
            <div class="form-group">
                <label for="height">Height (centimeters)</label>
                <input type="number" class="form-control" min="100" max="250" id="height" name="height" placeholder="Height (centimeters)" required>
                <div class="invalid-feedback">Please provide a height between 100 and 250 centimeters.</div>
            </div>
            <div class="form-group">
                <label for="plasma">Plasma Creatinine Level (μmol/l)</label>
                <input type="number" class="form-control" min="20" id="plasma" name="plasma" placeholder="Plasma Creatinine Level (μmol/l)" required>
                <div class="invalid-feedback">Please provide a plasma creatinine level of at least 20.</div>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>

            <div class="row">
                <div class="col-md">
                    <legend class="col-form-label">Initial Dose:</legend>
                    <h3 id="result">0mg</h3>
                </div>
                <div class="col-md">
                    <legend class="col-form-label">Next Dosage Due:</legend>
                    <h3 id="hourlyRate">0hrs</h3>
                </div>
                <div class="col-md">
                    <legend class="col-form-label">Creatinine Clearance:</legend>
                    <h3 id="creatinineClearance">0</h3>
                </div>
            </div>
        </form>
    </div>

    <script src="js/formChecker.js"></script>
    <script src="js/dosageCalculation.js"></script>

<?php require "footer.html" ?>
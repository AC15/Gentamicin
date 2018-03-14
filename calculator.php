<?php require "header.html" ?>

    <div class="container">
        <form class="col-md-6 offset-md-3">
            <h1>Gentamicin Calculator</h1>
            <div class="form-group">
                <legend class="col-form-label">Sex</legend>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Female</label>
                </div>
                <div class="invalid-feedback">Please select a sex.</div>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" class="form-control" id="age" name="age" placeholder="Age" required>
                <div class="invalid-feedback">Please provide an age.</div>
            </div>
            <div class="form-group">
                <label for="weight">Actual Weight</label>
                <input type="text" class="form-control" id="weight" name="weight" placeholder="Actual Weight" required>
                <div class="invalid-feedback">Please provide a weight.</div>
            </div>
            <div class="form-group">
                <label for="height">Height (centimeters)</label>
                <input type="text" class="form-control" id="height" name="height" placeholder="Height (centimeters)" required>
                <div class="invalid-feedback">Please provide a height.</div>
            </div>
            <div class="form-group">
                <label for="plasma">Plasma Creatinine Level (μmol/l)</label>
                <input type="text" class="form-control" id="plasma" name="plasma" placeholder="Plasma Creatinine Level (μmol/l)" required>
                <div class="invalid-feedback">Please provide a plasma creatinine level.</div>
            </div>
            <legend class="col-form-label">Initial Gentamicin Dose:</legend>
            <h3>0mg</h3>
            <br>
        </form>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
    </div>

<?php require "footer.html" ?>
"use strict";
function dose() {
    var sex = document.querySelector("input[name='sex']:checked").value;
    var age = document.getElementById("age").value;
    var height = document.getElementById("height").value; // Height in CM
    var weight = document.getElementById("weight").value; // Not required in HTML form, can use ideal body weight from age
    var plasmaCreatinine = document.getElementById("plasma").value;

    var hourly_rate = 0;
    var dose = 0;
    var x = 0;
    var f = 0;

    if (sex === "Male") {
        x = 50;
        f = 1.23
    } else if (sex === "Female") {
        x = 45.5;
        f = 1.04;
    }

    var ibw = calculateIBW();

    if (weight > ibw) {
        weight = ibw;
    }

    // Check creatinine clearance
    var a = (140 - age) * weight * f;
    var creatinineClearance = a / plasmaCreatinine;

    if (validate()) {
        if (creatinineClearance > 60) {
            dosage(24, 400, 360, 320, 280, 240);
        }
        else if (creatinineClearance >= 51) {
            dosage(24, 320, 300, 280, 240, 200);
        }
        else if (creatinineClearance >= 41) {
            dosage(48, 400, 360, 320, 280, 240);
        }
        else if (creatinineClearance >= 31) {
            dosage(48, 320, 300, 280, 240, 200);
        }
        else if (creatinineClearance >= 21) {
            dosage(48, 260, 240, 240, 200, 180);
        }
    }
    //document.getElementById("result").innerHTML = ft_dif;
    //document.getElementById("result").innerHTML = a_creat_clearance;

    document.getElementById("result").innerHTML = dose + "mg";
    document.getElementById("hourlyRate").innerHTML = "Every " + hourly_rate + "hrs";
    document.getElementById("creatinineClearance").innerHTML = creatinineClearance.toFixed(2).toString();

    function reset() {
        document.getElementById("result").innerHTML = "0mg";
        document.getElementById("hourlyRate").innerHTML = "Every 0hrs";
        document.getElementById("creatinineClearance").innerHTML = "CrCl = 0";
    }

    function calculateIBW() {
        var ft_dif = 0;
        // How far over 5ft
        if (height > 152.4) {
            var cm_dif = height - 152.4;
            var inchsum = cm_dif * 0.39370;

            // ft_to_inch = height_ft*12;
            //var inchsum = (height_inch*1) + ft_to_inch;
            ft_dif = 60 - inchsum; // Find difference from 5ft (60 inches)
        }

        // Find ideal body weight
        return x + (2.3 * ft_dif);
    }

    function validate() {
        if (age > 70 && age <= 16
            && creatinineClearance < 20
            && (height < 100) || (height > 250)
            && isNaN(age) && isNaN(height) && isNaN(weight) && isNaN(plasmaCreatinine)) {
            reset();
            return false;
        }
        return true;
    }

    function dosage(hourlyRate, dose1, dose2, dose3, dose4, dose5) {
        hourly_rate = hourlyRate;

        if (weight > 80) {
            dose = dose1;
        }
        else if (weight >= 70) {
            dose = dose2;
        }
        else if (weight >= 60) {
            dose = dose3;
        }
        else if (weight >= 50) {
            dose = dose4;
        }
        else if (weight >= 40) {
            dose = dose5;
        }
    }
}

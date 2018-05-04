/**
 * Displays a countdown timer for selected date
 *
 * @param date
 * @param id
 */
function timer(date, id) {
// Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = date - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (86400000));
        var hours = Math.floor((distance % (86400000)) / (3600000));
        hours += days * 24;
        var minutes = Math.floor((distance % (3600000)) / (60000));
        var seconds = Math.floor((distance % (60000)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById(id).innerHTML = hours + ":" + minutes.pad() + ":" + seconds.pad();

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById(id).innerHTML = "DUE";
        }
    }, 1000);

    /**
     * Formats the time by adding leading zeros
     *
     * @param size
     * @returns {string}
     */
    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }
}
module.exports = {
    init: function () {

        //module.exports = {

        $('#zoomImage').click(function () {
            document.getElementById("myModal").style.display = "block";
        });

        // Close the Modal
        $('#closeImage').click(function () {
            document.getElementById("myModal").style.display = "none";
        });
    }
}
let chip = require('./chip');
chip.init();
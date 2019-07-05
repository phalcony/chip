module.exports = {
    init: function () {

        //module.exports = {

        $('.zoomImage').click(function () {
            let imageUrl = $(this).data('iamgeurl');
            let imageCaption = $(this).data('caption');
            console.log(imageUrl);
            console.log(imageCaption);
            // $("#myModal image > src").val(imageUrl);
            $("#modalImage").attr("src", imageUrl);
            $("#caption").html('Quelle: ' + imageCaption);
            document.getElementById("myModal").style.display = "block";


        });

        // Close the Modal
        $('#closeImage').click(function () {
            document.getElementById("myModal").style.display = "none";
        });

        $('.close').click(function () {
            document.getElementById("successMsg").style.display = "none";
            document.getElementById("errorMsg").style.display = "none";
        });
    }
}
let chip = require('./chip');
chip.init();
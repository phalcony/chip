module.exports = {
    init: function () {

        //Bind action to view elements
        $('.zoomImage').click(function () {
            let imageUrl = $(this).data('iamgeurl');
            let imageCaption = $(this).data('caption');

            $("#modalImage").attr("src", imageUrl);
            $("#caption").html('Quelle: ' + imageCaption);
            $("#myModal").css("display", "block");
        });

        // Close the Modal
        $('#closeImage').click(function () {
            $("#myModal").css("display", "none");
        });

        $('.close').click(function () {
            $("#successMsg").css("display", "none");
            $("#errorMsg").css("display", "none");
        });
    }
}
let chip = require('./chip');
chip.init();
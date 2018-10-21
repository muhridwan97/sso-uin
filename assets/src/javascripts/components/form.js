import showAlert from "./alert";

export default (function() {

    // set value of file in custom input file and check maximum value of file
    $(document).on('change', '.file-upload-default', function () {
        if (this.files && this.files[0]) {
            let maxFile = $(this).data('max-size');
            if (this.files[0].size > maxFile) {
                showAlert('File too large', 'Maximum file must be less than ' + (maxFile / 1000000) + 'MB');
            } else {
                $(this).closest('.form-group').find('.file-upload-info').val(this.files[0].name);
            }
        }
    });

    // trigger closest input file form
    $(document).on('click', '.btn-simple-upload', function () {
        $(this).closest('.form-group').find('[type=file]').click();
    });

    // One touch on submit
    function checkOnTouchSubmit(form) {
        let buttonSubmit = $(form).find('[data-toggle=one-touch]');
        if (buttonSubmit.length) {
            let message = buttonSubmit.data('touch-message');
            if (message === undefined) {
                message = 'Submitted...';
            }
            buttonSubmit.attr('disabled', true).html(message);
        }
    }

    // set on touch button submit
    $('form').on('submit', function (e) {
        if ($(this).attr('novalidate') !== undefined) {
            if ($(this).valid()) {
                checkOnTouchSubmit($(this));
            }
        }
        return true;
    });

})();
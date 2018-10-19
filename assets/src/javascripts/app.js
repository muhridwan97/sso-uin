import $ from 'jquery';
import variables from "./components/variables";

$.ajaxSetup({
    headers: {
        "X-CSRFToken": variables.csrfToken
    }
});

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

$('form').on('submit', function (e) {
    if ($(this).attr('novalidate') !== undefined) {
        if ($(this).valid()) {
            checkOnTouchSubmit($(this));
        }
    }
    return true;
});

$('.btn-section').on('mouseover', function () {
    let sectionTitle = $(this).data('title');
    $('.app-banner-description').find('.container').text(sectionTitle);
});
$('.btn-section').on('mouseleave', setBannerDescription);

function setBannerDescription() {
    let sectionTitle = $('.btn-section.active').data('title');
    $('.app-banner-description').find('.container').text(sectionTitle);
}

setBannerDescription();


$('#pick-icons').on('click', 'div', function () {
    $('#pick-icons > div').removeClass('active');
    $(this).addClass('active');
    $('input[name=icon]').val($.trim($(this).find('span').text()));
});

$('.pick-icon-search').on('keyup', function () {
    let search = $(this).val();
    $('#pick-icons').find('span').each(function (index, el) {
        if(!$(el).text().includes(search)) {
            $(el).parent().hide();
        } else {
            $(el).parent().show();
        }
    });
});

require('./components/delete');

import '../sass/app.scss';

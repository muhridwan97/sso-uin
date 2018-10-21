export default (function () {

    /**
     * url: /manage/application/{create/({edit/:id})}
     * Pick icon label to set in text field.
     */
    $('#pick-icons').on('click', 'div', function () {
        $('#pick-icons > div').removeClass('active');
        $(this).addClass('active');
        $('input[name=icon]').val($.trim($(this).find('span').text()));
    });

    /**
     * url: /manage/application/{create/({edit/:id})}
     * Search icon and filter the rest that didn't match with keyword.
     */
    $('.pick-icon-search').on('keyup', function () {
        let search = $(this).val();
        $('#pick-icons').find('span').each(function (index, el) {
            if (!$(el).text().includes(search)) {
                $(el).parent().hide();
            } else {
                $(el).parent().show();
            }
        });
    });
})();
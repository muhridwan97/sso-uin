export default function () {

    /**
     * url: /manage/user/{create/({edit/:id})}
     * Pick icon label to set in text field.
     */
    const formUser = $('#form-user');
    const checkboxApplications = formUser.find('[name="applications[]"]');
    const selectDefaultApplication = formUser.find('#default_application');
    checkboxApplications.on('change', () => {
        setDefaultApp();
    });

    function setDefaultApp() {
        const selectedApp = [];
        checkboxApplications.each((index, el) => {
            if ($(el).is(':checked')) {
                selectedApp.push($(el).val());
            }
        });

        selectDefaultApplication.find('option').each((index, el) => {
            const value = $(el).attr('value');
            if (!selectedApp.includes(value) && value !== '') {
                $(el).hide();
            } else {
                $(el).show();
            }
        });

        if (!selectedApp.includes(selectDefaultApplication.val())) {
            selectDefaultApplication.val('');
        }
    }
};
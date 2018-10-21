import variables from "../components/variables";
import showAlert from "../components/alert";

export default (function () {

    /**
     * url: /manage/release/{create/({edit/:id})}
     * Find latest version value
     */
    let formRelease = $('#form-release');
    formRelease.find('#application').on('change', function () {
        formRelease.find('#major').attr('disabled', true);
        formRelease.find('#minor').attr('disabled', true);
        formRelease.find('#patch').attr('disabled', true);

        let applicationId = $(this).val();
        fetch(`${variables.baseUrl}manage/release/ajax_get_last_version/${applicationId}`)
            .then(result => result.json())
            .then(function (version) {
                if (version) {
                    formRelease.find('#major').val(version.major);
                    formRelease.find('#minor').val(version.minor);
                    formRelease.find('#patch').val(version.patch);
                } else {
                    setDefaultVersion();
                }
                removeDisableVersions();
            })
            .catch(err => {
                console.log(err.message);
                setDefaultVersion();
                removeDisableVersions();
                showAlert('Error', 'Something is getting wrong while fetching last version of the application');
            });
    });

    /**
     * Set default version if the application has no release history of something went wrong.
     */
    function setDefaultVersion() {
        formRelease.find('#major').val(1);
        formRelease.find('#minor').val(0);
        formRelease.find('#patch').val(0);
    }

    /**
     * Remove status disabled of version inputs.
     */
    function removeDisableVersions() {
        formRelease.find('#major').removeAttr('disabled');
        formRelease.find('#minor').removeAttr('disabled');
        formRelease.find('#patch').removeAttr('disabled');
    }

})();
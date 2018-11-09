import $ from 'jquery';
import variables from "./components/variables";

$.ajaxSetup({
    headers: {
        "X-CSRFToken": variables.csrfToken
    }
});

import("./components/layout").then(layout => layout.default());

if ($('#modal-delete').length) {
    import("./components/delete").then(modalDelete => modalDelete.default());
}
if ($('form').length) {
    import("./components/form").then(form => form.default());
}


if ($('#form-application').length) {
    import("./pages/application").then(application => application.default());
}
if ($('#form-release').length) {
    import("./pages/release").then(release => release.default());
}


import '../sass/app.scss';

import $ from 'jquery';
import variables from "./components/variables";

$.ajaxSetup({
    headers: {
        "X-CSRFToken": variables.csrfToken
    }
});

require('jquery-validation');

// deferred style or fonts
let loadDeferredStyles = function() {
    let addStylesNode = document.getElementById("deferred-styles");
    let replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement);
    addStylesNode.parentElement.removeChild(addStylesNode);
};
let raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
    window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
else window.addEventListener('load', loadDeferredStyles);


import("./components/layout").then(layout => layout.default());

if ($('#modal-delete').length) {
    import("./components/delete").then(modalDelete => modalDelete.default());
}
if ($('#form-application').length) {
    import("./pages/application").then(application => application.default());
}
if ($('#form-release').length) {
    import("./pages/release").then(release => release.default());
}
if ($('#form-user').length) {
    import("./pages/user").then(user => user.default());
}


// loading misc scripts
require('./scripts/validation');
require('./scripts/table-responsive');
require('./scripts/one-touch-submit');
require('./scripts/miscellaneous');

import '../sass/app.scss';

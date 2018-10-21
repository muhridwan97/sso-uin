import $ from 'jquery';
import variables from "./components/variables";

$.ajaxSetup({
    headers: {
        "X-CSRFToken": variables.csrfToken
    }
});

require('./components/layout');
require('./components/delete');
require('./components/form');

require('./pages/application');
require('./pages/release');

import '../sass/app.scss';

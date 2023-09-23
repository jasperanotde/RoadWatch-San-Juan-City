import './bootstrap';
import 'flowbite';

// Initialization for ES Users
// Install: npm install tw-elements -- if encountering error
import './dropdown-init';
import './modal-init';
//import './datatable-init';

import '@fancyapps/fancybox';
document.addEventListener('DOMContentLoaded', function () {
    // Wrap your Fancybox initialization inside a check for the existence of jQuery
    if (typeof jQuery !== 'undefined') {
        $('[data-fancybox]').fancybox();
    }
});
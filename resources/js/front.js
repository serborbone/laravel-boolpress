window.Vue = require('vue');
window.axios = require('axios');

import App from './views/App';

const app = new Vue({

    el: '#root',
    render: h => h(App),

});
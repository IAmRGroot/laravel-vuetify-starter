import Vue from 'vue';

import './plugins/composition-api';

import App from './App.vue';

import router from './plugins/router';
import vuetify from './plugins/vuetify';

new Vue({
    vuetify,
    router,
    render: h => h(App),
}).$mount('#app');

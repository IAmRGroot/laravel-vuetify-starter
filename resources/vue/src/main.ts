import Vue from 'vue';

import './plugins/composition-api';

import App from './App.vue';

import router from './plugins/router';
import vuetify from './plugins/vuetify';
import i18n from './plugins/i18n';

new Vue({
    vuetify,
    router,
    i18n,
    render: h => h(App),
}).$mount('#app');

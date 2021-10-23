import Vue from 'vue';
import Vuetify from 'vuetify/lib';

import en from 'vuetify/lib/locale/en';

import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);

export default new Vuetify({
    icons: { iconfont: 'mdi' },

    lang: {
        locales: { en },
        current: 'en',
    },

});

import { createVuetify } from 'vuetify';
import 'vuetify/styles'; // Импортируйте стили Vuetify
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'
import { mdi } from 'vuetify/iconsets/mdi'

const vuetify = createVuetify({
    icons: {
        defaultSet: 'mdi',
        sets: {
            mdi: {
                aliases: {
                    'home': 'home-outline',
                    'menu': 'menu-outline',
                    // Add any other aliases you need here
                },
            },
        },
    },
    components,
    directives,
});

export default vuetify;

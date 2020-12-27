require('./bootstrap')

import Vue from 'vue'
import Main from './main'
// import router from './routes'

import 'normalize-scss'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faTrashAlt, faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faEdit, faTrashAlt, faTrash)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false



const app = new Vue({
    el: '#app',
    // router,
    render: (h) => h(Main),
})
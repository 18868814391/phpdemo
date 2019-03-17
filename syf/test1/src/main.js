import Vue from 'vue'
import App from './App.vue'
import {router} from './router/router'
import './plugins/element.js'

Vue.config.productionTip = false

new Vue({
  router,
  components: { App },
  render: h => h(App),
}).$mount('#app')

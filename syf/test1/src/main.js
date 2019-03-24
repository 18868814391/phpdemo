import Vue from 'vue'
import App from './App.vue'
import {router} from './router/router'
import './plugins/element.js'
import Vant from 'vant';
import 'vant/lib/index.css';

Vue.use(Vant);

Vue.config.productionTip = false

new Vue({
  router,
  components: { App },
  render: h => h(App),
}).$mount('#app')

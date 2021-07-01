import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'

Vue.use(VueRouter);
Vue.config.productionTip = false

const routes = [
  {path: '/', component: Home},
  {path: '/login', component: Login}
]

const router = new VueRouter({
    routes,
    mode:'history'
});

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');

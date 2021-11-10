require('./bootstrap')

window.Vue = require('vue').default

import store from "./stores/global-store"

import App from './App.vue'
import MedicamentosComponent from './components/medicamentos'
import LoginComponent from './components/login'
import AlterarSenhaComponent from './components/alterarSenha'
import MinhasReceitasComponent from './components/minhasReceitas'
import NovaReceitaComponent from './components/novaReceita'
import ReceitasAbertasComponent from './components/receitasAbertas'
import ReceitasFechadasComponent from './components/receitasFechadas'
import ReceitasRecusadasComponent from './components/receitasRecusadas'

import Toasted from 'vue-toasted'

Vue.use(Toasted, {
    position: 'top-center',
    duration: 5000,
    type: 'info',
})

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    { path: '/', redirect: '/medicamentos' },
    { path: '/medicamentos', component: MedicamentosComponent },
    { path: '/login', component: LoginComponent },
    { path: '/alterarsenha', component: AlterarSenhaComponent },
    { path: '/carrinho', component: NovaReceitaComponent },
    { path: '/minhas', component: MinhasReceitasComponent },
    { path: '/receitas/abertas', component: ReceitasAbertasComponent },
    { path: '/receitas/fechadas', component: ReceitasFechadasComponent },
    { path: '/receitas/recusadas', component: ReceitasRecusadasComponent },
]

const router = new VueRouter({
    routes: routes
})

new Vue({
    render: h => h(App),
    router,
    store,
    created(){
        this.$store.dispatch('checkUser')
    }
}).$mount('#app')


import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null,
        receita: []
    },
    mutations: {
        clearUser (state) {
            state.user = null
            localStorage.removeItem('user')
            state.receita = []
            localStorage.removeItem('receita')
        },
        setUser (state, user) {
            state.user = user
            if (localStorage.getItem('user') === null) {
                localStorage.setItem('user', JSON.stringify(state.user))
            }
            if (localStorage.getItem('receita') !== null) {
                state.receita = JSON.parse(localStorage.getItem('receita'))
            }
        },
        addItem(state, item){
            const record = state.receita.find(p => p.item.id === item.id)
            if (!record) {
                state.receita.push({
                    item,
                    quantity: 1
                })
            } else {
                record.quantity++
            }
            localStorage.setItem('receita', JSON.stringify(state.receita))
        },
        removeItem(state, item){
            const record = state.receita.find(p => p.item.id === item.id)
            if (record.quantity>1) {
                record.quantity--
            } else {
                state.receita = state.receita.filter(function(el) { return el.item.id != record.item.id; });
            }
            localStorage.setItem('receita', JSON.stringify(state.receita))
        },
        deleteItem(state, item){
            const record = state.receita.find(p => p.item.id === item.id)
            state.receita = state.receita.filter(function(el) { return el.item.id != record.item.id; });
            localStorage.setItem('receita', JSON.stringify(state.receita))
        },

    },
    actions: {
        checkUser (context) {
            if (localStorage.getItem('user') === null) {
                context.commit('clearUser')
            } else {
                context.commit('setUser', JSON.parse(localStorage.getItem('user')))
            }
        },
        addToReceita: ({commit}, payload) => {
            commit('addItem',  payload )
        },
        removeFromReceita: ({commit}, payload) => {
            commit('removeItem',  payload )
        },
        deleteFromReceita: ({commit}, payload) => {
            commit('deleteItem',  payload )
        },
    }
})

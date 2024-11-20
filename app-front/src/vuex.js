import Vuex from 'vuex'

const state = {
    email: localStorage.getItem('email') || null
};

const store = new Vuex.Store({
    state,
    getters: {
        email: (state) => {
            return state.email;
        }
    },
    actions: {
        email(context, email) {
            context.commit('email', email);
        }
    },
    mutations: {
        email(state, email) {
            state.email = email;
        }
    }
});

export default store;
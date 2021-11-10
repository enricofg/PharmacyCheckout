<template>
    <div>
        <header>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between">
                    <router-link
                        class="navbar-brand d-flex align-items-center"
                        to="/"
                    >
                        <img
                            src="img/logo.svg"
                            width="20"
                            height="20"
                            style="margin-right:20px"
                        />
                        <strong>Exame (DAD)</strong>
                    </router-link>

                    <ul class="nav justify-content-end">
                        <li class="nav-item"
                            v-if="$store.state.user !== null">
                            <router-link
                                class="nav-link"
                                to="/minhas"
                                v-if="$store.state.user.tipo_user  === 'C'"
                            >Minhas Receitas
                            </router-link>
                        </li>
                        <li class="nav-item"
                            v-if="$store.state.user !== null">
                            <router-link
                                class="nav-link"
                                to="/carrinho"
                                v-if="$store.state.user.tipo_user  === 'C'"
                            >Nova Receita
                                <span v-if="numberOfItems > 0">({{ numberOfItems }})</span>
                            </router-link>
                        </li>
                        <li class="nav-item"
                            v-if="$store.state.user !== null">
                            <router-link
                                class="nav-link"
                                to="/receitas/abertas"
                                v-if="$store.state.user.tipo_user  === 'F'"
                            >Receitas Abertas
                            </router-link>
                        </li>
                        <li class="nav-item"
                            v-if="$store.state.user !== null">
                            <router-link
                                class="nav-link"
                                to="/receitas/fechadas"
                                v-if="$store.state.user.tipo_user  === 'F'"
                            >Receitas Fechadas
                            </router-link>
                        </li>
                        <li class="nav-item"
                            v-if="$store.state.user !== null">
                            <router-link
                                class="nav-link"
                                to="/receitas/recusadas"
                                v-if="$store.state.user.tipo_user  === 'F'"
                            >Receitas Recusadas
                            </router-link>
                        </li>
                        <li
                            v-if="!$store.state.user"
                            class="nav-item"
                        >
                            <router-link
                                to="/login"
                                class="btn btn-secondary"
                                role="button"
                            >Entrar
                            </router-link>
                        </li>
                        <li
                            v-else
                            class="nav-item"
                        >
                            <div class="dropdown">
                                <button
                                    class="btn btn-secondary dropdown-toggle"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    tag="button"
                                >
                                    {{ $store.state.user.name }}
                                </button>
                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton"
                                >
                                    <router-link
                                        to="/alterarsenha"
                                        class="dropdown-item"
                                    >Alterar Senha
                                    </router-link>
                                    <a
                                        class="dropdown-item"
                                        v-on:click.prevent="logout"
                                    >Sair</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main role="main">
            <div class="container">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            axios.post('/api/logout').then(response => {
                this.$store.commit('clearUser')
                this.$toasted.show('Utilizador saiu da aplicação.', {type: 'warning'})
                this.$router.push("/").catch(() => {
                })
            })
                .catch(error => {
                    this.$toasted.show('Pedido HTTP "Logout" inválido!', {type: 'error'})
                })
        },
    },
    computed: {
        numberOfItems() {
            let count = 0
            if (this.$store.state.receita !== null) {
                this.$store.state.receita.forEach(function (e) {
                    count += e.quantity
                });
            }

            return count
        }
    }
}
</script>

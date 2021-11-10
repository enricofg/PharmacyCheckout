<template>
    <div>
        <div class="row">
            <h1>Medicamentos</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select
                                class="form-control"
                                name="filterGenerico"
                                id="inputfilterGenerico"
                                v-model="isGenerico"
                            >
                                <option
                                    value=""
                                    selected

                                >Todos
                                </option>
                                <option value="0">De marca</option>
                                <option value="1">Genéricos</option>
                            </select>
                        </div>
                        <input
                            type="text"
                            name="filterNome"
                            id="inputfilterNome"
                            placeholder="Nome do medicamento inclui ..."
                            class="form-control mx-2"
                            v-model="searchTerm"
                        >
                        <div class="input-group-append">
                            <button class="input-group-text bg-secondary text-white"
                                    @click.prevent="limparPesquisa()">Limpar
                            </button>
                            <button class="input-group-text bg-success text-white"
                                    @click.prevent="pesquisar()">Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="searching">
            <div class="col-md-12">
                <h3>Medicamentos cujo nome inclui "{{ searchTerm }}"</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Genérico</th>
                        <th class="text-right">Preço</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- REPETIR PARA CADA MEDICAMENTO DA LISTA -->
                    <tr :class="{'table-warning': medicamento.generico}" v-for="medicamento in medicamentos" :key="medicamento.id">
                        <!-- aplicar "table-warning" só se medicamento genérico -->
                        <td class="align-middle">{{ medicamento.nome }}</td>
                        <td
                            class="text-center align-middle"
                            style="width:3rem;"
                        >{{ medicamento.generico == 1 ? 'Sim' : 'Não' }}
                        </td> <!-- "Sim" só se medicamento genérico -->
                        <td
                            class="text-right align-middle"
                            style="width:7rem;"
                        >{{ medicamento.preco }}
                        </td>
                        <td
                            class="align-middle"
                            style="width:3rem;"
                        >
                            <button class="btn btn-secondary"
                                    v-if="$store.state.user && $store.state.user.tipo_user=='C'"
                                    @click.prevent="addToReceita(medicamento)">+</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data: function () {
        return {
            user: [],
            medicamentos: [],
            searchTerm: "",
            isGenerico: "",
            searching: false
        }
    },
    methods: {
        getMedicamentos: function () {
            axios.get('api/medicamentos')
                .then(response => {
                    this.medicamentos = response.data
                })
        },
        setUser: function () {
            if (this.$store.state.user !== null) {
                this.user = this.$store.state.user
            }
        },
        pesquisar: function () {
            let search = {
                searchTerm: this.searchTerm,
                isGenerico: this.isGenerico
            }

            this.searching = true;
            console.log(search)
            axios.post('api/medicamentos/pesquisa', search)
                .then(response => {
                    console.log(response)
                    this.medicamentos=response.data
                })
        },
        limparPesquisa: function () {
            this.searchTerm = ""
            this.searching = false
            this.getMedicamentos()
        },
        addToReceita: function (medicamento) {
            this.$store.dispatch('addToReceita', medicamento)
        },
    },
    mounted() {
        this.getMedicamentos(),
        this.setUser()
    },
}
</script>

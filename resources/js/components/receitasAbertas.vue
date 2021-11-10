<template>
    <div>
        <h1>Receitas Abertas</h1>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th class="text-right">Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- REPETIR PARA CADA RECEITA NA LISTA -->
                <template v-for="(receita,index) in receitas">
                    <!-- Exemplo de uma linha -->
                    <tr>
                        <td
                            class="text-right"
                            style="width:6rem;"
                        ><button
                            class="btn btn-primary"
                            @click.prevent="fecharReceita(receita)"
                        >Fechar</button>
                        </td>
                        <td
                            class="text-right"
                            style="width:6rem;"
                        ><button
                            class="btn btn-danger"
                            @click.prevent="rejeitarReceita(receita)"
                        >Rejeitar</button>
                        </td>
                        <td>{{receita.id}}</td>
                        <td>{{ receita.data }}</td>
                        <td>{{ receita.cliente.name }}</td>
                        <td class="text-right">{{ receita.total }} €</td>
                        <td
                            class="text-right"
                            style="width:5rem;"
                        >
                            <button class="btn btn-secondary"
                                    v-if="itemToShow!=index"
                                    @click="itemToShow=index">...</button>
                            <!-- OU -->
                            <button class="btn btn-dark"
                                    @click="itemToShow=-1"
                                    v-else>x</button>

                        </td>
                    </tr>
                    <!-- Só mostra se detalhe estiver aberto -->
                    <tr v-bind:row="receita.medicamentos"
                        v-show="itemToShow == index"
                        class="current-row">
                        <td></td>
                        <td colspan="5">
                            <detalhes-receita
                                v-bind:medicamentos="receita.medicamentos"
                            ></detalhes-receita>
                        </td>
                        <td></td>
                    </tr>
                    <!-- FIM DE Só mostra se detalhe estiver aberto -->
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import DetalhesReceitaComponent from './detalhesReceita'

export default {
    components: {
        'detalhes-receita': DetalhesReceitaComponent,
    },

    data: function () {
        return {
            receitas: [],
            itemToShow: -1
        }
    },
    methods: {
        getReceitas: function () {
            axios.get('api/receitasabertas')
                .then(response => {
                    this.receitas = response.data
                    console.log(this.receitas)
                })
        },
        fecharReceita: function (row) {
            axios.put('api/receitasabertas/close', row)
                .then(response => {
                    this.$toasted.info('Receita de nº '+row.id+' fechada!')
                    this.receitas = response.data
                })
        },
        rejeitarReceita: function (row) {
            axios.put('api/receitasabertas/reject', row)
                .then(response => {
                    this.$toasted.error('Receita de nº '+row.id+' recusada!')
                    this.receitas = response.data
                })
        },
    },
    mounted() {
        this.getReceitas()
    },
}
</script>

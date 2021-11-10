<template>
    <div>
        <h1>Nova Receita</h1>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Qtd.</th>
                    <th>Medicamento</th>
                    <th class="text-right">Preço Un.</th>
                    <th class="text-right">Subtotal</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- REPETIR PARA CADA ITEM DO CARRINHO -->
                <tr v-for="medicamento in $store.state.receita" :key="medicamento.item.id">
                    <!-- Exemplo de uma linha -->
                    <td
                        class="text-right"
                        style="width:3rem;"
                    >
                        <button class="btn btn-info"
                                @click.prevent="addToReceita(medicamento.item)">+</button>
                    </td>
                    <td
                        class="text-right"
                        style="width:3rem;"
                    >
                        <button class="btn btn-secondary"
                                @click.prevent="removeFromReceita(medicamento.item)">-</button>
                    </td>
                    <td>{{ medicamento.quantity }}</td>
                    <td>{{ medicamento.item.nome }}</td>
                    <td class="text-right">{{ medicamento.item.preco }}€</td>
                    <td class="text-right">{{ parseFloat(medicamento.item.preco*medicamento.quantity).toFixed(2) }} €</td>
                    <td
                        class="text-right"
                        style="width:3rem;"
                    ><button class="btn btn-danger"
                             @click.prevent="deleteFromReceita(medicamento.item)">X</button></td>
                </tr>
                <!-- FIM DE REPETIR PARA CADA ITEM DO CARRINHO -->
                </tbody>
            </table>
        </div>
        <div class="row" v-if="$store.state.receita.length > 0">
            <div class="col-6">
                <button class="btn btn-primary btn-lg"
                        @click.prevent="confirmReceita()">Confirmar Receita</button>
            </div>
            <div class="col-6 text-right">
                <h2>Total: {{ parseFloat(totalPrice).toFixed(2) }}€</h2>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
        }
    },
    methods: {
        addToReceita: function (book) {
            this.$store.dispatch('addToReceita', book)
        },
        removeFromReceita: function (book) {
            this.$store.dispatch('removeFromReceita', book)
        },
        deleteFromReceita: function (book) {
            this.$store.dispatch('deleteFromReceita', book)
        },
        confirmReceita: function(){
            let data = {
                order:this.$store.state.receita,
                price:this.totalPrice
            }

            console.log(data)

            if(this.$store.state.receita.length > 0){
                axios.post('/api/minhasreceitas', data)
                    .then(response => {
                        this.$toasted.info('Foi criada a receita com o nº "' + response.data.id)
                        this.$store.state.receita = []
                    })
            }
        }
    },
    computed: {
        totalPrice: function () {
            let totalPrice = 0.00
            if(this.$store.state.receita.length > 0) {
                this.$store.state.receita.forEach(function (value) {
                    totalPrice += (value.item.preco * value.quantity)
                });
            }

            return totalPrice
        }
    },
    created(){
        console.log(this.$store.state.receita)
    }
}
</script>

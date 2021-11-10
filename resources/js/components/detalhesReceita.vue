<template>
    <div>
        <table class="table table-bordered table-borderless">
            <thead>
            <tr>
                <th>Qtd.</th>
                <th>Livro</th>
                <th class="text-right">Preço Un.</th>
                <th class="text-right">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <!-- REPETIR PARA CADA ITEM DA RECEITA -->
            <tr v-for="medicamento in medicamentos">
                <td>{{ medicamento.pivot.qtd }}</td>
                <td>{{ medicamento.nome }}</td>
                <td class="text-right">{{ medicamento.preco }}€</td>
                <td class="text-right">{{  parseFloat(medicamento.pivot.qtd*medicamento.pivot.preco_un).toFixed(2)  }} €</td>
            </tr>
            <!-- FIM DE REPETIR PARA CADA ITEM DA RECEITA -->
            </tbody>
        </table>
    </div>
</template>


<script>
export default {
    props:[
        'medicamentos'
    ],
}
</script>

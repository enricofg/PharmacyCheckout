<template>
    <div>
        <h2>Alterar Senha</h2>
        <div class="form-group">
            <label for="inputOldPassword">Senha Antiga</label>
            <input
                type="password"
                name="old_password"
                id="inputOldPassword"
                class="form-control"
                v-model="password.oldPassword"
            >
        </div>
        <div class="form-group">
            <label for="inputNewPassword">Nova Senha</label>
            <input
                type="password"
                name="new_password"
                id="inputNewPassword"
                class="form-control"
                v-model="password.newPassword"
            >
        </div>
        <div class="form-group">
            <label for="inputConfirmPassword">Confirmar Senha</label>
            <input
                type="password"
                name="confirm_password"
                id="inputConfirmPassword"
                class="form-control"
                v-model="confirmPassword"
            >
        </div>
        <div class="form-group">
            <a class="btn btn-primary"
               v-on:click.prevent="changePassword"
            >Entrar</a>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            password: {
                oldPassword: "",
                newPassword: ""
            },
            confirmPassword: ""
        }
    },
    methods: {
        changePassword () {
            if(this.confirmPassword === this.password.newPassword){
                axios.put('api/changepassword', this.password)
                    .then(response => {
                        console.dir(response.data)
                        this.$toasted.info('Utilizador "' + this.$store.state.user.name + '" alterou a senha!')
                        this.$router.push('/')
                    })
                    .catch(error => {
                        console.log(error)
                        this.$toasted.error("Problemas ao alterar a senha do utilizador")
                        console.dir(error)
                    })
            } else{
                this.$toasted.error("Problemas ao alterar a senha do utilizador")
            }
        }
    },
}
</script>

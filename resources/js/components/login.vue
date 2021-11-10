<template>
  <div>
    <h2>Entrar</h2>
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input
        type="email"
        name="email"
        id="inputEmail"
        placeholder="Endereço Email"
        class="form-control"
        v-model="user.email"
      >
    </div>
    <div class="form-group">
      <label for="inputPassword">Senha</label>
      <input
        type="password"
        name="password"
        id="inputPassword"
        class="form-control"
        v-model="user.password"
      >
    </div>
    <div class="form-group">
      <a
        class="btn btn-primary"
        v-on:click.prevent="login"
      >Entrar</a>
    </div>
  </div>

</template>

<script type="text/javascript">
export default {
  data: function () {
    return {
      user: {
        email: "",
        password: ""
      },
    }
  },
  methods: {
    login () {
      axios.post('api/login', this.user)
        .then(response => {
          console.dir(response.data)
          this.$toasted.info('Utilizador "' + response.data.name + '" entrou na aplicação!')
          this.$store.commit('setUser', response.data)
          this.$router.push('/')
        })
        .catch(error => {
          this.$toasted.error("Credenciais inválidas")
          console.dir(error)
        })
    }
  },
}
</script>

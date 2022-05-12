<template>
  <div class="body-inner">
      <div class="container-fluid">
          <div class="row min-vh-100">
              <div class="col-md-8 col-lg-7 d-flex align-items-center">
                  <div class="w-100 px-3 px-sm-5 px-xl-7">
                  <div class="mb-5"><h6 class="h3 mb-1">Deneme App</h6><p class="text-muted mb-0">Kullanıcı giriş sayfası</p></div>
                  <div class="form-validate" v-on:keyup.enter="login">
                      <div class="form-group">
                          <label for="email">Kullanıcı Adı</label>
                          <div class="input-group">
                              <input type="email" class="form-control" name="email" placeholder="Kullanıcı adınızı giriniz" v-model="username" autofocus="">
                          </div>
                          <pre class="text-danger pl-1" v-if="error.length">{{error}}</pre>
                          <pre class="text-danger pl-1" v-if='usernameError'>{{usernameError}}</pre>
                      </div>
                      <div class="form-group ">
                          <label for="password">Şifre</label>
                          <div class="input-group show-hide-password">
                              <input class="form-control" name="password" placeholder="Şifrenizi giriniz" type="password" v-model="password">
                          </div>
                          <pre class="text-danger pl-1" v-if='passwordError'>{{passwordError}}</pre>
                      </div>
                      <div class="mt-4">
                        <button @click="login" class="btn btn-primary btn-block btn-primary" :disabled="loader">
                          <loader v-if="loader" />
                          <span v-if="!loader">Giriş</span>
                        </button>
                      </div>
                  </div>
                  <div class="mt-4 text-center">
                    <small>Üyeliğiniz Yok mu? </small>
                    <router-link to="/register" class="small fw-bold" style="color: #007A64;">Hesap Oluştur</router-link>
                  </div>
                  </div>
              </div>
              <div class="col-md-4 col-lg-5 d-none d-md-block bg-cover" style="background: url(https://static.vecteezy.com/system/resources/previews/002/262/302/non_2x/blue-yellow-and-white-striped-pencil-background-with-copy-space-3d-render-free-photo.jpg) no-repeat right;">
              </div>
          </div>
      </div>
  </div>
</template>

<script>
    import loader from '../components/Loader'
    export default {
      data() {
        return {
          username: '',
          password: '',
          error: '',
          errors: {},
          usernameError: '',
          passwordError: '',
          loader: false
        }
      },
      components : {
        loader
      },
      methods: {
        login() {
          this.loader = true
          let data = {
            'username': this.username,
            'password': this.password
          }

          this.error = ''
          this.usernameError = ''
          this.passwordError = ''

          axios.post('api/login', data).then((response) => {
            console.log(response);
            if (!response.data.error) {
              localStorage.setItem('token', response.data.token)
              localStorage.setItem('user', JSON.stringify(response.data.user))

              this.$store.commit("setTokenAndUser", { token: response.data.token, user: response.data.user });
              window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
              this.$router.push({ name: 'Dashboard' })
            } else {
              this.error = response.data.error
            }
            this.loader = false
          }).catch((errors) => {
            this.loader = false
            this.errors = errors.response.data.errors
            this.usernameError = errors.response.data.errors.username[0]
            this.passwordError = errors.response.data.errors.password[0]
            console.log(this.errors);
          })
        }
      }
    }
</script>
<style media="screen" scoped>
  button:hover, btn:hover, btn-primary:hover, btn-block:hover, btn-primary:hover {
    background: #007A64 !important;
  }

  .container-fluid {
    padding: 0 !important
  }
</style>

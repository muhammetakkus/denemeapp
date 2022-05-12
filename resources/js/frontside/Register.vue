<template>
  <div class="body-inner">
    <FrontSideHeader></FrontSideHeader>

    <section id="page-title">
        <div class="container">
            <div class="page-title">
                <h1>Kullanıcı Kayıt</h1>
                <span>Kullanıcı Kayıt</span>
            </div>
        </div>
    </section>

    <section class="pt-2">
      <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <h3>Yeni Hesap Oluştur</h3>
                <p>Yeni Hesap Oluştur</p>
                <div id="form1" class="form-validate mt-5">
                    <div class="h5 mb-4">Kullanıcı Kayıt</div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">İsim</label>
                            <input type="text" class="form-control" name="first_name" placeholder="İsminiz" v-model="first_name" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="second_name">Soyisim</label>
                            <input type="text" class="form-control" name="second_name" placeholder="Soyisminiz" v-model="second_name" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username">Kullanıcı Giriş adınız</label>
                            <input type="text" class="form-control" name="username" placeholder="Kullanıcı Giriş Adınız" v-model="username" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Adresiniz" v-model="email" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password">Şifre</label>
                            <div class="input-group show-hide-password">
                                <input class="form-control" name="password" placeholder="Şifreniz" type="password" v-model="password" required="">
                                <span class="input-group-text"><i class="flaticon-381-lock-2" style="cursor: pointer;"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password2">Şifrenizi Teyit Edin</label>
                            <div class="input-group show-hide-password">
                                <input class="form-control" name="password2" placeholder="Şifre Tekrar" v-model="password2" type="password" required="">
                                <span class="input-group-text"><i class="flaticon-381-lock-2" style="cursor: pointer;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Kurum İsmi</label>
                            <input type="text" class="form-control" name="name" placeholder="Kurum İsminiz" v-model="kurum_name" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telephone">Telefon Numarası</label>
                            <input class="form-control" type="tel" name="telephone" placeholder="Telefon Numaranız" v-model="kurum_gsm" required="">
                        </div>
                    </div>
                    <!-- <p class="text-danger" v-if="errors.username">{{errors.username[0]}}</p> -->
                    <p class="text-danger" v-if="errors.email">{{errors.email[0]}}</p>
                    <p class="text-danger" v-if="errors.kurum_name || errors.second_name || errors.first_name || errors.username">Bütün alanları doldurunuz..</p>
                    <button type="submit" class="btn m-t-30 mt-3" @click="register">
                      <loader v-if="loader" />
                      <span v-if="!loader">Kayıt Tamamla</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </section>
  </div>
</template>

<script>
    import FrontSideHeader from '../components/FrontSideHeader'
    import loader from '../components/Loader'
    export default {
      data() {
        return {
          user: null,
          username: '',
          first_name: '',
          second_name: '',
          email: '',
          password: '',
          password2: '',
          kurum_name: '',
          kurum_gsm: '',
          errors: {},
          loader: false
        }
      },
      components: {
        FrontSideHeader, loader
      },
      methods: {
        register() {
          this.loader = true
          let data = {
            'username': this.username,
            'password': this.password,
            'first_name': this.first_name,
            'second_name': this.second_name,
            'email': this.email,
            'password': this.password,
            'kurum_name': this.kurum_name,
            'kurum_gsm': this.kurum_gsm,
          }

          axios.post('api/register', data)
          .then(response => {
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
          })
          .catch(error => {
            console.log(error);
            console.log(error.response.data.errors);
            this.errors = error.response.data.errors
            this.loader = false
          })
        }
      }
    }
</script>

<style lang="scss" scoped>

</style>

<template>
  <div class="authincation h-100">
      <div class="container h-100">
          <div class="row justify-content-center h-100 align-items-center">
              <div class="col-md-6">
                  <div class="authincation-content">
                      <div class="row no-gutters" style="margin-top: 20%">
                          <div class="col-xl-12">
                              <div class="auth-form" v-on:keyup.enter="login">
                                <div class="text-center mb-3">
                                  <!-- <a href="index.html"><img src="/template/images/logo-full.png" alt=""></a> -->
                                </div>
                                <h4 class="text-center mb-4 text-white">Admin Panel</h4>
                                <div class="form">
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>Email</strong></label>
                                        <input type="text" class="form-control" v-model="username" autofocus="">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>Password</strong></label>
                                        <input type="password" class="form-control" v-model="password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-white text-primary btn-block" @click="login">Login</button>
                                    </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
    import { mapMutations } from 'vuex'

    export default {
      data() {
        return {
          username: '',
          password: '',
          error: {},
          errors: {}
        }
      },
      methods: {
        login() {
          let data = {
            'username': this.username,
            'password': this.password
          }
          let config = {
            headers: {
              'Content-Type': 'application/json'
            }
          }
          axios.post('/api/admin/login', data, config).then((response) => {
            console.log(response.data);
            if (!response.data.error) {
              localStorage.setItem('admin_token', response.data.admin_token)
              localStorage.setItem('admin', JSON.stringify(response.data.admin))

              this.$store.commit("setAdminTokenAndAdmin", { admin_token: response.data.admin_token, admin: response.data.admin });
              window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.admin_token}`
              this.$router.push({ name: 'AdminDashboard' })
            } else {
              this.error = response.data.error
            }
          }).catch((errors) => {
            this.errors = error.response.data.errors
            console.log(this.errors);
          })
        }
      }
    }
</script>

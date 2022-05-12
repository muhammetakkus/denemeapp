<template>
    <!--**** Preloader start - template'ten kalma eğer kontrol edilebilirse kullanılabilir ******-->
    <!-- <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div> -->

    <div id="main-wrapper">

        <router-view />

    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
      data() {
        return {
        }
      },
      methods: {
        logout() {
          axios.post('/api/logout').then((response) => {
            if (this.getToken) {
              localStorage.removeItem('token')
              localStorage.removeItem('user')
              this.$store.commit('removeUser')
            }

            this.$router.push('/')
          }).catch((errors) => {
              console.log(errors)
          })
        },
        adminLogout() {
          axios.post('/api/admin/logout').then((response) => {
            if (this.getAdminToken) {
              localStorage.removeItem('admin_token')
              localStorage.removeItem('admin')
              this.$store.commit('removeAdmin')
            }
            this.$router.push('/')
          }).catch((errors) => {
              console.log(errors)
          })
        }
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getAdminToken',
        ])
      },
      mounted(){
        /* Bu iş login metodunda da yapılıyor keza login yokken uygulama mount edilince token olmadan header'a geçiliyor auth hatası veriyor */
        if (this.getAdminToken) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.getAdminToken}`
        }
        if (this.getToken) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.getToken}`
        }
      }
    }
</script>

<style media="screen">
  input {
    box-shadow: none !important;
  }
  .card-body {
    /* padding: 0 !important; */
  }
  .badge-danger {
    background-color: #ffc7c7 !important;
    color: #FF2E2E !important;
    padding: 4px 10px !important;
    cursor: pointer;
  }
  .badge-success {
    background-color: #e3f9e9 !important;
    color: #2BC155 !important;
    padding: 4px 10px !important;
    cursor: pointer;
  }
</style>

<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600">Ayarlar</h2>
              <p class="mb-0">Ayarlar Sayfası</p>
            </div>
          </div>
          <div class="row">
            <p>Düzenleniyor..</p>
          </div>

        </div>
      </div>



</template>

<script>
    import { mapGetters } from 'vuex'
    import DashboardHeader from '../components/DashboardHeader'
    export default {
      data() {
        return {
          // user: JSON.parse(localStorage.getItem('user')),
          // token: this.$store.state.token //localStorage.getItem('token')
        }
      },
      components : {
        DashboardHeader
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
    }
</script>

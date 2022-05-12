<template>
  <DashboardHeader></DashboardHeader>

  <div class="content-body">
    <div class="container-fluid">

      <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
        <div class="mr-auto">
          <h2 class="text-black font-w600">Admin Dashboard</h2>
          <p class="mb-0">Admin Dashboard</p>
        </div>
      </div>
      <div class="row">
        {{getAdminToken}}
        {{getAdmin}}
      </div>

    </div>
  </div>

</template>

<script>
    import { mapGetters } from 'vuex'
    import DashboardHeader from '../components/DashboardHeader'
    export default {
      data() {
        return {}
      },
      components : {
        DashboardHeader
      },
      computed: {
        ...mapGetters([
          'getAdminToken',
          'getAdmin',
        ])
      }
    }
</script>

<template>

  <DashboardHeader></DashboardHeader>

  <div class="content-body">
    <div class="container-fluid">

      <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
        <div class="mr-auto">
          <h2 class="text-black font-w600">Create New Period</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Create New Period</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                    <input class="form-control" type="text" v-model="period">
                </div>

                <div class="form-group row mt-4">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center" @click="createPeriod" :disabled="loader">
                            <loader v-if="loader" />
                            <span v-if="!loader">Create</span>
                        </button>
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
    import { mapGetters } from 'vuex'
    import DashboardHeader from '../components/DashboardHeader'
    import loader from '../components/Loader'
    import { useToast } from "vue-toastification";
    export default {
      setup() {
        const toast = useToast();
        return { toast }
      },
      data() {
        return {
          period: '',
          loader: false
        }
      },
      components : {
        DashboardHeader,
        loader
      },
      computed: {
        ...mapGetters([
          'getAdminToken',
          'getAdmin',
        ])
      },
      methods: {
        createPeriod() {
          this.loader = true

          let data = {
            'period': this.period
          }

          axios.post('/api/admin/create/period', data)
          .then(response => {
              this.$router.push({ name: 'Period' })
          })
          .catch(error => {
            console.log(error.response.data.errors);
            this.toast.error(error.response.data.errors.period[0]);
            this.loader = false
          })
        }
      }
    }
</script>

<style media="screen">

</style>

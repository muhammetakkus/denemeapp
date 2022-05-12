<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600 mb-2">Test</h2>
              <p class="mb-0">Default Page</p>
            </div>
          </div>

          <div class="row">
            ...
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
      data() {
        return {
          loader: false
        }
      },
      setup() {
        const toast = useToast();
        return { toast }
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
      methods: {
        getPeriods() {
          this.loader = true
          axios.get('/api/')
          .then(response => {

            this.loader = false
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
      },
      mounted(){

      }
    }
</script>

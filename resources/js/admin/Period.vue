<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600 mb-2">Admin - Periods</h2>
              <p class="mb-0">Dönemler</p>
            </div>
            <router-link to="/admin/create-period" class="btn btn-primary">
              <i class="flaticon-381-add-1 align-middle mr-2" style="position: relative; top: -1px;"></i> Create Period
            </router-link>
          </div>

          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table header-border table-responsive-sm">
                                <thead>
                                    <tr class="thead-primary">
                                        <th scope="col">#</th>
                                        <th scope="col">DÖNEM</th>
                                        <th scope="col">AKTİF</th>
                                        <th scope="col">SİL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(period, index) in periods">
                                        <td>{{index+1}}</td>
                                        <td>{{period.period}}</td>
                                        <td>
                                          <span class="badge light badge-success"
                                          @click="changePeriod(period.id, period.is_active)"
                                          v-if="period.is_active == 1">Aktif</span>

                                          <span class="badge light badge-danger"
                                          @click="changePeriod(period.id, period.is_active)"
                                          v-if="period.is_active == 0">Pasif</span>
                                        </td>
                                        <td>
                                          <span @click="deletePeriod(period.id)">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Close">
                                              <i class="fa fa-close color-danger"></i>
                                            </a>
                                          </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    export default {
      data() {
        return {
          periods: []
        }
      },
      components : {
        DashboardHeader
      },
      computed: {
        ...mapGetters([
          'getAdminToken',
          'getAdmin',
        ])
      },
      methods: {
        getPeriods() {
          axios.get('/api/periods')
          .then(response => {
            this.periods = response.data
            this.loader = false;
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        changePeriod(id, status) {
          if (status) {
              return false;
          }
          axios.post('/api/admin/update/period', {'id': id, 'status': status})
          .then(response => {
            if (response.data) {
              this.periods.forEach((item, i) => {
                if (item.is_active) {
                  item.is_active = 0
                }
                if (item.id == id) {
                  item.is_active = 1
                }
              });
            }
          })
          .catch(error => { console.log(error); })
        },
        deletePeriod(id) {
          axios.post('/api/admin/delete/period', {'id': id, 'status': status})
          .then(response => {
            if (response.data) {
              let order = 0;
              this.periods.forEach(element => {
                  if(element.id === id){
                      this.periods.splice(order, 1);
                  }
                  order++;
              }, this);
            }
          })
          .catch(error => { console.log(error); })
        }
      },
      mounted() {
        this.getPeriods()
      }
    }
</script>

<style media="screen">

</style>

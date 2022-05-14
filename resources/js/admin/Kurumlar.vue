<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600">Admin - Kurumlar</h2>
              <!-- <p class="mb-0">List Kurumlar Page</p> -->
            </div>
          </div>


          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Kurum Ara -->
                        <div class="form-group">
                          <label>Kurum ara:</label>
                          <div class="dashboard_bar">
            								<div class="input-group search-area d-lg-inline-flex">
            									<input type="text" class="form-control" placeholder="Kurum ara..." v-on:keyup.enter="search" v-model="q">
            									<div class="input-group-append" @click="search">
            										<span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
            									</div>
            								</div>
                          </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th><strong>KURUM ADI</strong></th>
                                        <th><strong>GSM</strong></th>
                                        <th><strong>HESAP SAHİBİ</strong></th>
                                        <th><strong>ONAY</strong></th>
                                        <th><strong>SİL</strong></th>
                                    </tr>
                                </thead>
                                <tbody v-if="!loader">
                                    <tr v-for="(kurum, index) in kurumlar" :key="kurum.id">
                                        <td>{{kurum.kurum_name}}</td>
                                        <td>{{kurum.kurum_gsm}}</td>
                                        <td>{{kurum.first_name}} {{kurum.second_name}}</td>
                                        <td>
                                          <span><b :class="[kurum.is_confirm ? 'text-success' : 'text-danger']">{{kurum.is_confirm}}</b> - </span>
                                          <i @click="changeStatus(kurum.id)" class="flaticon-381-controls-2 btn-primary" style="border: none !important;border-radius: 2px; padding: 3px;margin-left: 2px;cursor: pointer;"></i>
                                        </td>
                                        <td style="padding-left: 24px !important; ">
                                          <span class="text-danger" @click="deleteModal(kurum.id)" data-toggle="modal" data-target="#deleteModal">SİL</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-if="kurumlar.length == 0"  class="text-muted" style="text-align: center;">
                              <span>Listelenecek kurum bulunamadı..</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Delete Modal -->
      <div class="modal fade" id="deleteModal">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Bu kurumu silmek İstiyor musunuz?</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Vazgeç</button>
                      <button type="button" class="btn btn-danger light" data-dismiss="modal" @click="deleteKurum">Sil</button>
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
          kurumlar: [],
          kurumID: '',
          q: '',
          loader: false
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
        getKurumlar() {
          axios.get('/api/admin/kurumlar')
          .then(response => {
            this.kurumlar = response.data
          })
          .catch(error => { console.log(error); })
        },
        deleteModal(id){
          this.kurumID = id
        },
        deleteDeneme(){
          axios
          .post('/api/admin/delete/kurum', { 'id': this.kurumID })
          .then(response => {
              if(response.data) {
                  let order = 0;
                  this.kurumlar.forEach(element => {
                      if(element.id === this.kurumID){
                          this.denemeler.splice(order, 1);
                      }
                      order++;
                  }, this);
              }
          })
        },
        changeStatus(id) {
          axios
          .post('/api/admin/change-kurum-status', { 'id': id })
          .then(response => {
              if(response) {
                  this.kurumlar.forEach(element => {
                      if(element.id === id){
                          element.is_confirm = response.data
                      }
                  }, this);
              }
          })
        }
      },
      mounted(){
        this.getKurumlar();
      }
    }
</script>

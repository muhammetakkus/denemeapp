<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600">Bütün Denemeler</h2>
            </div>
            <router-link to="/yeni-deneme" class="btn btn-primary">
              <i class="flaticon-381-add-1 align-middle mr-2" style="position: relative; top: -1px;"></i> Yeni Deneme
            </router-link>
          </div>

          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <!-- Dönem Seç -->
                      <div class="form-group dropdown bootstrap-select default-select">
                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                            <label>Dönem:</label>
                            <select class="form-control form-control-lg default-select" v-model="selectedPeriod" @change="changePeriod">
                              <option v-for="period in periods" :value="period.period" :selected="activePeriod==period.period">{{period.period}}</option>
                            </select>
                        </div>
                        <!-- Deneme Ara -->
                        <div class="form-group">
                          <label>Deneme ara:</label>
                          <div class="dashboard_bar">
            								<div class="input-group search-area d-lg-inline-flex">
            									<input type="text" class="form-control" placeholder="Deneme ara..." v-on:keyup.enter="searchDeneme" v-model="q">
            									<div class="input-group-append" @click="searchDeneme">
            										<span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
            									</div>
            								</div>
                          </div>
                        </div>
                        <!-- CA Şablonu -->
                        <div class="form-group pt-4 d-flex align-items-center">
                          <!-- <a href="https://disk.yandex.com.tr/i/D0Ilf9eiWTKBOQ" target="_blank">Cevap Anahtarı Şablonu İndir</a> -->
                          <a href="javascript:void(0);" @click="downloadAnswerKeyLayout">Cevap Anahtarı Şablonu İndir</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th><strong>CEVAP ANAHTARI</strong></th>
                                        <th><strong>DENEME ADI</strong></th>
                                        <th><strong>DENEME TÜRÜ</strong></th>
                                        <th><strong>KURUMLAR</strong></th>
                                        <th style="text-align: center;"><strong>İŞLEMLER</strong></th>
                                    </tr>
                                </thead>
                                <tbody v-if="!loader">
                                    <tr v-for="(deneme, index) in denemeler.data" :key="deneme.id">
                                        <td style="padding-left: 40px;">
                                          <span v-if="deneme.answerkey" @click="downloadAnswerKey(deneme.id, deneme.deneme_name)">
                                            <span class="heart-ai bg-primary mr-3" style="font-size: 18px; padding: 8px 12px; border-radius: 2px;cursor: pointer;">
                															<i class="fa fa-download" aria-hidden="true"></i>
                														</span>
                                          </span>
                                          <span v-else>
                                            <span class="heart-ai bg-danger mr-3" style="font-size: 20px; padding: 10px 12px; border-radius: 2px;">
                															<i class="fa fa-key" aria-hidden="true"></i>
                														</span>
                                          </span>
                                        </td>
                                        <td>{{deneme.deneme_name}}</td>
                                        <td style="padding-left: 15px;">{{deneme.deneme_type}}</td>
                                        <td style="padding-left: 24px !important; ">
                                          <button @click="activeModalDeneme = deneme" type="button" class="btn btn-primary modal-button" data-toggle="modal" data-target="#basicModal" style="padding: 10px; font-size: 16px;">
                                            <i class="flaticon-381-home-2"></i>
                                          </button>
                                        </td>
                                        <td class="">
                                          <div class="dropdown d-flex justify-content-center">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" aria-expanded="false">
                                              <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                            </button>
                                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                              <router-link :to="{path: '/deneme-analiz/' + deneme.id, query: { deneme_external: 'true' }}" v-if="getUser.id != deneme.user_id" class="dropdown-item" aria-expanded="false">
                                                Denemeyi Uygula
                                              </router-link>
                                              <router-link :to="{path: '/deneme-analiz/' + deneme.id, query: { deneme_external: 'false' }}" v-else class="dropdown-item" aria-expanded="false">
                                                Denemeyi Uygula
                                              </router-link>
                                              <router-link :to="{path: '/upload-answerkey/' + deneme.id}" class="dropdown-item" aria-expanded="false" v-if="getUser.id == deneme.user_id">
                                                Cevap Anahtarı Yükle
                                              </router-link>
                                              <a class="dropdown-item" href="javascript:void(0)" v-if="getUser.id == deneme.user_id">Düzenle</a>
                															<a class="dropdown-item" href="javascript:void(0)" v-if="getUser.id == deneme.user_id" @click="askDeleteModal(deneme)" data-toggle="modal" data-target="#deleteModal">Sil</a>
                                            </div>
                                          </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-if="loader" class="text-muted" style="text-align: center;">
                              <span>Yükleniyor..</span>
                            </div>
                            <div v-if="is_search && denemeler.data.length == 0"  class="text-muted" style="text-align: center;">
                              <span>Böyle bir deneme bulunamadı..</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
              <!-- <pagination :data="denemeler" @pagination-change-page="getDenemeler"></pagination> -->
              <pagination v-model="page" :records="total" :per-page="per_page" @paginate="getDenemeler"/>
            </div>
          </div>

          <!-- Kurumlar Modal -->
          <div class="modal fade" id="basicModal">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">{{activeModalDeneme.deneme_name}} Denemesini Uygulayan Kurumlar</h5>
                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <ul>
                          <!-- <li><a href="#">Çamlıkaltı</a></li>
                          <li><a href="#">Hisar</a></li>
                          <li><a href="#">Sefaköy</a></li> -->
                        </ul>
                      </div>
                      <!-- <div class="modal-footer">
                          <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                      </div> -->
                  </div>
              </div>
          </div>
          <!-- Delete Modal -->
          <div class="modal fade" id="deleteModal">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">{{activeDeneme.deneme_name}} Denemesini Silmek İstiyor musunuz?</h5>
                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <b>{{activeDeneme.deneme_name}}</b> Kalıcı olarak silinecektir.
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Vazgeç</button>
                          <button type="button" class="btn btn-danger light" data-dismiss="modal" @click="deleteDeneme">Sil</button>
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
    // import pagination from 'laravel-vue-pagination'
    import Pagination from 'v-pagination-3';

    export default {
      data() {
        return {
          denemeler: {},
          periods: [],
          period: '',
          activeDeneme: {},
          activeModalDeneme: {},
          loader: false,
          selectedPeriod: '',
          activePeriod: '',
          q: '',
          page: 1,
          total: 0,
          per_page: 0,
          period_manuel_selection: false,
          is_search: false
        }
      },
      setup() {
        const toast = useToast();
        return { toast }
      },
      components : {
        DashboardHeader, Pagination
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
      methods: {
        // pagination için request olan linkte ?page= query string'i olmalı - controllerdaki sorgu paginate ifadesi varsa bunu oto çekiyor
        getDenemeler() {
          this.loader = true
          if (!this.period_manuel_selection && !this.is_search) { // period elle seçilmemiş ise ve arama yoksa
            console.log('getDenemeler - 1');
            axios.get(`/api/denemeler?page=${this.page}`)
            .then(response => {
              this.denemeler = response.data
              this.total = this.denemeler.total
              this.per_page = this.denemeler.per_page
              this.loader = false
            })
            .catch(error => { console.log(error); this.loader = false; })
          } else if (this.is_search) { // arama varsa
            // console.log('getDenemeler - 2');
            axios.get(`/api/denemeler/${this.selectedPeriod}?page=${this.page}&q=${this.q}`)
            .then(response => {
              console.log(this.q.length);
              this.denemeler = response.data
              console.log(this.denemeler.length);
              this.total = this.denemeler.total
              this.per_page = this.denemeler.per_page
              this.loader = false;
            })
            .catch(error => { console.log(error); this.loader = false; })
          } else { // select-option period elle seçilirse
            console.log('getDenemeler - 3');
            axios.get(`/api/denemeler/${this.period}?page=${this.page}`)
            .then(response => {
              this.denemeler = response.data
              this.total = this.denemeler.total
              this.per_page = this.denemeler.per_page
              this.loader = false
            })
            .catch(error => { console.log(error); this.loader = false; })
          }
        },
        searchDeneme(e = '') {
          // console.log(e); enter event için
          this.is_search = true
          console.log(this.q);
          this.page = 1
          this.getDenemeler()
        },
        getPeriods() {
          axios.get('/api/periods')
          .then(response => {
            this.periods = response.data
            /* the way to refresh bootstrap selectpicker */
            $(document).ready(function () {
              $('.default-select').selectpicker('refresh');
            });
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        getActivePeriod() {
          axios.get('/api/getActivePeriod')
          .then(response => {
            this.activePeriod = response.data.period
            this.selectedPeriod = response.data.period
            // bu bootstrap selectpicker ancak böyle refresh oluyor..
            $(document).ready(function () {
              $('.default-select').selectpicker('refresh');
            });
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        changePeriod(){
          console.log(this.selectedPeriod);
          this.period_manuel_selection = true
          this.period = this.selectedPeriod
          this.page = 1
          this.q = ''
          this.is_search = false
          this.getDenemeler()
        },
        askDeleteModal(deneme){
          this.activeDeneme = deneme
        },
        deleteDeneme(){
          axios
          .post('/api/delete/deneme', { 'id': this.activeDeneme.id })
          .then(response => {
              if(response.data) {

                  /* Silinen objenin arraydaki index numarasını bul ve kaldır */
                  let order = 0;
                  this.denemeler.forEach(element => {
                      if(element.id === this.activeDeneme.id){
                          this.denemeler.splice(order, 1);
                      }
                      order++;
                  }, this);

                  // if (this.q.length > 0 && this.searchData.length > 0) {
                  //     let order = 0;
                  //     this.searchData.forEach(element => {
                  //         if(element.id === this.haberID){
                  //             this.searchData.splice(order, 1);
                  //         }
                  //         order++;
                  //     }, this);
                  // }
              }
          })
        },
        async downloadAnswerKeyLayout() {
          axios.get('/api/download/answer_key_layout', {
            responseType: "blob",
          })
          .then((response) => {
            let blob = new Blob([response.data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;'
            })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'Cevap Anahtar Şablonu.xlsx'
            link.click()
          });
        },
        async downloadAnswerKey (deneme_id, deneme_name) {
          axios.get('/api/download/answerkey/'+deneme_id+'/'+this.getUser.id, {
            responseType: "blob",
          })
          .then(response => {
             const url = window.URL.createObjectURL(new Blob([response.data]));
             const link = document.createElement('a');
             link.href = url;
             link.setAttribute('download', 'CEVAP ANAHTARI - '+deneme_name+'.pdf');
             document.body.appendChild(link);
             link.click();
          })
          .catch(error => {
            // this.toast.error(error.response.data.errors.optik_form_name[0]);
            this.toast.error(error.response.data.errors);
            this.loader = false
          })
        }
      },
      async mounted(){
        this.getPeriods();
        this.getActivePeriod();
        this.getDenemeler();
      }
    }
</script>

<style media="screen">
 .container-fluid {
   padding-top: 10px !important;
 }
.card-header .dropdown-menu {
  min-width: 15.7rem !important;
}
.fa-arrow-down {
  position: absolute;
  top: 47%;
  right: 10px;
  z-index: 99;
}
.search-area {
  border: 1px solid #e4e6ef !important;
}
table tbody {
  color: #555;
  font-weight: 500
}
table thead tr th strong {
  color: #555 !important;
}
</style>

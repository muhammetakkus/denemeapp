<template>

  <DashboardHeader></DashboardHeader>

  <div class="content-body">
    <div class="container-fluid">

      <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
        <div class="mr-auto">
          <h2 class="text-black font-w600">Denemelerim</h2>
        </div>
        <router-link to="/yeni-deneme" class="btn btn-primary">
          <i class="flaticon-381-add-1 align-middle mr-2" style="position: relative; top: -1px;"></i> Yeni Deneme
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
                                    <th scope="col">CEVAP ANAHTARI</th>
                                    <th scope="col">DENEME ADI</th>
                                    <th scope="col">DENEME TÜRÜ</th>
                                    <th scope="col">RAPOR</th>
                                    <th scope="col">UYGULAMA TARİHİ</th>
                                    <!-- <th scope="col">DÖNEM</th> -->
                                    <th style="text-align: center;" scope="col">İŞLEMLER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(deneme, index) in denemeler">
                                    <td>
                                      <div style="display: flex; align-items: center;">
                                        <svg v-if="!deneme.sonuc" class="mr-3" width="8" height="30" viewBox="0 0 8 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <rect width="7.65957" height="30" fill="#ff2e2eeb"></rect>
                                        </svg>
                                        <svg class="mr-3" v-if="deneme.sonuc" width="8" height="30" viewBox="0 0 8 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <rect width="7.65957" height="30" fill="#007A64"></rect>
                                        </svg>
                                        <span>{{index+1}}</span>
                                      </div>
                                    </td>
                                    <td style="padding-left: 40px;">
                                      <span v-if="deneme.answerkey" @click="downloadAnswerKey(deneme.id, deneme.deneme_name)">
                                        <span class="heart-ai bg-primary mr-3" style="font-size: 18px; padding: 8px 12px; border-radius: 2px;cursor: pointer;">
                                          <i class="fa fa-download" aria-hidden="true"></i>
                                        </span>
                                      </span>
                                      <span v-else>
                                        <span class="heart-ai bg-danger mr-3" style="font-size: 18px; padding: 8px 12px; border-radius: 2px;cursor: not-allowed;">
                                          <i class="fa fa-key" aria-hidden="true"></i>
                                        </span>
                                      </span>
                                    </td>
                                    <td class="deneme_name">
                                      <router-link :to="{path: '/deneme-analiz/' + deneme.id}" class="ai-icon" aria-expanded="false">
                                        {{deneme.deneme_name}}
                                      </router-link>
                                    </td>
                                    <td>{{deneme.deneme_type}}</td>
                                    <td>
                                      <button @click="activeModalDeneme = deneme" v-if="deneme.sonuc" type="button" class="btn btn-primary modal-button" data-toggle="modal" data-target=".bd-example-modal-lg">Rapor</button>
                                      <span style="padding-left: 26px;" v-else>
                                        <b>-</b>
                                      </span>
                                    </td>
                                    <td>{{deneme.uygulama_tarihi}}</td>
                                    <!-- <td>{{convertDate(deneme.created_at)}}</td> -->
                                    <!-- <td>{{deneme.period.period}}</td> -->
                                    <td>
                                      <div class="dropdown d-flex justify-content-center">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" aria-expanded="false">
                                          <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                          <router-link :to="{path: '/upload-answerkey/' + deneme.id}" class="dropdown-item" aria-expanded="false" v-if="getUser.id == deneme.user_id">
                                            Cevap Anahtarı Yükle
                                          </router-link>
                                          <router-link :to="{path: '/deneme-analiz/' + deneme.id}" class="dropdown-item" aria-expanded="false">
                                            Deneme Sonucu Yükle
                                          </router-link>
                                          <a class="dropdown-item" href="javascript:void(0)" v-if="getUser.id == deneme.user_id">Düzenle</a>
                                          <a class="dropdown-item" href="javascript:void(0)" v-if="getUser.id == deneme.user_id" @click="askDeleteModal(deneme)" data-toggle="modal" data-target="#deleteModal">Sil</a>
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>


      <!-- Rapor Modal -->
      <div class="modal fade bd-example-modal-lg rapor-modal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">{{activeModalDeneme.deneme_name}} Raporlar</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li @click.prevent="generatePDF">
                        <a href="#">Sıralı Liste</a>
                        <i class="flaticon-381-download"></i>
                      </li>
                      <li>
                        <a href="#">Bireysel Karne</a>
                        <i class="flaticon-381-download"></i>
                      </li>
                      <li>
                        <a href="#">Bireysel Konu Analizli Karne</a>
                        <i class="flaticon-381-download"></i>
                      </li>
                      <li>
                        <a href="#">Son x Deneme Birleştirilmiş Karne</a>
                        <i class="flaticon-381-download"></i>
                      </li>
                      <li>
                        <a href="#">Kurum Karşılaştırmalı Rapor</a>
                        <i class="flaticon-381-download"></i>
                      </li>
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

  <!-- Loader 4 -->
  <div class="page-loader" v-if="pageLoader">
    <svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
      <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.1"/>
      </circle>
      <circle fill="#fff" stroke="none" cx="26" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.2"/>
      </circle>
      <circle fill="#fff" stroke="none" cx="46" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.3"/>
      </circle>
    </svg>
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
          denemeler: [],
          activeDeneme: {},
          activeModalDeneme: {},
          file: '',
          excelID: '',
          pageLoader: false
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
        getDenemelerim() {
          axios.get('/api/denemelerim/'+this.getUser.id)
          .then(response => {
            console.log(response.data);
            this.denemeler = response.data
            this.loader = false;
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        convertDate(timestamp) {
          let tarih = timestamp.split("T")[0].split('-');
          let year = tarih[0];
          let month = tarih[1];
          let day = tarih[2];
          let saat = timestamp.split("T")[1].substr(0,5);
          return day + '/' + month + '/' + year;
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
        async generatePDF () {
          this.pageLoader = true;
          axios.get('/api/download/sonuc/'+this.activeModalDeneme.id+'/'+this.getUser.id, {
            responseType: "blob, json",
          })
          .then(response => {
            if (response.data.error) {
              this.toast.error(response.data.error);
              this.loader = false
              this.pageLoader = false;
              return ;
            }
             const url = window.URL.createObjectURL(new Blob([response.data]));
             const link = document.createElement('a');
             link.href = url;
             link.setAttribute('download', 'Sıralı Liste.pdf');
             document.body.appendChild(link);
             link.click();
             this.pageLoader = false;
          })
          .catch(error => {
            // this.toast.error(error.response.data.errors.optik_form_name[0]);
            this.toast.error(error.response.data.errors);
            this.loader = false
            this.pageLoader = false;
          })
        },
        async downloadAnswerKeyLayout() {
          this.pageLoader = true;
          axios.get('/api/download/answer_key_layout', {
            responseType: "blob",
          })
          .then((response) => {
            let blob = new Blob([response.data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;'
            })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'x.xlsx'
            link.click()
            this.pageLoader = false;
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
      mounted(){
        this.getDenemelerim();
      }
    }
</script>

<style media="screen" scoped>
    table tr td.deneme_name a {
      text-decoration: underline;
    }

    .modal-button {
      border-radius: 2px !important;
      margin: 0 !important;
    }

    .modal-content {
      border-radius: 4px !important;
    }
</style>

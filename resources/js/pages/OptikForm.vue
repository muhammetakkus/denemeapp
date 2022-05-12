<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600 mb-2">Optik Formlar & Yeni Optik Form</h2>
              <p class="mb-0">Optik Formlarım ve Yeni Optik Form Şablonu Oluşturma</p>
            </div>

            <!-- <router-link to="/yeni-optik-form" class="btn btn-primary">
              <i class="flaticon-381-add-1 align-middle mr-2" style="position: relative; top: -1px;"></i> Yeni Optik Form
            </router-link> -->
          </div>

          <div class="row">
            <div class="col-xl-5 col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table header-border">
                              <thead>
                                  <tr class="thead-primary">
                                      <th scope="col">#</th>
                                      <th scope="col">OPTİK FORM</th>
                                      <!-- <th scope="col">OPTİK</th> -->
                                      <th style="text-align: center;" scope="col">İŞLEMLER</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="(optik, index) in optikForms">
                                      <td>{{index+1}}</td>
                                      <td>{{optik.optik_form_name}}</td>
                                      <!-- <td>{{optik.optik}}</td> -->
                                      <td class="d-flex justify-content-center">
                                        <div class="dropdown">
                                          <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" aria-expanded="false">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                          </button>
                                          <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                            <router-link :to="{path: '/optik-form-edit/' + optik.id}" class="dropdown-item" aria-expanded="false">
                                              Düzenle
                                            </router-link>
                                            <a class="dropdown-item" href="javascript:void(0)" v-if="getUser.id" @click="askDeleteModal(optik)" data-toggle="modal" data-target="#deleteModal">Sil</a>
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
            <div class="col-xl-7 col-lg-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Yeni Optik Form Şablonu</h4>
                  </div>
                  <div class="card-body">
                      <div class="basic-form ">

                              <div class="form-row justify-content-end">
                                  <div class="form-group col-12">
                                      <label>Optik Form Şablon İsmi</label>
                                      <input type="text" class="form-control" placeholder="Optik Form Adı" v-model="optik_name">
                                  </div>
                                  <div class="form-group col-12">
                                      <label>Kitapçık Başlangıç</label>
                                      <input type="number" min="0" class="form-control" placeholder="Kitapçık Başlangıç" v-model="kitapcik_start">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>TC Başlangıç</label>
                                      <input type="number" min="0" class="form-control" placeholder="TC Başlangıç" v-model="tc_start">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Öğrenci İsim Başlangıç</label>
                                      <input type="number" min="0" class="form-control" placeholder="Öğrenci İsim Başlangıç" v-model="student_name_start">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Sınıf Seviyesi Başlangıç</label>
                                      <input type="number" min="0" class="form-control" placeholder="Sınıf Seviyesi Başlangıç" v-model="class_level_start">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Sınıf Şubesi Başlangıç</label>
                                      <input type="number" min="0" class="form-control" placeholder="Sınıf Şubesi Başlangıç" v-model="class_branch_start">
                                  </div>

                                  <template v-for="(optikField, index) in optikFormData">
                                    <div class="form-group col-md-6" style="text-transform: uppercase;">
                                        <label>Optik Alanı</label>
                                        <input type="text" class="form-control" placeholder="Optik alanı" v-model="optikField.field">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Başlangıç</label>
                                        <input type="number" min="0" class="form-control" placeholder="Başlangıç" v-model="optikField.start">
                                    </div>
                                    <div class="form-group col-12">
                                      <a href="javascript:void(0)" style="text-decoration: underline;" @click="removeField(index)">Kaldır</a>
                                    </div>
                                  </template>
                                  <!-- Add Field -->
                                  <a href="javascript:void(0)" style="text-decoration: underline;" @click="addField">Alan Ekle</a>
                              </div>

                              <button type="submit" class="btn btn-primary" @click="createOptikForm">Kaydet</button>

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
                      <h5 class="modal-title">{{tempOptik.optik_form_name}} Silmek İstiyor musunuz?</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <b>{{tempOptik.optik_form_name}}</b> Şablonu kalıcı olarak silinecektir.
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Vazgeç</button>
                      <button type="button" class="btn btn-danger light" data-dismiss="modal" @click="deleteItem">Sil</button>
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
      data() {
        return {
          optikForms: [],
          optikFormData: [],
          optikFormRequiredData: [],
          tempOptik: {},
          loader: false,
          /**/
          optik_name: '',
          kitapcik_start: '',
          tc_start: '',
          student_name_start: '',
          class_level_start: '',
          class_branch_start: '',
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
        getOptikForm() {
          this.loader = true
          axios.get('/api/optik-forms/'+this.getUser.id)
          .then(response => {
            this.optikForms = response.data
            this.loader = false
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        addField(){
          if (this.optikFormData.length > 12) {
            this.toast.error('Max. Alan Sınırına Ulaştınız.');
            return;
          }
          this.optikFormData.push({ field: '', start: ''})
        },
        removeField(index){
          this.optikFormData.splice(index, 1);
        },
        createOptikForm(){
          this.loader = true
          let is_ok = true

          // Validation Ders Fields
          if (this.optikFormData.length > 0) {
            this.optikFormData.forEach(item => {
              item.field = item.field.toLocaleUpperCase('tr-TR').trim()
              if (item.field == '' || item.start != 0 && item.start == '') {
                this.toast.error('Boş alanları doldurunuz.');
                is_ok = false
                this.loader = false
                return;
              }
            })
          }

          /**/
          this.optikFormRequiredData.length = 0
          this.optikFormRequiredData.push(
            {field: 'TC', start: this.tc_start, column: 11},
            {field: 'STUDENT_NAME', start: this.student_name_start, column: 20},
            {field: 'KİTAPÇIK', start: this.kitapcik_start, column: 1},
            {field: 'CLASS_LEVEL', start: this.class_level_start, column: 1},
            {field: 'CLASS_BRANCH', start: this.class_branch_start, column: 1},
          )
          // Validation Infos
          let stop = false
          this.optikFormRequiredData.forEach(item => {
            if (stop) {
                return; // alttaki toastr 'ın bütün fieldler için uyarıyı 4 kere vermemesi için'
            }
            if (item.tc == '' || item.start == '') {
              this.toast.error('Boş alanları doldurunuz.');
              is_ok = false
              this.loader = false
              stop = true
            }
          })

          let data = {
            'optik_form_name': this.optik_name.toLocaleUpperCase('tr-TR').trim(),
            'optik': JSON.stringify(this.optikFormRequiredData.concat(this.optikFormData)),
            'user_id': this.getUser.id
          }

          if (is_ok) {
            axios.post('/api/create/optik-form', data)
            .then(response => {
              console.log(response.data);
              this.loader = false
            })
            .catch(error => {
              this.toast.error(error.response.data.errors.optik_form_name[0]);
              this.loader = false
            })            
          }

          console.log(this.optikFormRequiredData.concat(this.optikFormData));
        },
        askDeleteModal(optik){
          this.tempOptik = optik
        },
        deleteItem(){
          axios
          .post('/api/delete/optik-form', { 'id': this.tempOptik.id })
          .then(response => {
              if(response.data) {

                  /* Silinen objenin arraydaki index numarasını bul ve kaldır */
                  let order = 0;
                  this.optikForms.forEach(element => {
                      if(element.id === this.tempOptik.id){
                          this.optikForms.splice(order, 1);
                      }
                      order++;
                  }, this);

              }
          })
        },
      },
      mounted(){
        this.getOptikForm()

      }
    }
</script>

<style media="screen">
</style>

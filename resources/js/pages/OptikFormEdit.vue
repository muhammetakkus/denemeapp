<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600 mb-2">Optik Form Düzenle</h2>
              <p class="mb-0">
                <span class="back-button" @click="back()">
                  <i class="flaticon-381-back"></i> Geri
                </span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">{{optikForm.optik_form_name}} - Düzenle</h4>
                  </div>
                  <div class="card-body">
                      <div class="basic-form ">

                              <div class="form-row">
                                  <div class="form-group col-12">
                                      <label>Optik Form Şablon İsmi</label>
                                      <input type="text" class="form-control" placeholder="Optik Form Adı" v-model="optik_name">
                                  </div>
                                  <!-- <div class="form-group col-12">
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
                                  </div> -->

                                  <template v-for="(opt, index) in optik">
                                    <div class="form-group col-md-6" style="text-transform: uppercase;" >
                                        <label>{{opt.field}}</label>
                                        <input type="number" class="form-control" placeholder="Optik alanı" v-model="opt.start">
                                    </div>
                                  </template>


                              </div>

                              <div class="form-row justify-content-end">
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
                                <div>
                                  <a href="javascript:void(0)" style="text-decoration: underline;" @click="addField">Alan Ekle</a>
                                </div>
                              </div>

                              <button type="submit" class="btn btn-primary" @click="editOptikForm">Düzenlemeyi Bitir</button>

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
      data() {
        return {
          optikForm: {},
          optik: {},
          optikFormData: [],
          optikFormRequiredData: [],
          /**/
          optik_name: '',
          kitapcik_start: '',
          tc_start: '',
          student_name_start: '',
          class_level_start: '',
          class_branch_start: '',
          /**/
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
      props: ['optik_form_id'],
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
      methods: {
        getOptikForm() {
          this.loader = true
          axios.get('/api/optik-form/'+this.optik_form_id)
          .then(response => {
            this.optikForm = response.data

            this.optik = JSON.parse(this.optikForm.optik)

            this.optik_name = this.optikForm.optik_form_name

            console.log(this.optik);

            //

            this.optik.forEach((item, i) => {
              if (item.field == "KİTAPÇIK") {
                this.kitapcik_start = item.start
              }
              if (item.field == "TC") {
                this.tc_start  = item.start
              }
              if (item.field == "STUDENT_NAME") {
                this.student_name_start = item.start
              }
              if (item.field == "CLASS_LEVEL") {
                this.class_level_start = item.start
              }
              if (item.field == "CLASS_BRANCH") {
                this.class_branch_start = item.start
              }
            });


            this.loader = false
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        editOptikForm() {
          this.loader = true

          /**/
          let is_ok = true
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

          // Validation Infos
          let stop = false
          this.optik.forEach(item => {
            if (stop) {
                return; // alttaki toastr 'ın bütün fieldler için uyarıyı 4 kere vermemesi için'
            }
            if (item.start == '') {
              this.toast.error('Boş alanları doldurunuz.');
              is_ok = false
              this.loader = false
              stop = true
            }
          })

          /**/

          let data = {
            'optik_form_name': this.optik_name.toLocaleUpperCase('tr-TR').trim(),
            'optik': JSON.stringify(this.optik.concat(this.optikFormData)),
            'user_id': this.getUser.id,
            'id': this.optik_form_id
          }

          if (is_ok) {
            axios.post('/api/update/optik-form', data)
            .then(response => {
              console.log(response.data);
              this.loader = false
            })
            .catch(error => {
              this.toast.error(error.response.data.errors.optik_form_name[0]);
              this.loader = false
            })
          }
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
        back() {
          this.$router.back()
        }
      },
      mounted(){
        this.getOptikForm()
      }
    }
</script>

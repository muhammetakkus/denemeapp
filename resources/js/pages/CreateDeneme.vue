<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600">Yeni Deneme Oluştur</h2>
              <p class="mb-0">
                <a href="javascript:void(0);" @click="downloadAnswerKeyLayout">Cevap Anahtarı Şablonu İndir</a>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Yeni Deneme Oluştur</h4>
                  </div>
                  <div class="card-body">
                      <div class="basic-form">
                          <form @submit="formSubmit" enctype="multipart/form-data">
                            <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label>Deneme Adı/Deneme Başlığı/Yayını</label>
                                      <input type="text" class="form-control" placeholder="Deneme Adı/Deneme Başlığı" v-model="deneme_name">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Deneme Türü/Deneme Sınıfı</label>
                                      <input type="text" class="form-control" placeholder="Deneme Türü/Deneme Sınıfı" v-model="deneme_type">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Kaç Yanlış Bir Doğruyu Götürüyor</label>
                                      <input type="number" class="form-control" v-model="kac_yanlis_bir_dogru">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label>Deneme Uygulama Tarihi</label>
                                      <input type="date" class="form-control" v-model="uygulama_tarihi">
                                  </div>
                                  <div class="form-group col-md-6 custom_file_input">
                                    <label>Deneme Cevap Anahtarını Şimdi Yükle</label>
                                      <div class="input-group">
                                          <div class="custom-file">
                                              <input type="file" class="custom-file-input" v-on:change="onChange">
                                              <label class="custom-file-label">{{file_input_placeholder}}</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group row mt-4">
                                  <div class="col-sm-12 d-flex justify-content-end">
                                      <button type="submit" class="btn btn-primary" :disabled="loader">
                                        <loader v-if="loader" />
                                        <span v-if="!loader">Tamamla</span>
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
					  </div>

            <div class="col-12" v-if="answer_key.length > 0">
              <div class="card-body">
                  <table class="table table-responsive-sm">
                    <thead>
                      <tr style="text-align: center;">
                        <th><strong>#</strong></th>
                        <th><strong>DERS</strong></th>
                        <th><strong>SORU NO</strong></th>
                        <th><strong>CEVAP</strong></th>
                        <th><strong>B KARŞILIĞI</strong></th>
                      </tr>
                    </thead>

                    <tbody class="answers">
                      <tr v-for="(answer, index) in answer_key"  :key="index" :class="[!!answer.field == '' || !!answer.soru_no == '' || !!answer.answer == '' ? 'answer-error-line' : '']">
                        <td>{{index+1}}</td>
                        <td :class="[!!answer.field == '' ? 'empty' : '']">{{answer.field}}</td>
                        <td :class="[!!answer.soru_no == '' ? 'empty' : '']">{{answer.soru_no}}</td>
                        <td :class="[!!answer.answer == '' ? 'empty' : '']">{{answer.answer}}</td>
                        <td>{{answer.b_karsiligi}}</td>
                        <!-- <td>{{answer.konu}}</td> -->
                      </tr>

                    </tbody>
                </table>
                <!-- -->
                <div v-if="loader" style="width: 100%;" class="upload-answer-key-loader-wrapper d-flex justify-content-center">
                  <loader v-if="loader" />
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
    import readXlsxFile from 'read-excel-file'

    export default {
      data() {
        return {
          deneme_name: '',
          deneme_type: '',
          uygulama_tarihi: '',
          kac_yanlis_bir_dogru: 3,
          file: '',
          loader: false,
          file_input_placeholder: 'Cevap Anahtarını Seç..',
          answer_key: [],
          newDenemeID: '',
          is_empty: ''
        }
      },
      setup() {
        const toast = useToast();
        return { toast }
      },
      components : {
        DashboardHeader, loader
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
      methods: {
        async saveAnswerKey() {
          if (!this.answer_key.length) {
            this.toast.error('Cevap Anahtarını Seçiniz.');
            return;
          }
          if (this.is_empty) {
            this.toast.error('Boş Alanları Doldurup Cevap Anahtarını Tekrar Seçiniz.');
            return;
          }

          let data = {
            'answer_key': JSON.stringify(this.answer_key),
            'deneme_id': this.newDenemeID
          }

          await axios.post('/api/create/answer-key', data)
          .then(response => {
            console.log(response.data);
            this.file.length = 0
          })
          .catch(error => {
            console.log(error.response.data.errors);
          })
        },
        async onChange(e) {
          this.loader = true
          this.is_empty = false
          this.goAnalizButton = false

          this.file = e.target.files[0];
          let name = this.file.name.split('.')

          if (name[name.length-1] != 'xlsx') {
            this.toast.error('Cevap Anahtarı Dosyası yalnızca Excel olabilir. Lütfen Cevap Anahtarı Şablonunu İndirin');
            this.loader = false
            return ;
          }

          await readXlsxFile(e.target.files[0]).then((rows) => {
            let i = 0;
            rows.map((row, index) => {
              if (i == 0) {
                // console.log(row); // HEADER
                // 1 - ders_name
                // 2 - ders_soru_no
                // 3 - b_karşılığı
                // 4 - answers
                // 5 - konu
              }

              if (i > 0) {

                if (row[0] == null || row[1] == null || row[3] == null) {
                  console.log('boşluk var');
                  this.is_empty = true
                }
                let data = {}
                data.field = row[0].toLocaleUpperCase('tr-TR').trim()
                data.soru_no = row[1]
                data.b_karsiligi = row[2]
                data.answer = row[3].toLocaleUpperCase('tr-TR').trim()
                data.konu = row[4]

                this.answer_key.push(data)
                row.forEach((item, i) => {
                  // Exceldeki satırlar
                });
              }

              i++;
            })

            console.log(this.answer_key);
          }).catch(error => { console.log(error); })

          this.loader = false
        },
        formSubmit(e) {
          e.preventDefault();
          this.loader = true
          const config = {
              headers: {
                  'content-type': 'multipart/form-data'
              }
          }

          let data = new FormData();
          data.append('file', this.file);
          data.append('deneme_name', this.deneme_name.toLocaleUpperCase('tr-TR').trim());
          data.append('deneme_type', this.deneme_type.toLocaleUpperCase('tr-TR').trim());
          data.append('uygulama_tarihi', this.uygulama_tarihi);
          data.append('kac_yanlis_bir_dogru', this.kac_yanlis_bir_dogru);
          data.append('user_id', this.getUser.id);

          axios.post('/api/create/deneme', data)
          .then(response => {

            this.newDenemeID = response.data.id

            if (this.answer_key.length > 0) {
              this.saveAnswerKey()
            }

            this.$router.push({ name: 'Denemelerim' })
          })
          .catch(error => {
            if (error.response.data.errors.deneme_name) {
              this.toast.error(error.response.data.errors.deneme_name[0]);
              this.loader = false
              return ;
            }
            if (error.response.data.errors.deneme_type) {
              this.toast.error(error.response.data.errors.deneme_type[0]);
              this.loader = false
              return ;
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
      }
    }
</script>

<style media="screen">
.custom-file-input:lang(en) ~ .custom-file-label::after {
  content: 'SEÇ';
}
.custom-file-label::after {
  background: #007A64;
  height: auto;
  line-height: 1.9;
}
.custom-file-label {
  padding-top: 10px;
}
</style>

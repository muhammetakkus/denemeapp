<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid">

          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600 mb-2">
                <span>DENEME: </span>
                <router-link :to="{path: '/deneme-analiz/' + deneme.id}" class="ai-icon" aria-expanded="false">
                  {{deneme.deneme_name}}
                </router-link>
              </h2>
              <p class="mb-0"> Cevap Anahtarı Yükle </p>
            </div>
            <a href="javascript:void(0)" class="btn" @click="saveAnswerKey" v-if="answer_key.length && !goAnalizButton" :disabled="saveButtonLoader">
              <loader v-if="saveButtonLoader" />
              <template v-else>
                <i class="flaticon-381-upload mr-2" style="font-size: 14px; position: relative; top: 2px;"></i>
                Yükle
              </template>
            </a>
            <router-link :to="{path: '/deneme-analiz/' + deneme.id}" class="btn" v-if="goAnalizButton">
              Analiz Sayfasına Devam Et <i class="flaticon-381-fast-forward-1 align-middle ml-2" style="position: relative;"></i>
            </router-link>
          </div>

          <div class="row">
            <div class="card">
              <div class="card-header">

                  <label>Deneme Cevap Anahtarını Seç</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" onclick="this.value=null;" v-on:change="onChange">
                      <label class="custom-file-label">Cevap Anahtarını Seç..</label>
                    </div>
                  </div>

                  <!-- CA Şablonu -->
                  <div class="form-group pt-4 mb-1 d-flex align-items-center">
                    <a href="javascript:void(0);" @click="downloadAnswerKeyLayout" style="border: 1px solid #eee; padding: 5px 8px; border-radius: 5px;">Cevap Anahtarı Şablonu İndir</a>
                  </div>

              </div>
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
          answer_key: [],
          deneme: {},
          file: '',
          loader: false,
          saveButtonLoader: false,
          is_empty: false,
          goAnalizButton: false
        }
      },
      setup() {
        const toast = useToast();
        return { toast }
      },
      props: ['deneme_id'],
      components : {
        DashboardHeader, loader
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
      mounted(){
        this.getDeneme()
      },
      methods: {
        getDeneme() {
          axios.get('/api/deneme/'+this.deneme_id)
          .then(response => {
            this.deneme = response.data
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        async downloadAnswerKeyLayout() {
          axios.get('/api/download/answer_key_layout', {
            responseType: "blob",
          })
          .then((response) => {
            let blob = new Blob([response.data], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;'
            })
            console.log(blob);
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'Cevap_Anahtar_Şablonu.xlsx'
            link.click()
          });
        },
        saveAnswerKey() {
          if (!this.answer_key.length) {
            this.toast.error('Cevap Anahtarını Seçiniz.');
            return;
          }
          if (this.is_empty) {
            this.toast.error('Boş Alanları Doldurup Cevap Anahtarını Tekrar Seçiniz.');
            return;
          }

          this.saveButtonLoader = true
          let data = {
            'answer_key': JSON.stringify(this.answer_key),
            'deneme_id': this.deneme.id
          }

          axios.post('/api/create/answer-key', data)
          .then(response => {
            console.log(response.data);
            this.saveButtonLoader = false
            this.goAnalizButton = true
            this.file.length = 0
            this.toast.success('Cevap Anahtarı Başarı ile Yüklendi.');
          })
          .catch(error => {
            console.log(error.response.data.errors);
            this.saveButtonLoader = false
          })
        },
        async onChange(e) {
          this.loader = true
          this.is_empty = false
          this.goAnalizButton = false
          this.answer_key.length = 0
          let loader_loop = true

          /**/
          this.file = e.target.files[0];

          /**/
          let name = this.file.name.split('.')
          if (name[name.length-1] != 'xlsx') {
            this.toast.error('Cevap Anahtarı Dosyası yalnızca Excel olabilir. Lütfen Cevap Anahtarı Şablonunu İndirin');
            this.loader = false
            return ;
          }

          /**/
          readXlsxFile(e.target.files[0]).then((rows) => {
            let i = 0;
            let read_permission = false;

            try {
              rows.map((row, index) => {
                if (i == 0) {
                  //console.log(row); // HEADER
                  // 1 - ders_name
                  // 2 - ders_soru_no
                  // 3 - b_karşılığı
                  // 4 - answers
                  // 5 - konu
                }

                if (index == 0 && i == 0) {
                  console.log(rows[0]);
                  console.log(index);

                  if (rows[0][0] == "DERS ADI" && rows[0][1] == "DERS SORU NO" && rows[0][2] == "B KARŞILIĞI" && rows[0][3] == "CEVAP")  {
                    read_permission = true
                  }

                }

                if (read_permission) {
                  if (i > 0) {

                    if (row[0] == null || row[1] == null || row[3] == null) {
                      console.log('boşluk var');
                      this.is_empty = true
                    }
                    let data = {}
                    data.field = row[0].toLocaleUpperCase('tr-TR').trim()
                    data.soru_no = row[1]
                    data.b_karsiligi = row[2]
                    data.answer = row[3] //.toLocaleUpperCase('tr-TR').trim()
                    data.konu = row[4]

                    this.answer_key.push(data)
                    row.forEach((item, i) => {
                      // Exceldeki satırlar
                    });
                  }

                  i++;
                } else {
                  if (loader_loop) { // burada döngü dönmeye devam ediyor - error döngü adedince çıkıyor - sadece tek sefer gösterilmesi için bu şekilde çözüm üretildi
                    this.toast.error('Lütfen Cevap Anahtarı Şablon Yapısı Bozulmamış Bir Dosya Yükleyin.');
                    loader_loop = false
                  }
                  return ;
                }
              })
            } catch (e) {
              console.log(e);
              this.loader = false
              return ;
            } finally {
              this.loader = false
              console.log('finally');
              console.log(this.answer_key);
            }
          })

        },
      }
    }
</script>

<style media="screen">
  table tbody.answers tr td {
    text-align: center;
    padding-top: 2px;
    padding-bottom: 2px;
  }

  table tbody.answers tr.answer-error-line {
    background: #dc3545;
    color: #fff;
    border: 1px solid #ab0909b3;
  }

  table tbody.answers tr.answer-error-line td.empty {
    background: #ab0909b3;
    border-radius: 4px !important;
  }

  .upload-answer-key-loader-wrapper .lds-ellipsis div {
    background: #007A64;
  }
</style>

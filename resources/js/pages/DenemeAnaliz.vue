<template>

      <DashboardHeader></DashboardHeader>

      <div class="content-body">
        <div class="container-fluid analiz-wrapper">

          <!--  -->
          <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
            <div class="mr-auto">
              <h2 class="text-black font-w600">{{deneme.deneme_name}} - Deneme Analiz</h2>
              <p class="mb-0">
                <span class="back-button" @click="back()">
                  <i class="flaticon-381-back"></i> Geri
                </span>
              </p>
            </div>
          </div>

          <!--  -->
          <div class="row">
            <div class="col-12">
              <div class="card">

                  <div class="card-header">
                    <!-- Select Optik Form -->
                    <div class="form-group dropdown default-select">
                          <i class="fa fa-arrow-down" aria-hidden="true" style="top: 60%;"></i>
                          <label>Optik Form: </label>
                          <select class="form-control form-control-lg custom-select" v-model="optik_form">
                            <option value="" disabled>OPTİK FORM SEÇ</option>
                            <option v-for="optik in optikForms" :value="optik.optik_form_name">
                              {{optik.optik_form_name}}
                            </option>
                          </select>
                      </div>

                      <!-- Select FMT -->
                      <div class="form-group">
                        <label>Sonuç Yükle</label>
                          <div class="input-group">
                              <div class="custom-file">
                                  <input type="file" class="custom-file-input" onclick="this.value=null;" v-on:change="onChange">
                                  <label class="custom-file-label">{{file_input_placeholder}}</label>
                              </div>
                          </div>
                      </div>

                      <!-- Değerlendir -->
                      <div class="form-group pt-4 d-flex align-items-center">
                        <button type="button" class="btn light btn-primary" @click="degerlendir" v-if="is_answer_key_object">Değerlendir</button>
                      </div>
                  </div>

                  <div class="card-header" v-if="sonuc.length" style="display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 3rem !important;">
                    <h2 style="margin: 0;">SONUÇLAR</h2>

                    <button type="button" class="btn btn-primary modal-button" data-toggle="modal" data-target=".bd-example-modal-lg">Rapor</button>
                  </div>

                  <!-- FMT PREVIEW -->
                  <div class="card-body" v-if="allOptikData.length && sonuc.length < 1">
                      <div class="table-responsive">
                          <table class="table header-border table-hover verticle-middle">
                              <thead class="thead-primary">
                                    <th>#</th>
                                    <th v-for="(a, b) in allOptikData[0]" :class="[b=='STUDENT_NAME' ? 'column-witdth' : '']">
                                      {{b=='STUDENT_NAME' ? 'ADI-SOYADI' : b=='CLASS_LEVEL' ? 'SINIF' : b=='CLASS_BRANCH' ? 'ŞUBE' : b}}
                                    </th>
                              </thead>
                              <tbody>
                                  <tr v-for="(data, optik_field) in allOptikData">
                                      <td>{{optik_field+1}}</td>
                                      <td v-for="(val, fields) in data" :class="[!val ? 'empty' : '']">
                                        {{val}}
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  <!-- SONUÇ PREVIEW -->
                  <div class="card-body" v-if="sonuc.length">
                      <div class="table-responsive">

                            <table id="my-table" class="table header-border table-hover verticle-middle sonuc ">
                              <thead class="thead-primary">
                                    <th>NO</th>
                                    <th>İSİM SOYİSİM</th>
                                    <th v-for="(item, i) in sonuc[0].neticeler">
                                      <p>{{item.ders_name}}</p>
                                      <p class="d-y-b-n">
                                        <span> D </span>
                                        <span> Y </span>
                                        <span> B </span>
                                        <span> N </span>
                                      </p>
                                    </th>
                                    <th>
                                      <p>TOPLAM</p>
                                      <p class="d-y-b-n">
                                        <span> SS </span>
                                        <span> D </span>
                                        <span style="margin-left: 4px !important;"> Y </span>
                                        <span style="margin-left: 8px !important;"> B </span>
                                        <span style="margin-left: 12px !important;"> N </span>
                                      </p>
                                    </th>
                              </thead>
                              <tbody>
                                  <tr v-for="(item, i) in sonuc">
                                    <td style="text-align: center;">{{i+1}}</td>
                                    <td>{{item.student_name}}</td>
                                    <td v-for="(val, k) in sonuc[i].neticeler" class="true-false-net">
                                      <span>{{val.d}}</span>
                                      <span>{{val.y}}</span>
                                      <span>{{val.b}}</span>
                                      <span>{{val.n}}</span>
                                    </td>
                                    <td v-for="(val, k) in sonuc[i].toplam" class="true-false-net">
                                      <span>{{val.ss}}</span>
                                      <span>{{val.d}}</span>
                                      <span>{{val.y}}</span>
                                      <span>{{val.b}}</span>
                                      <span>{{val.n}}</span>
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
                          <h5 class="modal-title">Raporlar</h5>
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
  import Vue3Html2pdf from 'vue3-html2pdf'
  import jsPDF from 'jspdf'
  import autoTable from 'jspdf-autotable'

  export default {
      data() {
        return {
          deneme: {},
          optikForms: [],
          answer_key: '',
          is_answer_key_object: false,
          optik_form: '',
          optik: {},
          file_input_placeholder: 'Sonuç Dosyasını Seç..',
          file: '',
          allOptikData: [],
          sonuc: [],
          loader: false,
          pageLoader: false,
          has_lesson: 0
        }
      },
      props: ['deneme_id', 'deneme_uygula'],
      setup() {
        const toast = useToast();
        return { toast }
      },
      components : {
        DashboardHeader, Vue3Html2pdf
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getUser'
        ])
      },
      methods: {
        async getDeneme() {
          this.loader = true
          await axios.get('/api/deneme/'+this.deneme_id)
          .then(response => {
            this.deneme = response.data
            this.getAnswerKey();
            this.loader = false
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        getOptikForm() {
          axios.get('/api/optik-forms/'+this.getUser.id)
          .then(response => {
            this.optikForms = response.data
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        getAnswerKey() {
          axios.get('/api/answer-key/'+this.deneme.id)
          .then(response => {
            this.answer_key = JSON.parse(response.data.answer_key)
            if (typeof this.answer_key === 'object') {
              this.is_answer_key_object = true
            }
          })
          .catch(error => { console.log(error); this.loader = false; })
        },
        async onChange(e) {

          /**/
          let files = e.target.files;
          let name = files[0].name.split('.')

          if (name[name.length-1] == 'txt' || name[name.length-1] == 'fmt' || name.length == 1) {

            if (this.optik_form.length == 0) {
              e.target.value = null
              this.file_input_placeholder = 'Sonuç Dosyasını Seç..';
              this.toast.error('Önce Optik Form Seçiniz..')
              return ;
            }

            if (!this.is_answer_key_object) {
              this.toast.error('Cevap anahtarı olmayan bir denemeyi analiz etmeye çalışıyorsunuz..')
              return ;
            }

            this.sonuc.length = 0

            // Seçili Optik Form'u Parse Et
            this.optikForms.forEach((item, i) => {
              if (item.optik_form_name == this.optik_form) {
                this.optik = JSON.parse(item.optik)
              }
            });





            /* Optik Form Şablonuna Soru Adetlerini Geç [column] */
            /* hangi aralıkların okunacağının BELİRLENDİĞİ ASIL KISIM BURASI */
            this.answer_key.forEach((item, i) => {
              this.optik.forEach((val, k) => {
                if (item.field == val.field) {
                  this.optik[k].column = item.soru_no
                }
              });
            });


            /* Bu Cevap Anahtarı Seçilen Optiğe Uygun mu? - Cevap Anahtarındaki Ders isimleri optiktekilerle uyuşuyor mu? */
            let s_no = 1
            this.answer_key.forEach((item, i) => {
              /* CEVAP Excelinde DERSLER ALT ALTA LİSTELENDİĞİ İÇİN AYNI VARIABLE 1 E DÖNEREK KULLANILIYOR DERSLER AYIRT EDİLİYOR */
              if (s_no == item.soru_no) { }
              else {
                s_no = 1
              }

              // her soru_no == 1 olması yeni bir ders demek
              if (s_no == 1) {
                this.has_lesson = 0
                this.optik.forEach((opt, i) => {
                  if (opt.field == item.field) {
                    this.has_lesson = 1
                  }
                });

                if (this.has_lesson == 0) {
                  this.toast.error(`${item.field} - dersi bu optik şablonunda bulunmuyor!`);
                }
              }
              s_no++
            })


            if (e.target.files.length) {
                this.file_input_placeholder = files[0].name;
            } else {
                this.file_input_placeholder = 'Sonuç Dosyasını Seç..';
            }

            /* FMT Dosyasını Al */
            if (files.length > 0) {
              this.allOptikData.length = 0

              let text = await files[0].text();
              let lines_x = text.split(/\r\n|\n/)
              const lines = lines_x.filter((a) => a); // boş olan satırları arraydan çıkarmak için

              lines.forEach((item, i) => {
                this.compareAnswers(item) // FTM File Per Line
              });

            }

          } else {
            this.toast.error('Sonuçların bulunduğu dosya bir metin dosyası olmalı (FMT veya TXT gibi)');
            this.loader = false
            return ;
          }
        },
        compareAnswers(studentAnswers) {
          // Parse FMT
          let per_student_optik = {}
          this.optik.forEach((item, i) => {
            if (item.column) {
              per_student_optik[item.field] = this.sliceFmt(item.start, studentAnswers, item.column)
            }
          });

          /**/
          this.allOptikData.push(per_student_optik)

        },
        sliceFmt(startOf, text, columnLength){ // başlamaColumn, fmt satırı, kaç karakter sağa gidileceği
          // return text.slice(startOf-1, startOf-1+columnLength).trim();
          return text.substr(startOf-1, columnLength);
        },
        async degerlendir(){
          if (this.optik_form.length == 0) {
            this.toast.error('Optik Form Seçiniz..')
            return ;
          }

          if (this.has_lesson == 0) {
            this.toast.error('Bu deneme için uygun bir optik form şablonu seçiniz veya oluşuturunuz..')
            return ;
          }

          this.pageLoader = true

          /**/
          this.sonuc.length = 0

          /**/
          let ders_ss = 0
          let dogru = 0
          let yanlis = 0
          let bos = 0
          let veri = []
          let s_no = 1
          let kitapcik = ''
          let student_cevaplar = []

          // console.log(this.allOptikData[0]['MATEMATİK'].length);
          // console.log(this.answer_key);

          /**/
          await this.allOptikData.forEach((optik, k) => {
           if (optik['TC']) {
            /* Per Student */
            let data = { }
            data.student_name = this.allOptikData[k]['STUDENT_NAME'].trim()
            data.neticeler = []
            data.toplam = []

            this.answer_key.forEach((item, i) => {
              /* CEVAP Excelinde DERSLER ALT ALTA LİSTELENDİĞİ İÇİN AYNI VARIABLE 1 E DÖNEREK KULLANILIYOR DERSLER AYIRT EDİLİYOR */
              if (s_no == item.soru_no) { }
              else {
                s_no = 1
              }

              // her soru_no == 1 olması yeni bir ders demek
              if (s_no == 1) {
                student_cevaplar.length = 0
                dogru = 0
                yanlis = 0
                bos = 0
                student_cevaplar = optik[item.field].split('') // her bir ders için cevap anahtarı array
                // ders soru sayısı
                ders_ss = student_cevaplar.length
                kitapcik = this.allOptikData[k]['KİTAPÇIK']
              }

              // console.log(data.student_name);
              // console.log(kitapcik);
              // console.log(item); // optik
              // console.log(student_cevaplar);

              // Compare Answers - burada student_cevaplar[buradaki index] -1 yapılmalı mı? bu yanlış kontrole sebep olabilir çünkü student_cevaplar bir array soru no 20 olduğunda ?
              if (student_cevaplar[s_no] == ' ') {
                bos++
                // karşılaştırmada b karşılığı cevap anahtarında var mı diye bakılıyor halbuki öğrencinin kitapçığı b mi diye bakması lazım
              } else if (kitapcik == 'A' && student_cevaplar[s_no-1] == item.answer)  { // A kitapçığı
                dogru++
              } else if (kitapcik == 'B' && student_cevaplar[item.b_karsiligi-1] == item.answer)  { // B kitapçığı
                dogru++
              } else {
                yanlis++
              }

              // Son Soru
              if (s_no == ders_ss) {
                data.neticeler.push({
                  ders_name: item.field,
                  d: dogru,
                  y: yanlis,
                  b: bos,
                  ss: ders_ss,
                  n: Number((dogru-(yanlis/this.deneme.kac_yanlis_bir_dogru)).toFixed(2))
                })
              }

              s_no++
            });


            veri[k] = data
           }
          });


          this.sonuc = veri


          let toplam_ss = 0
          let toplam_d = 0
          let toplam_y = 0
          let toplam_b = 0
          let toplam_n = 0


          await this.sonuc.forEach((item, i) => {
              toplam_ss = item.neticeler.reduce( function(tot, record) {
                  return tot + record.ss;
              },0);
              toplam_d = item.neticeler.reduce( function(tot, record) {
                  return tot + record.d;
              },0);
              toplam_y = item.neticeler.reduce( function(tot, record) {
                  return tot + record.y;
              },0);
              toplam_b = item.neticeler.reduce( function(tot, record) {
                  return tot + record.b;
              },0);
              toplam_n = item.neticeler.reduce( function(tot, record) {
                  return tot + record.n;
              },0);
              this.sonuc[i].toplam.push({ ss: toplam_ss, d: toplam_d, y: toplam_y, b: toplam_b, n: Number(toplam_n.toFixed(2)) }) // puan buraya push edilecek
          })

          await this.sonuc.sort((a, b) => a.toplam[0].n > b.toplam[0].n ? -1 : 1)
          console.log(this.sonuc);

          this.saveResult()
        },
        saveResult() {
          if (this.$route.query.deneme_external) {
            //  başkası tarafından oluşturulmuş deneme FMT dosyası yüklenerek okunmuştur
            //  bu deneme denemelerim sayfasına yeni bir kayıtla alınmalı
            //  denemeler tablosuna is_primary diye bir column eklenebilir ilk oluşturulmuş bütün denemeler is_primary = 1 olsun
            //  başkasının oluşturduğu ve bu şekilde external olan denemeler is_primary = 0 olsun ve kopya denemeler olsun
            this.createExternalDeneme()
          } else {
            let data = {
              'result': JSON.stringify(this.sonuc),
              'user_id': this.getUser.id,
              'deneme_id': this.deneme.id
            }

            axios.post('/api/save/deneme-result', data)
            .then(response => {
              console.log(response.data);
              this.pageLoader = false
            })
            .catch(error => {
              // this.toast.error(error.response.data.errors.optik_form_name[0]);
              this.toast.error(error.response.data.errors);
              this.pageLoader = false
            })
          }
        },
        saveExternalResult(deneme_id) {
          let data = {
            'result': JSON.stringify(this.sonuc),
            'user_id': this.getUser.id,
            'deneme_id': deneme_id
          }

          axios.post('/api/save/deneme-result', data)
          .then(response => {
            console.log(response.data);
          })
          .catch(error => {
            // this.toast.error(error.response.data.errors.optik_form_name[0]);
            this.toast.error(error.response.data.errors);
            this.pageLoader = false
          })
        },
        createExternalDeneme() {
            let dublicate_data = {
              'user_id': this.getUser.id,
              'deneme': this.deneme
            }

            /* Create External Deneme - Deneme Uygula */
            axios.post('/api/dublicate/deneme', dublicate_data)
            .then(response => {
              console.log(response.data);
              this.saveExternalResult(response.data)
              this.pageLoader = false
            })
            .catch(error => {
              // this.toast.error(error.response.data.errors.optik_form_name[0]);
              console.log(error.response.data.errors);
              this.pageLoader = false
            })
        },
        async generatePDF () {
          this.pageLoader = true;
          axios.get('/api/download/sonuc/'+this.deneme.id+'/'+this.getUser.id, {
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
            this.pageLoader = false;
          })
        },
        back() {
          this.$router.back()
        }
      },

      mounted(){
        this.getDeneme();
        this.getOptikForm();
      }
    }
</script>

<style lang="scss" scoped>
 .custom-select {
    border: 1px solid #f0f1f5 !important;
    background-color: transparent !important;
    font-weight: 500 !important;
    color: #7e7e7e !important;
    cursor: pointer;
  }
  .custom-select option {
    cursor: pointer !important;
    font-size: 16px !important;
    color: #7e7e7e !important;
  }
  table tbody tr td.empty {
    background: #ab0909b3;
  }
  table tbody {
    color: #444 !important;
  }
  table thead th {
    vertical-align: middle !important;
  }
  table.sonuc thead th p {
    line-height: 0 !important;
    /* margin: 0 !important; */
    padding-bottom: 0  !important;
    font-weight: 500 !important;
    color: #fff;
  }
  table tbody tr td {
    border-color: #dadabb !important;

  }
  table tr td , table th td{ word-wrap:break-word; width:300px; }
  .analiz-wrapper table {
    border: 1px solid #ccc;
    font-size: 13px !important;
    // font-weight: 400 !important;
  }
  .analiz-wrapper table tbody tr td {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
    white-space: nowrap !important;
    // font-weight: 400 !important;
  }
  .analiz-wrapper table thead th {
    white-space: nowrap !important;
    // font-weight: 400 !important;
  }
  td.true-false-net {
    text-align: left;
    padding-left: 18px;
    span {
      padding: 0 5px;
      text-align: left;
    }
  }
  p.d-y-b-n span {
    margin-right: 4px;
  }
</style>

<template>
      <div class="nav-header">
          <router-link to="/dashboard" class="brand-logo" aria-expanded="false">
              <img class="logo-abbr" src="/template/images/logo.png" alt="">
              <img class="logo-compact" src="/template/images/logo-text.png" alt="">
              <img class="brand-title" src="/template/images/logo-text.png" alt="">
          </router-link>

          <div class="nav-control">
              <div class="hamburger">
                  <span class="line"></span><span class="line"></span><span class="line"></span>
              </div>
          </div>
      </div>

      <div class="header">
          <div class="header-content">
              <nav class="navbar navbar-expand">
                  <div class="collapse navbar-collapse justify-content-between">
                      <div class="header-left">
                          <div class="dashboard_bar"> </div>
                      </div>
                  </div>
              </nav>
          </div>
      </div>

      <!--***** Left Sidebar *****-->
      <div class="deznav">
        <div class="deznav-scroll">

          <ul class="metismenu" id="menu" v-if="getToken">
            <li>
              <router-link to="/dashboard" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-panel-2"></i>
                <span class="nav-text">Panel</span>
              </router-link>
            </li>

            <li>
              <router-link to="/denemelerim" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-file"></i>
                <span class="nav-text">Denemelerim</span>
              </router-link>
            </li>

            <li>
              <router-link to="/optik-formlar" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-file-1"></i>
                <span class="nav-text">Optik Formlar</span>
              </router-link>
            </li>

            <!-- <li>
              <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-spotlight"></i>
                <span class="nav-text">Sınıf & Öğrenci</span>
              </a>
              <ul aria-expanded="false">
                <li><router-link to="/classes">Sınıflar</router-link></li>
                <li><router-link to="/students">Öğrenciler</router-link></li>
              </ul>
            </li> -->

            <li>
              <router-link to="/settings" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">Ayarlar</span>
              </router-link>
            </li>

            <li v-if="getToken">
              <a href="javascript:void(0)" @click="logout" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-exit"></i>
                <span class="nav-text">Çıkış</span>
              </a>
            </li>
          </ul>

          <ul class="metismenu" id="admin_menu" v-if="getAdminToken">
            <li>
              <router-link to="/admin/dashboard" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-panel-2"></i>
                <span class="nav-text">Panel</span>
              </router-link>
            </li>

            <li>
              <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-spotlight"></i>
                <span class="nav-text">Sınıf & Öğrenci</span>
              </a>
              <ul aria-expanded="false">
                <li><router-link to="/admin/classes">Sınıflar</router-link></li>
                <li><router-link to="/admin/students">Öğrenciler</router-link></li>
              </ul>
            </li>

            <li>
              <router-link to="/admin/periods" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-layer"></i>
                <span class="nav-text">Periods</span>
              </router-link>
            </li>

            <li>
              <router-link to="/admin/kurumlar" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-home"></i>
                <span class="nav-text">Kurumlar</span>
              </router-link>
            </li>

            <li v-if="getAdminToken">
              <a href="javascript:void(0)" @click="adminLogout" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-exit"></i>
                <span class="nav-text">Admin Logout</span>
              </a>
            </li>
          </ul>

          <!-- <div class="copyright">  <p>Made with ♥ by DexignZone</p>  </div> -->
        </div>
      </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
      data() {
        return {
        }
      },
      methods: {
        logout() {
          axios.post('/api/logout').then((response) => {
            if (this.getToken) {
              localStorage.removeItem('token')
              localStorage.removeItem('user')
              this.$store.commit('removeUser')
            }

            this.$router.push('/')
          }).catch((errors) => {
              console.log(errors)
          })
        },
        adminLogout() {
          axios.post('/api/admin/logout').then((response) => {
            if (this.getAdminToken) {
              localStorage.removeItem('admin_token')
              localStorage.removeItem('admin')
              this.$store.commit('removeAdmin')
            }
            this.$router.push('/')
          }).catch((errors) => {
              console.log(errors)
          })
        }
      },
      computed: {
        ...mapGetters([
          'getToken',
          'getAdminToken',
        ])
      },
      mounted(){
        console.log('DashboardHeader Mounted');

        /* ####### */
        /* metisMenu Dropdown kısmı çalışmadığı için /template/js/custom.min.js kısmındaki jquery kodu buradan tekrar tetiklendi */
        Welly.init();
        Welly.load();

        /* metisMenu responsive toggle kısmı çalışmadığı için /template/js/custom.min.js kısmındaki bu iki fonksiyon buraya alındı */
        var screenWidth = $( window ).width();

        var handleNavigation = function() {
          $(".nav-control").on('click', function() {

            $('#main-wrapper').toggleClass("menu-toggle");

            $(".hamburger").toggleClass("is-active");
          });
        }

        var handleMenuTabs = function() {
          if(screenWidth <= 991 ){
            jQuery('.menu-tabs .nav-link').on('click',function(){
              if(jQuery(this).hasClass('open'))
              {
                jQuery(this).removeClass('open');
                jQuery('.fixed-content-box').removeClass('active');
                jQuery('.hamburger').show();
              }else{
                jQuery('.menu-tabs .nav-link').removeClass('open');
                jQuery(this).addClass('open');
                jQuery('.fixed-content-box').addClass('active');
                jQuery('.hamburger').hide();
              }
              //jQuery('.fixed-content-box').toggleClass('active');
            });
            jQuery('.close-fixed-content').on('click',function(){
              jQuery('.fixed-content-box').removeClass('active');
              jQuery('.hamburger').removeClass('is-active');
              jQuery('#main-wrapper').removeClass('menu-toggle');
              jQuery('.hamburger').show();
            });
          }
        }

        handleNavigation();
        handleMenuTabs();
        /* ####### */

        /* Bu iş login metodunda da yapılıyor keza login yokken uygulama mount edilince token olmadan header'a geçiliyor auth hatası veriyor */
        if (this.getAdminToken) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.getAdminToken}`
        }
        if (this.getToken) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.getToken}`
        }

      }
    }
</script>

<style media="screen">
  .deznav .metismenu li {
    cursor: pointer !important;
  }
</style>

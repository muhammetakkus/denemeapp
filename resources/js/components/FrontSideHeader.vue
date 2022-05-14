<template>
  <!-- Header -->
  <header id="header" class="header-disable-fixed">
        <div class="header-inner">
            <div class="container">
                <!--Logo-->
                <div id="logo">
                    <a href="#">
                        <span class="logo-default text-primary">DenemeApp</span>
                        <span class="logo-dark">DenemeApp</span>
                    </a>
                </div>
                <!--End: Logo-->
                <!--Navigation Resposnive Trigger-->
                <div id="mainMenu-trigger">
                    <a class="lines-button x"><span class="lines"></span></a>
                </div>
                <!--end: Navigation Resposnive Trigger-->
                <!--Navigation-->
                <div id="mainMenu">
                    <div class="container">
                        <nav>
                            <ul>
                                <li><router-link to="/">Anasayfa</router-link></li>
                                <li><router-link to="/login">Giriş</router-link></li>
                                <li><router-link to="/register">Kayıt</router-link></li>
                                <!-- <li><router-link to="/admin/login">Admin Login</router-link></li> -->

                                <!-- <li class="dropdown"><span class="dropdown-arrow"></span><a href="#">Features</a>
                                    <ul class="dropdown-menu" style="">
                                        <li class="dropdown-submenu"><span class="dropdown-arrow"></span><a href="#">Sliders</a>
                                            <ul class="dropdown-menu" style="">
                                                <li><a href="slider-revolution-slider.html">Revolution Slider</a></li>
                                                <li><a href="slider-inspiro-slider.html">Inspiro Slider</a></li>
                                                <li><a href="slider-static-media-image.html">Fullscreen Image</a></li>
                                                <li><a href="slider-static-media-parallax.html">Fullscreen Parallax</a></li>
                                                <li><a href="slider-static-media-text-rotator.html">Fullscreen Text Rotator</a></li>
                                                <li><a href="slider-static-media-video.html">Fullscreen HTML5 Video</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="widgets.html">Widgets</a></li>
                                        <li><a href="page-loaders.html">Page Loaders<span class="badge bg-danger">NEW</span></a></li>
                                        <li class="dropdown-submenu"><span class="dropdown-arrow"></span><a href="#">Modal Auto Open<span class="badge bg-danger">NEW</span></a>
                                            <ul class="dropdown-menu" style="">
                                                <li><a href="modal-auto-open-subscription.html">Subscription</a></li>
                                                <li><a href="modal-auto-open-shop.html">Shop Promotion</a></li>
                                                <li><a href="modal-auto-open-login.html">Login Form</a></li>
                                                <li><a href="modal-auto-open-audio.html">Audio Player</a></li>
                                                <li><a href="modal-auto-open-video.html">HTML5 Video</a></li>
                                                <li><a href="modal-auto-open-youtube.html">YouTube Video</a></li>
                                                <li><a href="modal-auto-open-vimeo.html">Vimeo Video</a></li>
                                                <li><a href="modal-auto-open-iframe.html">Iframe</a></li>
                                                <li><a href="modal-auto-open.html">Sample Text</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu"><span class="dropdown-arrow"></span><a href="#">Cookie Notify<span class="badge bg-danger">NEW</span></a>
                                            <ul class="dropdown-menu" style="">
                                                <li><a href="cookie-notify.html">Top position</a></li>
                                                <li><a href="cookie-notify-bottom.html">Bottom position</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="shape-dividers.html">Shape Dividers<span class="badge bg-danger">NEW</span></a></li>
                                        <li class="dropdown-submenu"><span class="dropdown-arrow"></span><a href="#">Menu Labels</a>
                                            <ul class="dropdown-menu" style="">
                                                <li><a href="#">Label (new)<span class="badge bg-danger">NEW</span></a></li>
                                                <li><a href="#">Label (hot)<span class="badge bg-danger">HOT</span></a></li>
                                                <li><a href="#">Label (popular)<span class="badge bg-success">POPULAR</span></a></li>
                                                <li><a href="#">Label (sale)<span class="badge bg-warning">SALE</span></a></li>
                                                <li><a href="#">Label (info)<span class="badge bg-info">INFO</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li> -->
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--end: Navigation-->
            </div>
        </div>
    </header>
  <!-- end: Header -->
</template>

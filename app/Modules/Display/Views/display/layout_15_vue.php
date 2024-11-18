<?php $this->section("style"); ?>
<style>
    #tanggal {
        color: white;
        font-size: 22px;
        line-height: 1;
    }

    #waktu {
        color: white;
        font-size: 48px;
        line-height: 0.5;
    }

    /* text scroller */
    #news-container-full {
        position: absolute;
        top: 90vh;
        left: 0;
        width: 100%;
        height: 10vh;
        background: #F57F17;
        z-index: 2;
        overflow: hidden;
        /*transform: translate3d(0, 0, 0);*/
    }

    .news-text {
        color: black !important;
    }

    #temperature {
        color: yellow !important;
    }

    #custom-div {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #custom-div .card-body {
        display: block;
        overflow-y: auto;
        table-layout: fixed;
        height: <?= $ccol_height . 'px'; ?>;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-dark bg-purple navbar-mb">
    <div class="container-fluid">
        <!--tanggal dan jam-->
        <div class="text-center fw-bold me-3 mt-3">
            <p id="waktu">{{jam}}</p>
            <p id="tanggal">{{tanggal}}</p>
        </div>

        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="65" />
            <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></span>
            </span>
        </a>

        <div v-if="dataCuaca != null">
            <h5 class="placeholder-glow" v-if="loading1 == true">
                <span class="placeholder col-8"></span>
            </h5>
            <h5 class="fw-bold mb-0" v-else>{{ dataCuaca.name }}, {{ dataCuaca_sys.country }}</h5>
            <h5 class="placeholder-glow" v-if="loading1 == true">
                <span class="placeholder col-12"></span>
            </h5>
            <div v-for="item in dataCuaca.weather" :key="item.id" v-else>
                <h5 class="mb-0">{{ item.main }}, {{ item.description }} <img class="mb-0" :src="'http://openweathermap.org/img/wn/' + item.icon + '.png'" height="35"></h5>
            </div>
            <p class="h1 mb-0" id="temperature">
                <strong>{{ Math.floor(dataCuaca_main.temp) }}</strong>&deg;C
            </p>
        </div>
        <div v-else>
            <h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div id="custom-div" class="card transparan-abu border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-information-variant"></i> Info & Agenda Kampus
                </div>
                <div class="card-body">
                    <div id="carousel2" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carousel2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carousel2" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div v-if="loading2 == true">
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-4"></span>
                                    </h5>
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-10"></span>
                                    </h5>
                                </div>
                                <div v-else-if="dataInfo == '' && loading2 == false">
                                    <div class="text-center">
                                        <i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i>
                                        <h5>Data Informasi masih kosong</h5>
                                    </div>
                                </div>
                                <div v-else>
                                    <ul class="list-unstyled">
                                        <li v-for="item in dataInfo" :key="item.id">
                                            {{ item.tgl_news }}
                                            <h5 class="fw-bold">{{ item.text_news }}</h5>
                                            <hr />
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div v-if="loading3 == true">
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </h5>
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-8"></span>
                                    </h5>
                                </div>
                                <div v-else-if="dataAgenda == '' && loading3 == false">
                                    <div class="text-center">
                                        <i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i>
                                        <h5>Belum ada Agenda Bulan ini</h5>
                                    </div>
                                </div>
                                <div v-else>
                                    <ul class="list-unstyled">
                                        <li v-for="item in dataAgenda" :key="item.id">
                                            <h5 class="fw-bold">{{ item.nama_agenda }}</h5>
                                            <h5>Tempat: {{ item.tempat_agenda }}</h5>
                                            <h5>Waktu: {{ item.tgl_agenda }}, {{ item.waktu }} - Selesai</h5>
                                            <hr />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card transparan text-white border-0 mb-3">
                <!-- <div class="card-header h5">
                    <i class="mdi mdi-video"></i> Video
                </div> -->
                <?php if ($video_youtube == 'no') { ?>
                    <!-- mp4 -->
                    <vue-plyr>
                        <video id="myplayer" class="ratio ratio-16x9" controls playsinline>

                        </video>
                    </vue-plyr>
                <?php } else { ?>
                    <!-- youtube -->
                    <vue-plyr>
                        <div class="plyr__video-embed" id="player">
                            <iframe src="https://www.youtube.com/embed/<?= $videoId; ?>?origin=<?= base_url(); ?>&amp;autoplay=1&amp;loop=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    </vue-plyr>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-orange text-dark border-0 h-100">
                        <div class="card-header h5">
                            <i class="mdi mdi-bullhorn"></i> Promosi
                        </div>
                        <div class="card-body p-0">
                            <div class="p-3" v-if="loading4 == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataGaleri == '' && loading4 == false">
                                <div class="alert mb-0 h5 fw-normal" role="alert">
                                    <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Galeri gambar kosong
                                </div>
                            </div>
                            <div v-else>
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataGaleri" :key="i" :data-index="i">
                                        <img :src="'<?= base_url(); ?>' + item.image_url" class="d-block w-100">
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card transparan text-white h-100">
                        <div class="card-body p-2">
                            <div v-if="loading5 == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-4"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-10"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataDosen == '' && loading5 == false">
                                <div class="mb-0 h5 fw-normal" role="alert">
                                    <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Data Dosen kosong
                                </div>
                            </div>
                            <div v-else>
                                <div id="carousel3" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators with-margin">
                                        <button type="button" data-bs-target="#carousel3" v-for="(item, i ) in dataDosen" :key="i" :data-bs-slide-to="i" :class="{ active: i==0 }" aria-current="true" :aria-label="'Slide' + i"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item" v-for="(item, i ) in dataDosen" :key="i" :class="{ active: i==0 }">
                                            <div class="d-flex justify-content-center ">
                                                <img :src="'<?= base_url() ?>' + item.foto" class="mb-3" height="100" />
                                            </div>
                                            <h4 class="fw-medium">{{ item.nama_lengkap }}</h4>
                                            <h5>{{ item.nip_nik }}</h5>
                                            <h5>{{ item.jabatan }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--teks berjalan-->
<div id="news-container-full">
    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <ul class="marquee news-text">
            <li v-for="item in dataNews" :key="item.id" style="display: inline;">
                {{ item.text_news }} &bull;
            </li>
        </ul>
    </div>
</div>

<?php $this->section("modal") ?>

<?php $this->endSection("modal") ?>

<?php $this->section("js") ?>
<script>
    //var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    function addZeroBefore(n) {
        return (n < 10 ? '0' : '') + n;
    }

    // Pusher
    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;
    var pusher = new Pusher('<?= env('PUSHER_APP_KEY'); ?>', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('my-channel');
    // End Pusher

    dataVue = {
        ...dataVue,
        layoutAktif: '<?= $layout_aktif; ?>',
        layout: "",
        tanggal: "",
        jam: "",
        dataNews: [],
        dataInfo: [],
        dataGaleri: [],
        dataAgenda: [],
        dataDosen: [],
        dataVideo: [],
        dataGaleri: [],
        dataJadwalsholat: [],
        dataCuaca: [],
        dataCuaca_weather: [],
        dataCuaca_main: [],
        dataCuaca_sys: [],
        toast: "hide",
        message: "",
    }

    createdVue = function() {
        <?php if ($use_pusher == 'no') { ?>
            setInterval(this.getLayoutAktif, 6000);
        <?php } ?>
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getVideo();
        this.getNews();
        this.getInfo();
        this.getAgenda();
        this.getGaleri();
        this.getDosen();
        this.getCuaca();
    }

    mountedVue = function() {
        <?php if ($use_pusher == 'yes') { ?>
            // Pusher Client
            // Disini fungsi auto refresh menggunakan Pusher saat admin melakukan data insert, update, delete
            channel.bind('my-event', (data) => {
                if (data.event == 'layout') {
                    location.reload();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'news') {
                    this.getNews();
                    this.getInfo();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'agenda') {
                    this.getAgenda();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'galeri') {
                    this.getGaleri();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'dosen') {
                    this.getDosen();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'cuaca') {
                    this.getCuaca();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }
            });

            //Interval Cuaca (default 15 Menit)
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000);
        <?php } else { ?>
            setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getInfo(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
            setInterval(() => this.getGaleri(), <?= $slide_refresh; ?> * 1000);
            setInterval(() => this.getDosen(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000);
        <?php } ?>
    }

    watchVue = {
        ...watchVue,
        layout: function() {
            <?php if ($use_pusher == 'no') : ?>
                if (this.layout != this.layoutAktif) {
                    location.reload();
                }
            <?php endif; ?>
        }
    }

    methodsVue = {
        ...methodsVue,
        // Get Layout
        getLayoutAktif: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/display/layoutaktif')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.layout = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        // Get Tanggal
        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const today = new Date();
            const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
            let Hari = weekday[today.getDay()];
            const Tanggal = date;
            this.tanggal = Hari + ', ' + Tanggal;
        },

        // Get Jam
        getTime: function() {
            const today = new Date();
            const time = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
            const Jam = time;
            this.jam = Jam;
        },

        // Get Cuaca
        getCuaca: function() {
            this.loading1 = true;
            axios.get('<?= base_url() ?>api/display/cuaca')
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataCuaca = data.data;
                        this.dataCuaca_weather = this.dataCuaca.weather;
                        this.dataCuaca_main = this.dataCuaca.main;
                        this.dataCuaca_sys = this.dataCuaca.sys;
                        console.log(this.dataCuaca);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        // Get News
        getNews: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/news/news')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataNews = data.data;
                        //myModal.show();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        //Get Info
        getInfo: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/news/info')
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataInfo = data.data;
                        //myModal.show();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        //Get Agenda
        getAgenda: function() {
            this.loading3 = true;
            axios.get('<?= base_url() ?>api/display/agenda')
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataAgenda = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        //Get Galeri
        getGaleri: function() {
            this.loading4 = true;
            axios.get('<?= base_url() ?>api/display/galeri')
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataGaleri = data.data;
                        //myModal.show();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        //Get Dosen
        getDosen: function() {
            this.loading5 = true;
            axios.get('<?= base_url() ?>api/display/dosen')
                .then(res => {
                    // handle success
                    this.loading5 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataDosen = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        // Get Video
        getVideo: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/display/video')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataVideo = data.data;
                        <?php if ($video_youtube == 'no') : ?>
                            this.playVideo();
                        <?php endif; ?>
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        //Play Video MP4
        playVideo: function() {
            //Video Player
            var player = document.getElementById("myplayer");
            var i = 0;
            var videoSource = this.dataVideo;
            var videoCount = videoSource.length;

            function videoPlay(videoNum) {
                player.setAttribute("src", videoSource[videoNum]);
                player.autoplay = true;
                player.muted = "<?= $video_muted; ?>";
                player.load();
                player.play();
            }
            videoPlay(0);
            player.addEventListener('ended', myHandler, false);

            function myHandler() {
                if (i == (videoCount - 1)) {
                    i = 0;
                    axios.get('<?= base_url(); ?>api/display/video')
                        .then(res => {
                            var data = res.data;
                            if (data.status == true) {
                                this.dataVideo = data.data;
                                videoSource = this.dataVideo;
                                videoCount = videoSource.length;
                            }
                        });
                    videoPlay(i);
                } else {
                    i++;
                    videoPlay(i);
                }
            }
        },
    }
</script>
<?php $this->endSection("js") ?>
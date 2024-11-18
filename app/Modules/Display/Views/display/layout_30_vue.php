<?php $this->section("style"); ?>
<style>
    .navbar-mb {
        margin-bottom: 2rem !important;
    }

    #temperature {
        color: yellow !important;
    }

    /*bottom container*/
    #tanggal-jam-full {
        position: absolute;
        bottom: 10vh;
        width: 100%;
        height: 10vh;
        padding: 5px;
        background: <?= $bgcolor_jam; ?>;
        z-index: 3;
        overflow: hidden;
    }

    /* text scroller */
    #news-container-full {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 10vh;
        background: #dc3545;
        z-index: 2;
        overflow: hidden;
        /*transform: translate3d(0, 0, 0);*/
    }
</style>
<?php $this->endSection("style") ?>

<nav class="bg-dark transparan mb-3 py-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img style="margin:0 auto;margin-right: 15px;float: left;" id="logo" class="img-responsive" src="<?= base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="75" height="55" />
                <p id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>">
                    <?= $nama_instansi; ?><br />
                <p id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></p>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-6 text-center">
                <p id="tanggal">{{tanggal}}</p>
                <p id="waktu">{{jam}}</p>
            </div>
            <div class="col-6">
                <div v-if="dataCuaca != null">
                    <h4 class="placeholder-glow" v-if="loading1 == true">
                        <span class="placeholder col-8"></span>
                    </h4>
                    <h4 class="fw-bold mb-0" v-else>{{ dataCuaca.name }}, {{ dataCuaca_sys.country }}&nbsp;
                        <span id="temperature">
                            <strong>{{ Math.floor(dataCuaca_main.temp) }}</strong>&deg;C
                        </span>
                    </h4>
                    <h4 class="placeholder-glow" v-if="loading1 == true">
                        <span class="placeholder col-12"></span>
                    </h4>
                    <div v-for="item in dataCuaca.weather" :key="item.id" v-else>
                        <h4 class="fw-normal mb-0">
                            {{ item.main }}, {{ item.description }} <img class="mb-0" :src="'http://openweathermap.org/img/wn/' + item.icon + '.png'" height="50">
                        </h4>
                    </div>
                </div>
                <div v-else>
                    <h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card bg-dark text-white border-0 h-100">
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark transparan border-0">
                <!-- <div class="card-header h5">
                    <i class="mdi mdi-image"></i> Galeri
                </div> -->
                <div class="card-body p-0">
                    <div class="p-3" v-if="loading3 == true">
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <h5 class="card-title placeholder-glow">
                            <span class="placeholder col-8"></span>
                        </h5>
                    </div>
                    <div v-else-if="dataGaleri == '' && loading3 == false">
                        <div class="alert mb-0 h5 fw-normal" role="alert">
                            <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Galeri gambar kosong
                        </div>
                    </div>
                    <div v-else>
                        <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                            <slide v-for="(item, i ) in dataGaleri" :key="i" :data-index="i">
                                <img :src="'<?= base_url(); ?>' + '/' + item.image_url" class="d-block w-100" height="<?= $vc_imageheight; ?>" :alt="item.label">
                            </slide>
                        </carousel>
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
        dataGaleri: [],
        dataVideo: [],
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
        this.getGaleri();
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
            setInterval(() => this.getGaleri(), <?= $slide_refresh; ?> * 1000);
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000); // 15 menit
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
        },
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
                        //console.log(this.dataCuaca);
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
            this.loading3 = true;
            axios.get('<?= base_url() ?>api/display/galeri')
                .then(res => {
                    // handle success
                    this.loading3 = false;
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

        //Play Video Mp4
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
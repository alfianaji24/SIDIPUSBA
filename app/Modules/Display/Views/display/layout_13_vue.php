<?php $this->section("style"); ?>
<style>
    #tanggal {
        font-size: 2vw;
        font-weight: bold;
        line-height: 1;
        border-bottom: 1px solid #aab7b8
    }

    #tanggal_arab {
        font-style: italic;
        font-weight: bold;
        font-family: serif;
        font-size: 1.8vw;
        line-height: 0.5;
    }


    #waktu {
        color: yellow;
    }

    /* text scroller */
    #news-container-full {
        position: absolute;
        top: 90vh;
        left: 0;
        width: 100%;
        height: 10vh;
        background: <?= $bgcolor_news; ?>;
        z-index: 12;
        overflow: hidden;
        /*transform: translate3d(0, 0, 0);*/
    }

    #quotes {
        font-family: serif;
        color: yellow;
        text-shadow: 2px 2px #212121;
    }
</style>
<?php $this->endSection("style") ?>

<div class="row g-0">
    <div class="col-md-3 col-lg-3">
        <div class="bg-dark transparan py-2" style="height: 100vh;">
            <!--tanggal dan jam-->
            <div class="text-center fw-bold py-3">
                <p id="waktu">{{jam}}</p>
            </div>
            <div id="waktu-sholat2">
                <?php if (!$sock = @fsockopen('www.google.com', 80)) : ?>
                    <?php if ($jadwal_sholat == 'api') { ?>
                        <div class="card border-0 mb-1">
                            <div class="card-body bg-red text-center">
                                <i class="mdi mdi-information"></i> Perhatian! Anda tidak terhubung ke Internet atau Ganti pengaturan Jadwal Sholat menjadi mode Manual Excel.
                            </div>
                        </div>
                    <?php } else { ?>

                    <?php } ?>

                <?php endif; ?>

                <div class="card transparent border-0">
                    <div class="card-body py-2 text-left text-white">
                        <i class="mdi mdi-information"></i> Data:
                        <?php if ($jadwal_sholat == 'excel') { ?>
                            Data Excel
                        <?php } else { ?>
                            API api.myquran.com
                        <?php } ?>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-night-partly-cloudy"></i></h1>
                                    <h2 class="nama-solat">Subuh</h2>
                                    <span class="waktu-solat" id="subuh">{{ dataJadwalsholat.subuh??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-sunset"></i></h1>
                                    <h2 class="nama-solat">Terbit</h2>
                                    <span class="waktu-solat" id="terbit">{{ dataJadwalsholat.terbit??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-sunny"></i></h1>
                                    <h2 class="nama-solat">Dzuhur</h2>
                                    <span class="waktu-solat" id="dzuhur">{{ dataJadwalsholat.dzuhur??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-sunny"></i></h1>
                                    <h2 class="nama-solat">Ashar</h2>
                                    <span class="waktu-solat" id="ashar">{{ dataJadwalsholat.ashar??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-sunset"></i></h1>
                                    <h2 class="nama-solat">Maghrib</h2>
                                    <span class="waktu-solat" id="maghrib">{{ dataJadwalsholat.maghrib??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-white">
                                <div v-if="loading4 == true">
                                    <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                    <h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>
                                </div>
                                <div v-else>
                                    <h1 class="float-start me-3"><i class="mdi mdi-weather-night"></i></h1>
                                    <h2 class="nama-solat">Isya</h2>
                                    <span class="waktu-solat" id="isya">{{ dataJadwalsholat.isya??"-" }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card transparent text-warning text-center border-0" :class="toast2" role="alert">
                    <div class="card-header h6 mb-0">
                        <strong class="me-auto">Menuju Waktu Sholat</strong>
                        <small></small>
                    </div>
                    <div class="card-body h3">
                        <strong>{{jelangSholat}}</strong><br />
                        {{iqomah}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9">

        <nav class="navbar navbar-light bg-white">
            <div class="container-fluid">
                <div class="ms-auto">
                    <a class="float-end navbar-brand text-decoration-none" href="#">
                        <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?> mb-3 float-end"><?= $nama_instansi; ?></span><br />
                        <span id="judul_2" class="<?= $fs_alamat; ?> float-end"><?= $alamat; ?></span>
                    </a>
                </div>
                <img id="logo" class="img-responsive float-end" src="<?= base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="70" height="70" />
            </div>
        </nav>

        <div class="navbar bg-dark transparan mb-4">
            <div class="container-fluid">
                <!--tanggal dan jam-->
                <div class="fw-bold ms-auto">
                    <span id="tanggal">{{tanggal}}</span> -
                    <span id="tanggal_arab">{{hijriah}}</span>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card d-flex justify-content-center transparan text-white border-0 h-100">
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
                <div class="col-md-6">
                    <div class="card transparan text-white border-0 mb-3 h-100">
                        <div class="card-header h5">
                            <i class="mdi mdi-mosque"></i> Info Masjid
                        </div>
                        <div class="card-body">
                            <div v-if="loading1 == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataInfo == '' && loading1 == false">
                                <h5 class="fw-normal"><i class="mdi mdi-information"></i> Belum Ada Info Masjid</h5>
                            </div>
                            <div v-else>
                                <!-- Info Vue Carousel  -->
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataInfo" :key="i" :data-index="i">
                                        <h5>{{ item.tgl_news }}</h5>
                                        <h5 class="fw-medium mb-0">{{ item.text_news }}</h5>
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pe-3" style="position: fixed;bottom: 12%;width: 74%;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card transparan text-white border-0 mb-3 h-100">
                            <div class="card-header h5">
                                <i class="mdi mdi-calendar"></i> Agenda Masjid
                            </div>
                            <div class="card-body">
                                <div v-if="loading2 == true">
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </h5>
                                    <h5 class="placeholder-glow">
                                        <span class="placeholder col-8"></span>
                                    </h5>
                                </div>
                                <div v-else-if="dataAgenda == '' && loading2 == false">
                                    <h5 class="fw-normal"><i class="mdi mdi-information"></i> Belum Ada Agenda Masjid</h5>
                                </div>
                                <div v-else>
                                    <!-- Agenda Vue Carousel  -->
                                    <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                        <slide v-for="(item, i ) in dataAgenda" :key="i" :data-index="i" class="text-start mb-5">
                                            <h4 class="fw-medium">{{ item.nama_agenda }}</h4>
                                            <h5>Tempat: {{ item.tempat_agenda }}</h5>
                                            <h5>Waktu: {{ item.tgl_agenda }}, {{ item.waktu }} - Selesai</h5>
                                        </slide>
                                    </carousel>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card transparan text-white border-0 mb-3 h-100">
                            <div class="card-header h5">
                                <i class="mdi mdi-mosque"></i> Keuangan Masjid:
                            </div>
                            <div class="card-body">
                                <h4 class="font-weight-medium">Bulan: <?= date("M Y"); ?>, Rp{{Ribuan(saldo ?? "0")}}</h4>
                                <h4 class="font-weight-medium"><i class="mdi mdi-arrow-up text-success"></i> Rp{{Ribuan(pemasukan ?? "0")}} <i class="mdi mdi-arrow-down text-danger"></i> Rp{{Ribuan(pengeluaran ?? "0")}}</h4>
                                <hr />
                                <h5>Transaksi Keuangan:</h5>
                                <div id="carousel2" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carousel2" v-for="(item, i ) in dataTransaksi" :key="i" :data-bs-slide-to="i" :class="{ active: i==0 }" aria-current="true" :aria-label="'Slide' + i"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item" v-for="(item, i ) in dataTransaksi" :key="i" :class="{ active: i==0 }">
                                            <div class="text-center mb-5">
                                                <h5 v-if="item.jenis == '1'"><i class="mdi mdi-arrow-up text-success"></i> {{item.uraian}} Rp{{Ribuan(item.pemasukan ?? "0")}}</h5>
                                                <h5 v-else><i class="mdi mdi-arrow-down text-danger"></i> {{item.uraian}} Rp{{Ribuan(item.pengeluaran ?? "0")}}</h5>
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
<script src="<?= base_url('assets/js/hijricalendar-islam.js') ?>" type="text/javascript"></script>
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
        dataVideo: [],
        dataNews: [],
        dataInfo: [],
        dataAgenda: [],
        dataAgamaQuotes: [],
        dataJadwalsholat: [],
        hijriah: "",
        waktuSholat: [],
        jelangSholat: "",
        iqomah: "",
        toast: "hide",
        toast2: "hide",
        message: "",
        dataKeuangan: [],
        dataTransaksi: [],
        pemasukan: "",
        pengeluaran: "",
        saldo: "",
    }

    createdVue = function() {
        <?php if ($use_pusher == 'no') { ?>
            setInterval(this.getLayoutAktif, 6000);
        <?php } ?>
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        setInterval(this.cekWaktuSholat, 1000);
        this.getVideo();
        this.getNews();
        this.getInfo();
        this.getAgamaQuotes();
        this.getAgenda();
        this.getKeuangan();
        this.getJadwalsholat();
        this.cekWaktuSholat();

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

                if (data.event == 'quotes') {
                    this.getAgamaQuotes();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'sholat') {
                    this.getJadwalsholat();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'keuangan') {
                    this.getKeuangan();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }
            });
        <?php } else { ?>
            setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getInfo(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
            setInterval(() => this.getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getKeuangan(), 20000);
            setInterval(() => this.getJadwalsholat(), <?= $slide_refresh; ?> * 1000);
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

        // Fungsi Ribuan
        Ribuan(key) {
            var number_string = key.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        },

        // Get Tanggal
        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const today = new Date();
            const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
            let Hari = weekday[today.getDay()];
            const Tanggal = date;
            this.tanggal = Hari + ', ' + Tanggal;
            this.hijriah = writeIslamicDate();
        },

        // Get Jam
        getTime: function() {
            const today = new Date();
            const time = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
            const Jam = time;
            this.jam = Jam;
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
            this.loading1 = true;
            axios.get('<?= base_url() ?>api/news/masjid')
                .then(res => {
                    // handle success
                    this.loading1 = false;
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

        //Get Keuangan
        getKeuangan: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/display/keuanganmasjid')
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataKeuangan = data.data;
                        this.pemasukan = this.dataKeuangan.pemasukan;
                        this.pengeluaran = this.dataKeuangan.pengeluaran;
                        this.dataTransaksi = this.dataKeuangan.keuangan;
                        this.getSaldo();
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

        getSaldo: function() {
            this.loading2 = true;
            axios.get('<?= base_url(); ?>api/display/kasmasjid')
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.saldo = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        //Get Agenda
        getAgenda: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/display/agenda')
                .then(res => {
                    // handle success
                    this.loading2 = false;
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

        //Get Quotes
        getAgamaQuotes: function() {
            this.loading3 = true;
            axios.get('<?= base_url() ?>api/display/agamaquotes')
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataAgamaQuotes = data.data;
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

        //Get Jadwal Sholat
        getJadwalsholat: function() {
            this.loading4 = true;
            axios.get('<?= base_url() ?>api/display/jadwalsholat')
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJadwalsholat = data.data;

                        if (this.dataJadwalsholat == null) {
                            this.dataJadwalsholat = [];
                            this.toast = "show";
                            this.message = "Data Jadwal Sholat bulan ini masih kosong!, lakukan import excel atau ganti ke mode API";

                            setTimeout(() => {
                                this.toast = "hide";
                            }, 4000);
                        }

                        //console.log(this.dataJadwalsholat);
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

        //Cek waktu sholat
        cekWaktuSholat: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/display/cekwaktusolat')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.waktuSholat = data.data;
                        if (this.waktuSholat != "") {
                            var now = new Date().getTime();
                            var countDownDate = new Date(this.waktuSholat.waktu).getTime();
                            var distance = countDownDate - now;
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = addZeroBefore(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                            var minutes = addZeroBefore(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
                            var seconds = addZeroBefore(Math.floor((distance % (1000 * 60)) / 1000));

                            this.jelangSholat = this.waktuSholat.jelang + ' ' + hours + ":" + minutes + ":" + seconds;

                            // Set the date we're counting down to
                            var countDownDate1 = new Date(data.data.iqomah).getTime();
                            // Get today's date and time
                            var now1 = new Date().getTime();
                            var sholat = new Date(data.data.last).getTime();
                            // Find the distance between now and the count down date
                            var distance1 = countDownDate1 - now1;
                            // Time calculations for days, hours, minutes and seconds
                            var days1 = Math.floor(distance1 / (1000 * 60 * 60 * 24));
                            var hours1 = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes1 = addZeroBefore(Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60)));
                            var seconds1 = addZeroBefore(Math.floor((distance1 % (1000 * 60)) / 1000));
                            if (now > sholat) {
                                // Display the result in the element with id="iqomah"
                                this.iqomah = "Iqomah: " + "-" + minutes1 + ":" + seconds1 + "";
                            }
                            // If the count down is finished, write some text
                            if (distance1 < 0) {
                                this.iqomah = "";
                            }

                            this.toast2 = "show";
                        } else {
                            this.toast2 = "hide";
                        }
                        //console.log(this.jelangSholat);
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
    }
</script>
<?php $this->endSection("js") ?>
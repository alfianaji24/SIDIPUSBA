<?php $this->section("style"); ?>
<style>
    #temperature {
        color: yellow !important;
    }

    #custom-div {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #custom-div .card-body.html {
        display: block;
        overflow-y: auto;
        table-layout: fixed;
        max-height: <?= $ccol_height . 'px'; ?>;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-dark bg-dark transparan navbar-mb">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="80" height="80" />
            <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></span>
            </span>
        </a>

        <div v-if="dataCuaca != null">
            <h5 class="placeholder-glow" v-if="loadingCuaca == true">
                <span class="placeholder col-8"></span>
            </h5>
            <h5 class="fw-bold mb-0" v-else>{{ dataCuaca.name }}, {{ dataCuaca_sys.country }}</h5>
            <h5 class="placeholder-glow" v-if="loadingCuaca == true">
                <span class="placeholder col-12"></span>
            </h5>
            <div v-for="item in dataCuaca.weather" :key="item.id" v-else>
                <h5 class="mb-0">{{ item.main }}, {{ item.description }} <img class="mb-0" :src="'http://openweathermap.org/img/wn/' + item.icon + '.png'" height="30"></h5>
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
        <?php foreach ($custom as $row) { ?>
            <div class="<?= $row['tipe']; ?>">
                <div id="custom-div" class="card <?= $row['bgcolor']; ?> mb-3">
                    <?php if ($row['konten'] == 'video') { ?>
                        <div class="card-body p-0">
                            <?php if ($video_youtube == 'no') { ?>
                                <vue-plyr>
                                    <video id="myplayer" class="ratio ratio-16x9" controls playsinline>

                                    </video>
                                </vue-plyr>
                            <?php } else { ?>
                                <vue-plyr>
                                    <div class="plyr__video-embed" id="player">
                                        <iframe src="https://www.youtube.com/embed/<?= $videoId; ?>?origin=<?= base_url(); ?>&amp;autoplay=1&amp;loop=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                    </div>
                                </vue-plyr>
                            <?php } ?>
                        </div>
                        <?php $this->section("script") ?>
                        this.getVideo();
                        <?php $this->endSection("script") ?>
                    <?php } else if ($row['konten'] == 'galeri') { ?>
                        <div class="card-body p-0">
                            <div class="p-3" v-if="loadingGaleri == true">
                                <h5 class="card-title placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </h5>
                                <h5 class="card-title placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataGaleri == '' && loadingGaleri == false">
                                <div class="alert mb-0 h5 fw-normal" role="alert">
                                    <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Galeri gambar kosong
                                </div>
                            </div>
                            <div v-else>
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataGaleri" :key="i" :data-index="i">
                                        <img :src="'<?= base_url(); ?>' + item.image_url" class="d-block w-100" alt="...">
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    <?php } else if ($row['konten'] == 'agenda') { ?>
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['title']; ?></h4>
                            <div v-if="loadingAgenda == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataAgenda == '' && loadingAgenda == false">
                                <div class="mb-0 h5 fw-normal" role="alert">
                                    <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum Ada Agenda Bulan ini
                                </div>
                            </div>
                            <div v-else>
                                <!-- Agenda Vue Carousel  -->
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataAgenda" :key="i" :data-index="i" class="mb-4">
                                        <h5 class="fw-bold">{{ item.nama_agenda }}</h5>
                                        <h5>Tempat: {{ item.tempat_agenda }}</h5>
                                        <h5>Waktu: {{ item.tgl_agenda }}, {{ item.waktu }} - selesai</h5>
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    <?php } else if ($row['konten'] == 'jadwalsholat') { ?>
                        <div class="card-body bg-dark text-white transparan py-2">
                            <i class="mdi mdi-information"></i>
                            <span id="tanggal_arab">{{hijriah}} </span>
                            <span>- Mode Jadwal: {{ modeSholat }}</span>
                        </div>
                        <div class="row g-0">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-red text-center text-white">
                                        <h2 class="nama-solat">Subuh</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="subuh" v-else>{{ dataJadwalsholat.subuh??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-blue-grey text-center text-white">
                                        <h2 class="nama-solat">Terbit</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="terbit" v-else>{{ dataJadwalsholat.terbit??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-cyan text-center text-white">
                                        <h2 class="nama-solat">Dzuhur</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="dzuhur" v-else>{{ dataJadwalsholat.dzuhur??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-green text-center text-white">
                                        <h2 class="nama-solat">Ashar</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="ashar" v-else>{{ dataJadwalsholat.ashar??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-orange text-center text-white">
                                        <h2 class="nama-solat">Maghrib</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="maghrib" v-else>{{ dataJadwalsholat.maghrib??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="card transparan border-0">
                                    <div class="card-body bg-pink text-center text-white">
                                        <h2 class="nama-solat">Isya</h2>
                                        <span v-if="loadingJS == true">
                                            <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                                        </span>
                                        <span class="waktu-solat" id="isya" v-else>{{ dataJadwalsholat.isya??"-" }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($row['konten'] == 'infonews') { ?>
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['title']; ?></h4>
                            <div v-if="loadingInfo == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-4"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-10"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataInfoNews == '' && loadingInfo == false">
                                <h5 class="fw-normal mb-0"><i class="mdi mdi-information"></i> Data Info Belum tersedia!</h5>
                            </div>
                            <div v-else>
                                <!-- Info Vue Carousel  -->
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataInfoNews" :key="i" :data-index="i">
                                        <h5>{{ item.tgl_news }}</h5>
                                        <h5 class="fw-medium mb-0">{{ item.text_news }}</h5>
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    <?php } else if ($row['konten'] == 'infomasjid') { ?>
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['title']; ?></h4>
                            <div v-if="loadingMasjid == true">
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </h5>
                                <h5 class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </h5>
                            </div>
                            <div v-else-if="dataInfoMasjid == '' && loadingMasjid == false">
                                <h5 class="fw-normal mb-0"><i class="mdi mdi-information"></i> Data Info Masjid Belum tersedia!</h5>
                            </div>
                            <div v-else>
                                <!-- Info Vue Carousel  -->
                                <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                                    <slide v-for="(item, i ) in dataInfoMasjid" :key="i" :data-index="i">
                                        <h5>{{ item.tgl_news }}</h5>
                                        <h5 class="fw-medium mb-0">{{ item.text_news }}</h5>
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                    <?php } else if ($row['konten'] == 'quotesagama') { ?>
                        <div class="card-body p-4">
                            <div v-if="loadingQA == true">
                                <h1 class="placeholder-glow text-center">
                                    <span class="placeholder col-10"></span>
                                    <span class="placeholder col-8"></span>
                                    <span class="placeholder col-6"></span>
                                </h1>
                            </div>
                            <div id="carousel" class="carousel slide" data-bs-ride="carousel" v-else>
                                <!-- <div class="carousel-indicators with-margin">
                                    <button type="button" data-bs-target="#carousel" v-for="(item, i ) in dataAgamaQuotes" :key="i" :data-bs-slide-to="i" :class="{ active: i==0 }" aria-current="true" :aria-label="'Slide' + i"></button>
                                </div> -->
                                <div class="carousel-inner">
                                    <div class="carousel-item" v-for="(item, i ) in dataAgamaQuotes" :key="i" :class="{ active: i==0 }">
                                        <div class="text-center">
                                            <h1 id="quotes" class="display-5 fw-medium">"{{ item.isi_quotes }}". ({{ item.suratriwayat }})</h1>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="card-header">
                            <h5 class="card-title"><?= $row['title']; ?></h5>
                        </div>
                        <div class="card-body html" @scroll="handleScroll">
                            <?= $row['konten']; ?>
                        </div>
                        <?php $this->section("script") ?>
                        this.divScroll();
                        <?php $this->endSection("script") ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!--tanggal dan jam-->
<div id="tanggal-jam" class="text-center fw-bold">
    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <p id="tanggal">{{tanggal}}</p>
        <p id="waktu">{{jam}}</p>
    </div>
</div>

<!--teks berjalan-->
<div id="news-container">
    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <ul class="marquee news-text">
            <li v-for="item in dataNews" :key="item.id" style="display: inline;">
                {{ item.text_news }} &bull;
            </li>
        </ul>
    </div>
</div>

<?php foreach ($custom as $row) { ?>
    <?php if ($row['konten'] == 'jadwalsholat') : ?>
        <div class="position-fixed bottom-0 end-0 p-2" style="z-index: 11; bottom: 10% !important;">
            <div id="liveToast" class="toast align-items-center text-dark border-0" :class="toast2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning text-dark">
                    <strong class="me-auto">Menuju Waktu Sholat</strong>
                    <small></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body h3">
                    <strong>{{jelangSholat}}</strong><br />
                    {{iqomah}}
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php } ?>

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
        layoutAktif: "<?= $layout_aktif; ?>",
        layout: "",
        tanggal: "",
        jam: "",
        loadingNews: "",
        loadingCuaca: "",
        loadingAgenda: "",
        loadingJS: "",
        loadingQA: "",
        loadingInfo: "",
        loadingMasjid: "",
        dataNews: [],
        dataGaleri: [],
        dataAgenda: [],
        dataVideo: [],
        dataCuaca: [],
        dataCuaca_weather: [],
        dataCuaca_main: [],
        dataCuaca_sys: [],
        dataAgamaQuotes: [],
        dataInfoNews: [],
        dataInfoMasjid: [],
        dataJadwalsholat: [],
        hijriah: "",
        waktuSholat: [],
        jelangSholat: "",
        iqomah: "",
        modeSholat: "",
        toast: "hide",
        toast2: "hide",
        message: "",
    }

    createdVue = function() {
        <?php if ($use_pusher == 'no') { ?>
			setInterval(this.getLayoutAktif, 6000);
		<?php } ?>
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        setInterval(this.cekWaktuSholat, 1000);
        this.getNews();
        this.getAgenda();
        this.getGaleri();
        this.getCuaca();
        this.getJadwalsholat();
        this.cekWaktuSholat();
        this.getAgamaQuotes();
        this.getInfoNews();
        this.getInfoMasjid();
        <?= $this->renderSection('script') ?>
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

                if (data.event == 'custom') {
                    location.reload();
                    this.toast = "show";
                    this.message = data.message;

                    setTimeout(() => {
                        this.toast = "hide";
                    }, 4000);
                }

                if (data.event == 'news') {
                    this.getNews();
                    this.getInfoNews();
                    this.getInfoMasjid();
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

                if (data.event == 'agenda') {
                    this.getAgenda();
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

                if (data.event == 'sholat') {
                    this.getJadwalsholat();
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
            });

            //Interval Cuaca (default 15 Menit)
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000);
        <?php } else { ?>
            setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
            setInterval(() => this.getGaleri(), <?= $slide_refresh; ?> * 1000);
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000);
            setInterval(() => this.getJadwalsholat(), <?= $slide_refresh; ?> * 1000);
            setInterval(() => this.getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getInfoNews(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getInfoMasjid(), <?= $news_refresh; ?> * 1000);
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

        //Get Tanggal
        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const today = new Date();
            const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
            let Hari = weekday[today.getDay()];
            const Tanggal = date;
            this.tanggal = Hari + ', ' + Tanggal;
            this.hijriah = writeIslamicDate();
        },

        //Get Jam
        getTime: function() {
            const today = new Date();
            const time = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
            const Jam = time;
            this.jam = Jam;
        },

        //Div Custom
        divScroll: function() {
            const wrapper = document.querySelector('.card-body')
            setInterval(() => {
                wrapper.style.scrollBehavior = 'smooth';
                wrapper.scrollTop += 20
            }, 2000)
        },
        handleScroll: function(el) {
            const wrapper = document.querySelector('.card-body')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
                //alert('bottom!')
            }
        },

        // Get News
        getNews: function() {
            this.loadingNews = true;
            axios.get('<?= base_url() ?>api/news/news')
                .then(res => {
                    // handle success
                    this.loadingNews = false;
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
            this.loadingCuaca = true;
            axios.get('<?= base_url() ?>api/display/cuaca')
                .then(res => {
                    // handle success
                    this.loadingCuaca = false;
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

        //Get Agenda
        getAgenda: function() {
            this.loadingAgenda = true;
            axios.get('<?= base_url() ?>api/display/agenda')
                .then(res => {
                    // handle success
                    this.loadingAgenda = false;
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
            this.loadingGaleri = true;
            axios.get('<?= base_url() ?>api/display/galeri')
                .then(res => {
                    // handle success
                    this.loadingGaleri = false;
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
            this.loading1 = true;
            axios.get('<?= base_url(); ?>api/display/video')
                .then(res => {
                    // handle success
                    this.loading1 = false;
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

        // Get Jadwal Sholat
        getJadwalsholat: function() {
            this.loadingJS = true;
            axios.get('<?= base_url() ?>api/display/jadwalsholat')
                .then(res => {
                    // handle success
                    this.loadingJS = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJadwalsholat = data.data;

                        if (this.dataJadwalsholat == null) {
                            this.dataJadwalsholat = [];
                            this.toast = "show";
                            this.message = "<?= lang('App.emptyJadwalSholat'); ?>";

                            setTimeout(() => {
                                this.toast = "hide";
                            }, 4000);
                        }

                        if (data.mode == 'excel') {
                            this.modeSholat = 'Data Excel';
                        } else {
                            this.modeSholat = 'API.myquran.com';
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
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/display/cekwaktusolat')
                .then(res => {
                    // handle success
                    this.loading2 = false;
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

        //Get Quotes
        getAgamaQuotes: function() {
            this.loadingQA = true;
            axios.get('<?= base_url() ?>api/display/agamaquotes')
                .then(res => {
                    // handle success
                    this.loadingQA = false;
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

        //Get Info Umum
        getInfoNews: function() {
            this.loadingInfo = true;
            axios.get('<?= base_url() ?>api/news/info')
                .then(res => {
                    // handle success
                    this.loadingInfo = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataInfoNews = data.data;
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

        //Get Info Masjid
        getInfoMasjid: function() {
            this.loadingMasjid = true;
            axios.get('<?= base_url() ?>api/news/masjid')
                .then(res => {
                    // handle success
                    this.loadingMasjid = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataInfoMasjid = data.data;
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
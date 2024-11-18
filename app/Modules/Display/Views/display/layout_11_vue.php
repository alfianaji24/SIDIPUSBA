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
        background: #000;
        z-index: 2;
        overflow: hidden;
        /*transform: translate3d(0, 0, 0);*/
    }

    #quotes {
        font-family: serif;
        color: yellow;
        text-shadow: 2px 2px #212121;
    }

    #info-agenda {
        position: absolute;
        bottom: 22vh;
        width: 100%;
        z-index: 3;
        overflow: hidden;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-dark bg-dark transparan navbar-mb">
    <div class="container-fluid">
        <!--tanggal dan jam-->
        <div class="text-center fw-bold">
            <p id="tanggal">{{tanggal}}</p>
            <p id="tanggal_arab">{{hijriah}}</p>
        </div>

        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none mx-auto" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?= base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="80" height="80" />
            <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></span>
            </span>
        </a>

        <!--tanggal dan jam-->
        <div class="text-center fw-bold">
            <p id="waktu">{{jam}}</p>
        </div>

    </div>
</nav>

<div class="container-fluid mb-5">
    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
        <!-- <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" v-for="(item, i ) in dataAgamaQuotes" :key="i" :data-bs-slide-to="i" :class="{ active: i==0 }" aria-current="true" :aria-label="'Slide' + i"></button>
                </div> -->
        <div class="carousel-inner">
            <div class="text-center" v-if="loading1 == true">
                <h1 class="placeholder-glow">
                    <span class="placeholder col-10"></span>
                </h1>
                <h1 class="placeholder-glow">
                    <span class="placeholder col-8"></span>
                </h1>
                <h1 class="placeholder-glow">
                    <span class="placeholder col-6"></span>
                </h1>
            </div>
            <div class="carousel-item" v-for="(item, i ) in dataAgamaQuotes" :key="i" :class="{ active: i==0 }" v-else>
                <div class="text-center">
                    <h1 id="quotes" class="display-4 fw-bold">"{{ item.isi_quotes }}". ({{ item.suratriwayat }})</h1>
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

<div id="info-agenda" class="container-fluid mb-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card transparan text-white border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-mosque"></i> Info Masjid
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
                    <div v-else-if="dataInfo == '' && loading2 == false">
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

        <div class="col-md-6">
            <div class="card transparan text-white border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-calendar"></i> Agenda Masjid
                </div>
                <div class="card-body">
                    <div v-if="loading3 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-8"></span>
                        </h5>
                    </div>
                    <div v-else-if="dataAgenda == '' && loading3 == false">
                        <h5 class="fw-normal"><i class="mdi mdi-information"></i> Belum Ada Agenda Masjid</h5>
                    </div>
                    <div v-else>
                        <!-- Agenda Vue Carousel  -->
                        <carousel :autoplay="true" :per-page="1" :loop="true" :autoplay-timeout="<?= $vc_autoplaytimeout; ?>">
                            <slide v-for="(item, i ) in dataAgenda" :key="i" :data-index="i" class="text-start mb-5">
                                <h5 class="fw-bold">{{ item.nama_agenda }}</h5>
                                <h5>Tempat: {{ item.tempat_agenda }}</h5>
                                <h5>Waktu: {{ item.tgl_agenda }}, {{ item.waktu }} - Selesai</h5>
                            </slide>
                        </carousel>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="waktu-sholat" class="mt-3">
    <div class="card card-body bg-dark text-white transparan py-1">
        <span><i class="mdi mdi-information"></i> Waktu sholat:
            <?php if ($jadwal_sholat == 'excel') { ?>
                Data Excel
            <?php } else { ?>
                API api.myquran.com
            <?php } ?>
        </span>
    </div>
    <div class="row g-0">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-red text-center text-white">
                    <h2 class="nama-solat">Subuh</h2>
                    <span v-if="loading4 == true">
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
                    <span v-if="loading4 == true">
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
                    <span v-if="loading4 == true">
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
                    <span v-if="loading4 == true">
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
                    <span v-if="loading4 == true">
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
                    <span v-if="loading4 == true">
                        <h1 class="placeholder-glow"><span class="placeholder col-12"></span></h1>
                    </span>
                    <span class="waktu-solat" id="isya" v-else>{{ dataJadwalsholat.isya??"-" }}</span>
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

<div class="position-fixed bottom-0 end-0 p-3" style="bottom: 23% !important;z-index: 11">
    <div id="liveToast" class="toast align-items-center text-dark border-0" :class="toast2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-dark h6 mb-0">
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
    }

    createdVue = function() {
        <?php if ($use_pusher == 'no') { ?>
			setInterval(this.getLayoutAktif, 6000);
		<?php } ?>
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        setInterval(this.cekWaktuSholat, 1000);
        this.getNews();
        this.getInfo();
        this.getAgamaQuotes();
        this.getAgenda();
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
            });
        <?php } else { ?>
            setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getInfo(), <?= $news_refresh; ?> * 1000);
            setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
            setInterval(() => this.getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
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

        //Get Quotes
        getAgamaQuotes: function() {
            this.loading1 = true;
            axios.get('<?= base_url() ?>api/display/agamaquotes')
                .then(res => {
                    // handle success
                    this.loading1 = false;
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

        //Get Info
        getInfo: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/news/masjid')
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
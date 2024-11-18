<?php $this->section("style"); ?>
<style>
    #temperature {
        color: yellow !important;
    }

    #tanggal {
        color: #212121;
    }

    #waktu {
        color: #212121;
    }

    /*bottom container*/
    #tanggal-jam {
        position: absolute;
        top: 90vh;
        width: 20%;
        height: 10vh;
        padding: 5px;
        background: yellow;
        z-index: 3;
        overflow: hidden;
    }

    #news-container {
        background-color: orange;
    }

    .news-text {
        color: #212121;
    }

    #tabel-jadwal {
        font-size: 110%;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-dark bg-green navbar-mb">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="65" />
            <span id="judul_1" class="<?= $fs_nama;?> <?= $fw_nama;?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat;?>"><?= $alamat; ?></span>
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
			<h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-warning"></i> Tidak ada koneksi internet</h5>
		</div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-0">
                <div class="card-header h5">
                    <i class="mdi mdi-video"></i> Video
                </div>
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
            <div class="card text-dark mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-calendar"></i> Jadwal Dokter Jaga
                </div>
                <div class="card-body">
                    <div v-show="dataJadwaldokterError">
                        <div class="mb-0 h4 fw-normal text-center" role="alert">
                            <i class="mdi mdi-alert-octagon-outline mdi-36px text-danger"></i><br />
                            {{dataJadwaldokterError}}
                        </div>
                    </div>

                    <h5>Hari Ini: <strong>{{tanggal}}</strong></h5>

                    <div v-if="dataJadwaldokter == '' && loading3 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </h5>
                    </div>
                    <div v-if="dataJadwaldokter.error">
                        <div class="mb-0 h4 fw-normal text-center" role="alert">
                            <i class="mdi mdi-alert-octagon-outline mdi-36px text-danger"></i><br />
                            {{dataJadwaldokter.error}}
                        </div>
                    </div>
                    <div class="tabel-jadwal" v-else>
                        <table class="table">
                            <thead v-show="dataJadwaldokter != ''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Dokter</th>
                                    <th scope="col">Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in dataJadwaldokter" :key="item.id">
                                    <td>{{item.mulai}}-{{item.selesai}}</td>
                                    <td>{{item.nama_lengkap}}</td>
                                    <td>{{item.nama_ruang}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card transparan text-white border-0 mt-3">
        <div class="card-header h5">
            <i class="mdi mdi-information"></i> Informasi
        </div>
        <div class="card-body">
            <div v-if="loading4 == true">
                <h5 class="placeholder-glow">
                    <span class="placeholder col-4"></span>
                </h5>
                <h5 class="placeholder-glow">
                    <span class="placeholder col-10"></span>
                </h5>
            </div>
            <div v-else-if="dataInfo == '' && loading4 == false">
                <div class="mb-0 h5 fw-normal text-white" role="alert">
                    <i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Data Informasi kosong
                </div>
            </div>
            <div v-else>
                <div class="row">
                    <div class="col" v-for="item in dataInfo" :key="item.id">
                        <h5 class="mb-0 text-white">{{ item.tgl_news }}</h5>
                        <h5 class="fw-medium text-white">{{ item.text_news }}</h5>
                    </div>
                </div>
            </div>
        </div>
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
        dataVideo: [],
        dataCuaca: [],
        dataCuaca_weather: [],
        dataCuaca_main: [],
        dataCuaca_sys: [],
        dataJampelayanan: [],
        dataJampelayananError: "",
        dataLayanan: [],
        dataJadwaldokter: [],
        dataJadwaldokterError: "", 
        id_jam: "",
        jam_ke: "",
        range_jam: "",
        hariini: "",
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
        this.getJampel();
        this.getInfo();
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
            setInterval(() => this.getCuaca(), <?= $cuaca_refresh; ?> * 1000);
		<?php } ?>

        // Interval Jampel
        setInterval(() => this.getJampel(), <?= $news_refresh; ?> * 1000);
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
        
        //Get Tanggal
        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const today = new Date();
            const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
            let Hari = weekday[today.getDay()];
            const Tanggal = date;
            this.tanggal = Hari + ', ' + Tanggal;
        },

        //Get Jam
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

        // Get Jam Pelayanan
        getJampel: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/display/jampelayanan')
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    var jam_ke = 0;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJampelayanan = data.data;
                        this.id_jam = this.dataJampelayanan.id_jam;
                        this.jam_ke = this.dataJampelayanan.jam_ke;
                        this.range_jam = this.dataJampelayanan.range_jam;
                        if (this.jam_ke != jam_ke) {
                            this.getLayanan();
                            this.getJadwalDokter();
                        } else {
                            this.dataJampelayananError = "Tidak ada data jam pelayanan.";
                        }
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

        // Get Layanan
        getLayanan: function() {
            this.loading2 = true;
            axios.get(`<?= base_url() ?>api/display/harilayanan?id=${this.id_jam}`)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataLayanan = data.data;
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

        // Get Jadwal Dokter
        getJadwalDokter: function() {
            this.loading3 = true;
            const weekday = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];
            const today = new Date();
            let hariini = weekday[today.getDay()];
            axios.get(`<?= base_url() ?>api/display/jadwaldokter2?hari=${hariini}`)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJadwaldokter = data.data;
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
            this.loading4 = true;
            axios.get('<?= base_url() ?>api/news/info')
                .then(res => {
                    // handle success
                    this.loading4 = false;
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
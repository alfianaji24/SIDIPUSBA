<?php $this->section("style"); ?>
<style>
    #temperature {
        color: yellow !important;
    }

    table {
        width: 100%;
    }

    thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    tbody {
        display: block;
        overflow-y: auto;
        table-layout: fixed;
        max-height: 250px;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-dark bg-blue navbar-mb">
    <div class="container-fluid">
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
    <div class="card text-primary mb-3">
        <div class="card-body">
            <h2 class="card-title fw-bold text-center mb-0">JADWAL PELAJARAN</h2>
        </div>
    </div>
    <div class="row row-cols-3">
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">SENIN</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="senin" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalSenin !=''" @scroll="tableSeninScroll">
                                <tr v-for="item in jadwalSenin" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">SELASA</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="selasa" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalSelasa !=''" @scroll="tableSelasaScroll">
                                <tr v-for="item in jadwalSelasa" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">RABU</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="rabu" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalRabu !=''" @scroll="tableRabuScroll">
                                <tr v-for="item in jadwalRabu" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">KAMIS</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="kamis" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalKamis !=''" @scroll="tableKamisScroll">
                                <tr v-for="item in jadwalKamis" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">JUM'AT</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="jumat" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalJumat !=''" @scroll="tableJumatScroll">
                                <tr v-for="item in jadwalJumat" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">SABTU</h5>
                    <div v-if="dataJadwalpelajaran == '' && loading2 == true">
                        <h5 class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </h5>
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <div v-else>
                        <table id="sabtu" class="table">
                            <thead v-show="dataJadwalpelajaran !=''">
                                <tr>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody v-if="jadwalSabtu !=''" @scroll="tableSabtuScroll">
                                <tr v-for="item in jadwalSabtu" :key="item.id">
                                    <td>{{ item.mulai}} - {{item.selesai}}</td>
                                    <td>{{ item.nama_lengkap }}</td>
                                    <td>{{ item.nama_kelas}}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3"><i class="mdi mdi-alert-octagon-outline text-danger"></i> Tidak ada Jadwal Pelajaran</td>
                                </tr>
                            </tbody>
                        </table>
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
        dataCuaca: [],
        dataCuaca_weather: [],
        dataCuaca_main: [],
        dataCuaca_sys: [],
        dataJampelajaran: [],
        dataJampelajaranError: "",
        dataKegiatanbelajar: [],
        dataJadwalpelajaran: [],
        jadwalSenin: [],
        jadwalSelasa: [],
        jadwalRabu: [],
        jadwalKamis: [],
        jadwalJumat: [],
        jadwalSabtu: [],
        id_jam: "",
        jam_ke: "",
        range_jam: "",
        toast: "hide",
		message: "",
    }

    createdVue = function() {
        <?php if ($use_pusher == 'no') { ?>
			setInterval(this.getLayoutAktif, 6000);
		<?php } ?>
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getNews();
        this.getJadwalpelajaran();
        this.getJampel();
        this.getCuaca();
        this.tableJadwalSenin();
        this.tableJadwalSelasa();
        this.tableJadwalRabu();
        this.tableJadwalKamis();
        this.tableJadwalJumat();
        this.tableJadwalSabtu();
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

        // Interval
        setInterval(() => this.getJadwalpelajaran(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.tableJadwalSenin(), 2000);
        setInterval(() => this.tableJadwalSelasa(), 2000);
        setInterval(() => this.tableJadwalRabu(), 2000);
        setInterval(() => this.tableJadwalKamis(), 2000);
        setInterval(() => this.tableJadwalJumat(), 2000);
        setInterval(() => this.tableJadwalSabtu(), 2000);
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

        // Get Jadwal
        getJadwalpelajaran: function() {
            this.loading2 = true;
            axios.get(`<?= base_url() ?>api/display/jadwalpelajaran2`)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJadwalpelajaran = data.data;
                        this.jadwalSenin = this.dataJadwalpelajaran.senin;
                        this.jadwalSelasa = this.dataJadwalpelajaran.selasa;
                        this.jadwalRabu = this.dataJadwalpelajaran.rabu;
                        this.jadwalKamis = this.dataJadwalpelajaran.kamis;
                        this.jadwalJumat = this.dataJadwalpelajaran.jumat;
                        this.jadwalSabtu = this.dataJadwalpelajaran.sabtu;
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

        //Table Jadwal Senin
        tableJadwalSenin: function() {
            var tableSenin = document.getElementById('senin');
            const wrapper = tableSenin.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableSeninScroll: function(el) {
            var tableSenin = document.getElementById('senin');
            const wrapper = tableSenin.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        //Table Jadwal Selasa
        tableJadwalSelasa: function() {
            var tableSelasa = document.getElementById('selasa');
            const wrapper = tableSelasa.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableSelasaScroll: function(el) {
            var tableSelasa = document.getElementById('selasa');
            const wrapper = tableSelasa.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        //Table Jadwal Rabu
        tableJadwalRabu: function() {
            var tableRabu = document.getElementById('rabu');
            const wrapper = tableRabu.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableRabuScroll: function(el) {
            var tableRabu = document.getElementById('rabu');
            const wrapper = tableRabu.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        //Table Jadwal Kamis
        tableJadwalKamis: function() {
            var tableKamis = document.getElementById('kamis');
            const wrapper = tableKamis.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableKamisScroll: function(el) {
            var tableKamis = document.getElementById('kamis');
            const wrapper = tableKamis.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        //Table Jadwal Jumat
        tableJadwalJumat: function() {
            var tableJumat = document.getElementById('jumat');
            const wrapper = tableJumat.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableJumatScroll: function(el) {
            var tableJumat = document.getElementById('jumat');
            const wrapper = tableJumat.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        //Table Jadwal Sabtu
        tableJadwalSabtu: function() {
            var tableSabtu = document.getElementById('sabtu');
            const wrapper = tableSabtu.querySelector('tbody');
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        },

        tableSabtuScroll: function(el) {
            var tableSabtu = document.getElementById('sabtu');
            const wrapper = tableSabtu.querySelector('tbody')
            if ((el.target.offsetHeight + el.target.scrollTop) >= el.target.scrollHeight) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        },

        // Get Jam Pelajaran
        getJampel: function() {
            this.loading3 = true;
            axios.get('<?= base_url() ?>api/display/jampelajaran')
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    var jam_ke = 0;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJampelajaran = data.data;
                        this.id_jam = this.dataJampelajaran.id_jam;
                        this.jam_ke = this.dataJampelajaran.jam_ke;
                        this.range_jam = this.dataJampelajaran.range_jam;
                        if (this.jam_ke != jam_ke) {
                            this.getKegiatanbelajar();
                            //this.getJadwalpelajaran();
                        } else {
                            this.dataJampelajaranError = "Tidak ada data jam pelajaran pada jam ini.";
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

        // Get
        getKegiatanbelajar: function() {
            this.loading3 = true;
            axios.get(`<?= base_url() ?>api/display/haribelajar?id=${this.id_jam}`)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataKegiatanbelajar = data.data;
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
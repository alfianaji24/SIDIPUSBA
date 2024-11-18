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
            <p id="tanggal"></p>
            <p id="tanggal_arab"></p>
        </div>

        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none mx-auto" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="80" height="80" />
            <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></span>
            </span>
        </a>

        <!--tanggal dan jam-->
        <div class="text-center fw-bold">
            <p id="waktu"></p>
        </div>

    </div>
</nav>

<div class="container-fluid mb-5">
    <div class="text-center">
        <div id="loader"></div>
    </div>
    <div id="carouselQuotes" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" id="innerQuotes">

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselQuotes" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselQuotes" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div id="noQuotes"></div>
</div>

<div id="info-agenda" class="container-fluid mb-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card transparan text-white border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-mosque"></i> Keuangan Masjid:
                </div>
                <div class="card-body">
                    <h4 class="font-weight-medium">Bulan: <?= date("M Y"); ?>, <span id="saldo"></span></h4>
                    <h4 class="font-weight-medium"><i class="mdi mdi-arrow-up text-success"></i> <span id="pemasukan"></span> <i class="mdi mdi-arrow-down text-danger"></i> <span id="pengeluaran"></span></h4>
                    <hr />
                    <h5>Transaksi Keuangan:</h5>
                    <div id="loader2"></div>
                    <div id="carouselKeuangan" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators" id="navKeuangan">

                        </div>
                        <div class="carousel-inner" id="innerKeuangan">

                        </div>
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
                    <div id="loader1"></div>
                    <div id="carouselAgenda" class="carousel slide" data-bs-theme="dark" data-bs-ride="carousel">
                        <div class="carousel-indicators" id="navAgenda">

                        </div>
                        <div class="carousel-inner" id="innerAgenda">

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAgenda" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAgenda" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div id="noAgenda"></div>
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
                <div class="card-body bg-red text-center text-light">
                    <h2 class="nama-solat">Subuh</h2>
                    <div id="loader3a"></div>
                    <span class="waktu-solat" id="subuh"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-blue-grey text-center text-light">
                    <h2 class="nama-solat">Terbit</h2>
                    <div id="loader3b"></div>
                    <span class="waktu-solat" id="terbit"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-cyan text-center text-light">
                    <h2 class="nama-solat">Dzuhur</h2>
                    <div id="loader3c"></div>
                    <span class="waktu-solat" id="dzuhur"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-green text-center text-light">
                    <h2 class="nama-solat">Ashar</h2>
                    <div id="loader3d"></div>
                    <span class="waktu-solat" id="ashar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-orange text-center text-light">
                    <h2 class="nama-solat">Maghrib</h2>
                    <div id="loader3e"></div>
                    <span class="waktu-solat" id="maghrib"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="card transparan border-0">
                <div class="card-body bg-pink text-center text-light">
                    <h2 class="nama-solat">Isya</h2>
                    <div id="loader3f"></div>
                    <span class="waktu-solat" id="isya"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--teks berjalan-->
<div id="news-container-full">
    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <ul class="marquee news-text">

        </ul>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="bottom: 23% !important;z-index: 11">
    <div id="liveToast3" class="toast align-items-center text-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-dark h6 mb-0">
            <strong class="me-auto">Menuju Waktu Sholat</strong>
            <small></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body h3" id="jelangSholat">

        </div>
    </div>
</div>

<?php $this->section("modal") ?>

<?php $this->endSection("modal") ?>

<?php $this->section("js") ?>
<script src="<?= base_url('assets/js/hijricalendar-islam.js') ?>" type="text/javascript"></script>
<script>
    var baseUrl = '<?= base_url(); ?>';
    var layoutAktif = "<?= $layout_aktif; ?>";
    //var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));

    function addZeroBefore(n) {
        return (n < 10 ? '0' : '') + n;
    }

    // Fungsi Ribuan
    function Ribuan(key) {
        const rupiah = 'Rp' + Number(key).toLocaleString('id-ID');
        return rupiah
    }

    // Pusher
    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;
    var pusher = new Pusher('<?= env('PUSHER_APP_KEY'); ?>', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('my-channel');
    // End Pusher

    $(document).ready(function() {
        <?php if ($use_pusher == 'no') { ?>
            setInterval(getLayoutAktif, 6000);
        <?php } ?>
        setInterval(getDate, 1000);
        setInterval(getTime, 1000);
        setInterval(cekWaktuSholat, 1000);
        getNews();
        getAgenda();
        getKeuangan();
        getAgamaQuotes();
        getJadwalsholat();
        cekWaktuSholat();
    })

    <?php if ($use_pusher == 'yes') { ?>
        // Pusher Client
        // Disini fungsi auto refresh menggunakan Pusher saat admin melakukan data insert, update, delete
        channel.bind('my-event', (data) => {
            if (data.event == 'layout') {
                location.reload();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'news') {
                getNews();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'agenda') {
                getAgenda();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'quotes') {
                getAgamaQuotes();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'sholat') {
                getJadwalsholat();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'keuangan') {
                getKeuangan();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }
        });

        //Interval keuangan masjid
        setInterval(() => getKeuangan(), <?= $slide_refresh; ?> * 1000);
    <?php } else { ?>
        setInterval(() => getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => getKeuangan(), 20000);
        setInterval(() => getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getJadwalsholat(), <?= $slide_refresh; ?> * 1000);
    <?php } ?>

    // Get Tanggal
    function getDate() {
        const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const today = new Date();
        const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
        let Hari = weekday[today.getDay()];
        const Tanggal = date;
        $('#tanggal').html(Hari + ', ' + Tanggal);
        $('#tanggal_arab').html(writeIslamicDate());
    }

    // Get Jam
    function getTime() {
        const today = new Date();
        const time = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
        const Jam = time;
        $('#waktu').html(Jam);
    }

    // Get Layout
    function getLayoutAktif() {
        axios.get('<?= base_url() ?>api/display/layoutaktif')
            .then(res => {
                // handle success
                var data = res.data;
                if (data.status == true) {
                    var layout = data.data;
                    <?php if ($use_pusher == 'no') : ?>
                        if (layout != layoutAktif) {
                            location.reload();
                        }
                    <?php endif; ?>
                } else {

                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    // Get News
    function getNews() {
        axios.get('<?= base_url() ?>api/news/news')
            .then(res => {
                // handle success
                var data = res.data;
                if (data.status == true) {
                    var dataNews = data.data;
                    //console.log(dataNews);
                    var html = '';
                    var i;
                    for (i = 0; i < dataNews.length; i++) {
                        html += '<li style="display: inline;">' +
                            ' ' + dataNews[i].text_news + ' &bull; ' +
                            '</li>';
                    }
                    $('.news-text').html(html);
                } else {

                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Get Quotes
    function getAgamaQuotes() {
        $('#loader').html('<h2 class="placeholder-glow"><span class="placeholder col-10"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        axios.get('<?= base_url() ?>api/display/agamaquotes')
            .then(res => {
                // handle success
                $('#loader').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataAgamaQuotes = data.data;
                    if (dataAgamaQuotes != '') {
                        $('#carouselQuotes').show();
                        var html = '';
                        var i;
                        for (i = 0; i < dataAgamaQuotes.length; i++) {
                            if (i == 0) {
                                html += '<div class="carousel-item active"><div class="text-center">' +
                                    '<h1 id="quotes" class="display-4 fw-bold">' + dataAgamaQuotes[i].isi_quotes + '(' + dataAgamaQuotes[i].suratriwayat + ')' + '</h1>' +
                                    '</div></div>';
                            } else {
                                html += '<div class="carousel-item"><div class="text-center">' +
                                    '<h1 id="quotes" class="display-4 fw-bold">' + dataAgamaQuotes[i].isi_quotes + '(' + dataAgamaQuotes[i].suratriwayat + ')' + '</h1>' +
                                    '</div></div>';
                            }
                        }
                        $('#innerQuotes').html(html);
                        $('#noQuotes').html('');
                    } else {
                        $('#carouselQuotes').hide();
                        $('#noQuotes').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5>Data Galeri gambar masih kosong</h5></div>');
                    }
                } else {
                    $('#carouselQuotes').hide();
                    $('#noQuotes').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5>Data Galeri gambar masih kosong</h5></div>');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Get Keuangan
    function getKeuangan() {
        $('#loader2').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#pemasukan').html('Memuat...');
        $('#pengeluaran').html('Memuat...');
        axios.get('<?= base_url() ?>api/display/keuanganmasjid')
            .then(res => {
                // handle success
                $('#loader2').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataKeuangan = data.data;
                    $('#pemasukan').html(Ribuan(dataKeuangan.pemasukan));
                    $('#pengeluaran').html(Ribuan(dataKeuangan.pengeluaran));
                    var keuangan = dataKeuangan.keuangan;
                    if (keuangan != '') {
                        $('#carouselKeuangan').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < keuangan.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselKeuangan" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                if (keuangan[i].jenis == '1') {
                                    html += '<div class="carousel-item active"><h5><i class="mdi mdi-arrow-up text-success"></i>' +
                                        '' + keuangan[i].uraian + ' ' + Ribuan(keuangan[i].pemasukan) + '</h5></div>';
                                } else {
                                    html += '<div class="carousel-item active"><h5><i class="mdi mdi-arrow-down text-danger"></i>' +
                                        '' + keuangan[i].uraian + ' ' + Ribuan(keuangan[i].pengeluaran) + '</h5></div>';
                                }

                            } else {
                                nav += '<button type="button" data-bs-target="#carouselKeuangan" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                if (keuangan[i].jenis == '1') {
                                    html += '<div class="carousel-item active"><h5><i class="mdi mdi-arrow-up text-success"></i>' +
                                        '' + keuangan[i].uraian + ' ' + Ribuan(keuangan[i].pemasukan) + '</h5></div>';
                                } else {
                                    html += '<div class="carousel-item active"><h5><i class="mdi mdi-arrow-down text-danger"></i>' +
                                        '' + keuangan[i].uraian + ' ' + Ribuan(keuangan[i].pengeluaran) + '</h5></div>';
                                }
                            }
                        }
                        $('#navKeuangan').html(nav);
                        $('#innerKeuangan').html(html);
                        $('#noKeuangan').html('');
                    } else {
                        $('#carouselKeuangan').hide();
                        $('#noKeuangan').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Keuangan di sistem</h5>');
                    }
                    getSaldo();
                } else {
                    $('#carouselKeuangan').hide();
                    $('#noKeuangan').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Keuangan di sistem</h5>');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    function getSaldo() {
        $('#saldo').html('Memuat...');
        axios.get('<?= base_url(); ?>api/display/kasmasjid')
            .then(res => {
                // handle success
                var data = res.data;
                if (data.status == true) {
                    var saldo = data.data;
                    $('#saldo').html(Ribuan(saldo));
                } else {
                    $('#saldo').html('0');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Get Agenda
    function getAgenda() {
        $('#loader1').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/agenda')
            .then(res => {
                // handle success
                $('#loader1').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataAgenda = data.data;
                    if (dataAgenda != '') {
                        $('#carouselAgenda').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataAgenda.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselAgenda" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h5 class="fw-bold">' + dataAgenda[i].nama_agenda + '</h5>' +
                                    '<h5 class="fw-medium">Tempat: ' + dataAgenda[i].tempat_agenda + '</h5>' +
                                    '<h5 class="fw-medium">Waktu: ' + dataAgenda[i].tgl_agenda + ', ' + dataAgenda[i].waktu + ' - selesai' + '</h5>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselAgenda" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h5 class="fw-bold">' + dataAgenda[i].nama_agenda + '</h5>' +
                                    '<h5 class="fw-medium">Tempat: ' + dataAgenda[i].tempat_agenda + '</h5>' +
                                    '<h5 class="fw-medium">Waktu: ' + dataAgenda[i].tgl_agenda + ', ' + dataAgenda[i].waktu + ' - selesai' + '</h5>' +
                                    '</div>';
                            }
                        }
                        $('#navAgenda').html(nav);
                        $('#innerAgenda').html(html);
                        $('#noAgenda').html('');
                    } else {
                        $('#carouselAgenda').hide();
                        $('#noAgenda').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5>Belum Ada Agenda Bulan ini</h5></div>');
                    }
                } else {
                    $('#carouselAgenda').hide();
                    $('#noAgenda').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5>Belum Ada Agenda Bulan ini</h5></div>');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    // Get Jadwal Sholat
    function getJadwalsholat() {
        $('#loader3a').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#loader3b').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#loader3c').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#loader3d').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#loader3e').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        $('#loader3f').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/jadwalsholat')
            .then(res => {
                // handle success
                $('#loader3a').html('');
                $('#loader3b').html('');
                $('#loader3c').html('');
                $('#loader3d').html('');
                $('#loader3e').html('');
                $('#loader3f').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataJadwalsholat = data.data;
                    if (dataJadwalsholat != null) {
						$('#subuh').html(dataJadwalsholat.subuh);
						$('#terbit').html(dataJadwalsholat.terbit);
						$('#dzuhur').html(dataJadwalsholat.dzuhur);
						$('#ashar').html(dataJadwalsholat.ashar);
						$('#maghrib').html(dataJadwalsholat.maghrib);
						$('#isya').html(dataJadwalsholat.isya);
					} else {
                        $('#subuh').html('-');
                        $('#terbit').html('-');
                        $('#dzuhur').html('-');
                        $('#ashar').html('-');
                        $('#maghrib').html('-');
                        $('#isya').html('-');
                        $('#liveToast').show();
                        $('#message').html('Data Jadwal Sholat bulan ini masih kosong!, lakukan import excel atau ganti ke mode API');
                        setTimeout(() => {
                            $('#liveToast').hide();
                        }, 4000);
                    }
                } else {

                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Cek waktu sholat
    function cekWaktuSholat() {
        axios.get('<?= base_url() ?>api/display/cekwaktusolat')
            .then(res => {
                // handle success
                var data = res.data;
                if (data.status == true) {
                    var waktuSholat = data.data;
                    if (waktuSholat != "") {
                        var now = new Date().getTime();
                        var countDownDate = new Date(waktuSholat.waktu).getTime();
                        var distance = countDownDate - now;
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = addZeroBefore(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                        var minutes = addZeroBefore(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
                        var seconds = addZeroBefore(Math.floor((distance % (1000 * 60)) / 1000));
                        var jelangSholat = waktuSholat.jelang + ' ' + hours + ":" + minutes + ":" + seconds;

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
                            var iqomah = "Iqomah: " + "-" + minutes1 + ":" + seconds1 + "";
                        }
                        // If the count down is finished, write some text
                        if (distance1 < 0) {
                            var iqomah = "";
                        }

                        // Toast Jelang Sholat
                        $('#liveToast3').show();
                        $('#jelangSholat').html('<strong>' + jelangSholat + '</strong><br />' + iqomah);
                    } else {
                        $('#liveToast3').hide();
                    }
                } else {

                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }
</script>
<?php $this->endSection("js") ?>
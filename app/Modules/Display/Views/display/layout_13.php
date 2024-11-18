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
                <p id="waktu"></p>
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
                    <div class="card-body py-2 text-left text-light">
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
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-night-partly-cloudy"></i></h1>
                                <h2 class="nama-solat">Subuh</h2>
                                <div id="loader3a"></div>
                                <span class="waktu-solat" id="subuh"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-sunset"></i></h1>
                                <h2 class="nama-solat">Terbit</h2>
                                <div id="loader3b"></div>
                                <span class="waktu-solat" id="terbit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-sunny"></i></h1>
                                <h2 class="nama-solat">Dzuhur</h2>
                                <div id="loader3c"></div>
                                <span class="waktu-solat" id="dzuhur"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-sunny"></i></h1>
                                <h2 class="nama-solat">Ashar</h2>
                                <div id="loader3d"></div>
                                <span class="waktu-solat" id="ashar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-sunset"></i></h1>
                                <h2 class="nama-solat">Maghrib</h2>
                                <div id="loader3e"></div>
                                <span class="waktu-solat" id="maghrib"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card transparent">
                            <div class="card-body text-left text-light">
                                <h1 class="float-start me-3"><i class="mdi mdi-weather-night"></i></h1>
                                <h2 class="nama-solat">Isya</h2>
                                <div id="loader3f"></div>
                                <span class="waktu-solat" id="isya"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card transparent text-warning text-center border-0" role="alert">
                    <div class="card-header h6 mb-0">
                        <strong class="me-auto">Menuju Waktu Sholat</strong>
                        <small></small>
                    </div>
                    <div class="card-body h3" id="jelangSholat">

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
                    <span id="tanggal"></span> -
                    <span id="tanggal_arab"></span>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-dark text-white transparan border-0 h-100">
                        <div class="card-header h5">
                            <i class="mdi mdi-video"></i> Video
                        </div>
                        <?php if ($video_youtube == 'no') { ?>
                            <!-- mp4 -->
                            <video id="player" class="ratio ratio-16x9" controls playsinline>

                            </video>
                        <?php } else { ?>
                            <!-- youtube -->
                            <div class="plyr__video-embed" id="player">
                                <iframe src="https://www.youtube.com/embed/<?= $videoId; ?>?origin=<?= base_url(); ?>&amp;autoplay=1&amp;loop=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card transparan text-white border-0 mb-3 h-100">
                        <div class="card-header h5">
                            <i class="mdi mdi-mosque"></i> Info Masjid
                        </div>
                        <div class="card-body">
                            <div id="loader2"></div>
                            <div id="carouselInfo" class="carousel slide" data-bs-ride="carousel">
                                <!-- <div class="carousel-indicators" id="navInfo">

						        </div> -->
                                <div class="carousel-inner" id="innerInfo">

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselInfo" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselInfo" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div id="noInfo"></div>
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
                                <div id="loader1"></div>
                                <div id="carouselAgenda" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators with-margin" id="navAgenda">

                                    </div>
                                    <div class="carousel-inner mb-3" id="innerAgenda">

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

                    <div class="col-md-6">
                        <div class="card transparan text-white border-0 mb-3 h-100">
                            <div class="card-header h5">
                                <i class="mdi mdi-mosque"></i> Keuangan Masjid:
                            </div>
                            <div class="card-body">
                                <h5 class="font-weight-medium">Bulan: <?= date("M Y"); ?>, <span id="saldo"></span></h5>
                                <h5 class="font-weight-medium"><i class="mdi mdi-arrow-up text-success"></i> <span id="pemasukan"></span> <i class="mdi mdi-arrow-down text-danger"></i> <span id="pengeluaran"></span></h5>
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
        getInfo();
        getAgenda();
        getKeuangan();
        getJadwalsholat();
        cekWaktuSholat();
        getVideo();
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
                getInfo();
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
    <?php } else { ?>
        setInterval(() => getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getInfo(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getKeuangan(), 20000);
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

    //Get Info
    function getInfo() {
        $('#loader2').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/news/masjid')
            .then(res => {
                // handle success
                $('#loader2').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataInfo = data.data;
                    if (dataInfo != '') {
                        $('#carouselInfo').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataInfo.length; i++) {
                            if (i == 0) {
                                //nav += '<button type="button" data-bs-target="#carouselInfo" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h5>' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h5 class="fw-medium mb-0">' + dataInfo[i].text_news + '</h5>' +
                                    '</div>';
                            } else {
                                //nav += '<button type="button" data-bs-target="#carouselInfo" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h5>' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h5 class="fw-medium mb-0">' + dataInfo[i].text_news + '</h5>' +
                                    '</div>';
                            }
                        }
                        //$('#navInfo').html(nav);
                        $('#innerInfo').html(html);
                        $('#noInfo').html('');
                    } else {
                        $('#carouselInfo').hide();
                        $('#noInfo').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
                    }
                } else {
                    $('#carouselInfo').hide();
                    $('#noInfo').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
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

    // Get Jadwal Sholat
    function getJadwalsholat() {
        $('#loader3a').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        $('#loader3b').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        $('#loader3c').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        $('#loader3d').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        $('#loader3e').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
        $('#loader3f').html('<h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2>');
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

    // Get Video
    function getVideo() {
        const player = new Plyr('#player');
        axios.get('<?= base_url(); ?>api/display/video')
            .then(res => {
                // handle success
                var data = res.data;
                if (data.status == true) {
                    var dataVideo = data.data;
                    <?php if ($video_youtube == 'no') : ?>
                        //Video Player
                        var player = document.getElementById("player");
                        var i = 0;
                        var videoSource = dataVideo;
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
                                            var dataVideo = data.data;
                                            videoSource = dataVideo;
                                            videoCount = videoSource.length;
                                        }
                                    });
                                videoPlay(i);
                            } else {
                                i++;
                                videoPlay(i);
                            }
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
</script>
<?php $this->endSection("js") ?>
<?php $this->section("style"); ?>
<style>
    .navbar-mb {
        margin-bottom: 2rem !important;
    }

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
                <p id="tanggal"></p>
                <p id="waktu"></p>
            </div>
            <div class="col-6">
                <div id="loader"></div>
                <div id="dataCuaca">
                    <h4 class="mb-0" id="cuacaKota"></h4>
                    <div id="cuacaWeather"></div>
                </div>
            </div>
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
                                <video id="player" class="ratio ratio-16x9" controls playsinline>

                                </video>
                            <?php } else { ?>
                                <div class="plyr__video-embed" id="player">
                                    <iframe src="https://www.youtube.com/embed/<?= $videoId; ?>?origin=<?= base_url(); ?>&amp;autoplay=1&amp;loop=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                </div>
                            <?php } ?>
                        </div>
                        <?php $this->section("script") ?>
                        getVideo();
                        <?php $this->endSection("script") ?>
                    <?php } else if ($row['konten'] == 'galeri') { ?>
                        <div class="card-body p-0">
                            <div id="loaderGA"></div>
                            <div id="carouselGaleri" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators" id="navGaleri">

                                </div>
                                <div class="carousel-inner" id="innerGaleri">

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleri" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleri" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div id="noGaleri"></div>
                        </div>
                    <?php } else if ($row['konten'] == 'agenda') { ?>
                        <div class="card-body">
                            <div id="loaderAG"></div>
                            <div id="carouselAgenda" class="carousel slide" data-bs-ride="carousel">
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
                    <?php } else if ($row['konten'] == 'jadwalsholat') { ?>
                        <div class="card-body bg-dark text-white transparan py-2">
                            <i class="mdi mdi-information"></i>
                            <span id="tanggal_arab"></span> -
                            <span id="modeSholat"></span>
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
                    <?php } else if ($row['konten'] == 'infonews') { ?>
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['title']; ?></h4>
                            <div id="loaderIN"></div>
                            <div id="carouselInfoNews" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators with-margin" id="navInfoNews">

                                </div>
                                <div class="carousel-inner text-center mb-3" id="innerInfoNews">

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselInfoNews" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselInfoNews" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div id="noInfoNews"></div>
                        </div>
                    <?php } else if ($row['konten'] == 'infomasjid') { ?>
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['title']; ?></h4>
                            <div id="loaderIM"></div>
                            <div id="carouselInfoMasjid" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators with-margin" id="navInfoMasjid">

                                </div>
                                <div class="carousel-inner text-center mb-3" id="innerInfoMasjid">

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselInfoMasjid" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselInfoMasjid" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div id="noInfoMasjid"></div>
                        </div>
                    <?php } else if ($row['konten'] == 'quotesagama') { ?>
                        <div class="card-body">
                            <div class="text-center">
                                <div id="loaderQA"></div>
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
                    <?php } else { ?>
                        <div class="card-header">
                            <h5 class="card-title"><?= $row['title']; ?></h5>
                        </div>
                        <div class="card-body html" id="handleScroll">
                            <?= $row['konten']; ?>
                        </div>
                        <?php $this->section("script") ?>
                        divScroll();
                        <?php $this->endSection("script") ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!--teks berjalan-->
<div id="news-container-full">
    <div class="position-absolute top-50 start-50 translate-middle w-100">
        <ul class="marquee news-text">

        </ul>
    </div>
</div>

<?php foreach ($custom as $row) { ?>
    <?php if ($row['konten'] == 'jadwalsholat') : ?>
        <div class="position-fixed bottom-0 end-0 p-2" style="z-index: 11; bottom: 10% !important;">
            <div id="liveToast3" class="toast align-items-center text-dark border-0" role="alert" aria-live="assertive" aria-atomic="true" style="width: 250px;">
                <div class="toast-header bg-warning text-dark">
                    <strong class="me-auto">Menuju Waktu Sholat</strong>
                    <small></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body h3" id="jelangSholat">

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
    var baseUrl = '<?= base_url(); ?>';
    var layoutAktif = "<?= $layout_aktif; ?>";
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

    $(document).ready(function() {
        <?php if ($use_pusher == 'no') { ?>
            setInterval(getLayoutAktif, 6000);
        <?php } ?>
        setInterval(getDate, 1000);
        setInterval(getTime, 1000);
        setInterval(cekWaktuSholat, 1000);
        getNews();
        getAgenda();
        getGaleri();
        getCuaca();
        getJadwalsholat();
        cekWaktuSholat();
        getAgamaQuotes();
        getInfoNews();
        getInfoMasjid();
        <?= $this->renderSection('script') ?>
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

            if (data.event == 'custom') {
                location.reload();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'news') {
                getNews();
                getInfoNews();
                getInfoMasjid();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'galeri') {
                getGaleri();
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

            if (data.event == 'cuaca') {
                getCuaca();
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

            if (data.event == 'quotes') {
                getAgamaQuotes();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }
        });

        //Interval Cuaca (default 15 Menit)
        setInterval(() => getCuaca(), <?= $cuaca_refresh; ?> * 1000);
    <?php } else { ?>
        setInterval(() => getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => getGaleri(), <?= $slide_refresh; ?> * 1000);
        setInterval(() => getCuaca(), <?= $cuaca_refresh; ?> * 1000);
        setInterval(() => getJadwalsholat(), <?= $slide_refresh; ?> * 1000);
        setInterval(() => getAgamaQuotes(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getInfoNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getInfoMasjid(), <?= $news_refresh; ?> * 1000);
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

    //Div Custom
    function divScroll() {
        const wrapper = document.querySelector('.card-body')
        setInterval(() => {
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.scrollTop += 20
        }, 2000)
        handleScroll();
    }

    function handleScroll() {
        const wrapper = document.querySelector('.card-body')
        let el = document.getElementById('handleScroll');
        el.addEventListener('scroll', function(e) {
            if (this.scrollHeight - this.scrollTop - this.clientHeight <= 0) {
                setTimeout(() => wrapper.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                }), 2000);
            }
        });
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

    // Get Cuaca
    function getCuaca() {
        $('#loader').html('<h5><?= lang('App.loadingWait'); ?></h5>');
        axios.get('<?= base_url() ?>api/display/cuaca')
            .then(res => {
                // handle success
                $('#loader').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataCuaca = data.data;
                    var dataCuaca_weather = dataCuaca.weather;
                    var dataCuaca_main = dataCuaca.main;
                    var dataCuaca_sys = dataCuaca.sys;
                    var weather = '';
                    var i;
                    for (i = 0; i < dataCuaca_weather.length; i++) {
                        weather += '<h4 class="mb-0">' +
                            ' ' + dataCuaca_weather[i].main + ', ' + dataCuaca_weather[i].description + ' <img class="mb-0" src="http://openweathermap.org/img/wn/' + dataCuaca_weather[i].icon + '.png" height="35">' +
                            '</h4>';
                    }
                    if (dataCuaca != null) {
                        $('#dataCuaca').show();
                        $('#cuacaKota').html(dataCuaca.name + ', ' + dataCuaca_sys.country + ' <span id="temperature"><strong>' + Math.floor(dataCuaca_main.temp) + '</strong>&deg;C</span>');
                        $('#cuacaWeather').html(weather);
                    } else {
                        $('#dataCuaca').html('<h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>');
                        $('#cuacaKota').html('');
                        $('#cuacaWeather').html('');
                    }
                } else {
                    $('#dataCuaca').html('<h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>');
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
    function getInfoNews() {
        $('#loaderIN').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/news/info')
            .then(res => {
                // handle success
                $('#loaderIN').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataInfo = data.data;
                    if (dataInfo != '') {
                        $('#carouselInfoNews').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataInfo.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselInfoNews" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h5 class="mb-0">' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h4 class="fw-medium">' + dataInfo[i].text_news + '</h4>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselInfoNews" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h5 class="mb-0">' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h4 class="fw-medium">' + dataInfo[i].text_news + '</h4>' +
                                    '</div>';
                            }
                        }
                        $('#navInfoNews').html(nav);
                        $('#innerInfoNews').html(html);
                        $('#noInfoNews').html('');
                    } else {
                        $('#carouselInfoNews').hide();
                        $('#noInfoNews').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
                    }
                } else {
                    $('#carouselInfoNews').hide();
                    $('#noInfoNews').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Get Info
    function getInfoMasjid() {
        $('#loaderIM').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/news/masjid')
            .then(res => {
                // handle success
                $('#loaderIM').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataInfo = data.data;
                    if (dataInfo != '') {
                        $('#carouselInfoMasjid').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataInfo.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselInfoMasjid" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h5 class="mb-0">' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h4 class="fw-medium">' + dataInfo[i].text_news + '</h4>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselInfoMasjid" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h5 class="mb-0">' + dataInfo[i].tgl_news + '</h5>' +
                                    '<h4 class="fw-medium">' + dataInfo[i].text_news + '</h4>' +
                                    '</div>';
                            }
                        }
                        $('#navInfoMasjid').html(nav);
                        $('#innerInfoMasjid').html(html);
                        $('#noInfoMasjid').html('');
                    } else {
                        $('#carouselInfoMasjid').hide();
                        $('#noInfoMasjid').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
                    }
                } else {
                    $('#carouselInfoMasjid').hide();
                    $('#noInfoMasjid').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Info di sistem</h5>');
                }
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    }

    //Get Agenda
    function getAgenda() {
        $('#loaderAG').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/agenda')
            .then(res => {
                // handle success
                $('#loaderAG').html('');
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
                                    '<h4 class="fw-medium">' + dataAgenda[i].nama_agenda + ', ' + dataAgenda[i].tgl_agenda + '</h4>' +
                                    '<h4 class="fw-medium">' + dataAgenda[i].tempat_agenda + ', ' + dataAgenda[i].waktu + ' - selesai' + '</h4>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselAgenda" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h4 class="fw-medium">' + dataAgenda[i].nama_agenda + ', ' + dataAgenda[i].tgl_agenda + '</h4>' +
                                    '<h4 class="fw-medium">' + dataAgenda[i].tempat_agenda + ', ' + dataAgenda[i].waktu + ' - selesai' + '</h4>' +
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

    //Get Galeri
    function getGaleri() {
        $('#loaderGA').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/galeri')
            .then(res => {
                // handle success
                $('#loaderGA').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataGaleri = data.data;
                    if (dataGaleri != '') {
                        $('#carouselGaleri').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataGaleri.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselGaleri" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<img src="' + baseUrl + dataGaleri[i].image_url + '" class="d-block w-100">' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselGaleri" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide"></button>';
                                html += '<div class="carousel-item">' +
                                    '<img src="' + baseUrl + dataGaleri[i].image_url + '" class="d-block w-100">' +
                                    '</div>';
                            }
                        }
                        $('#navGaleri').html(nav);
                        $('#innerGaleri').html(html);
                        $('#noGaleri').html('');
                    } else {
                        $('#carouselGaleri').hide();
                        $('#noGaleri').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5>Data Galeri gambar masih kosong</h5></div>');
                    }
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
        $('#loaderQA').html('<h2 class="placeholder-glow"><span class="placeholder col-10"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-8"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-6"></span></h2>');
        axios.get('<?= base_url() ?>api/display/agamaquotes')
            .then(res => {
                // handle success
                $('#loaderQA').html('');
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
                      if (data.mode == 'excel') {
                        $('#modeSholat').html('Data Jadwal: Data Excel');
                    } else {
                        $('#modeSholat').html('Data Jadwal: API.myquran.com');
                    }
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
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
            <p id="waktu"></p>
            <p id="tanggal"></p>
        </div>

        <a class="navbar-brand d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none" href="#">
            <img style="margin:0 auto;margin-right: 10px;" id="logo" class="img-responsive" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="65" />
            <span id="judul_1" class="<?= $fs_nama; ?> <?= $fw_nama; ?>"><?= $nama_instansi; ?><br />
                <span id="judul_2" class="<?= $fs_alamat; ?>"><?= $alamat; ?></span>
            </span>
        </a>

        <div id="loader"></div>
        <div id="dataCuaca">
            <h5 class="mb-0" id="cuacaKota"></h5>
            <div id="cuacaWeather"></div>
            <p class="h1 mb-0" id="temperature"></p>
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
                                <div id="loader2"></div>
                                <ul class="list-unstyled" id="informasi">

                                </ul>
                                <div id="noInfo"></div>
                            </div>

                            <div class="carousel-item">
                                <div id="loader1"></div>
                                <ul class="list-unstyled" id="agenda">

                                </ul>
                                <div id="noAgenda"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card d-flex justify-content-center transparan text-white border-0 mb-3">
                <!-- <div class="card-header h5">
                    <i class="mdi mdi-video"></i> Video
                </div> -->
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

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-orange text-dark border-0 mb-3 h-100">
                        <div class="card-header h5">
                            <i class="mdi mdi-bullhorn"></i> Promosi
                        </div>
                        <div class="card-body bg-white">
                            <div id="loader4"></div>
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card transparan text-white h-100">
                        <div class="card-body">
                            <div id="loader3"></div>
                            <div id="carouselDosen" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators with-margin" id="navDosen">

                                </div>
                                <div class="carousel-inner mb-3" id="innerDosen">

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDosen" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselDosen" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div id="noDosen"></div>
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
        getVideo();
        getNews();
        getInfo();
        getAgenda();
        getGaleri();
        getDosen();
        getCuaca();
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

            if (data.event == 'galeri') {
                getGaleri();
                $('#liveToast').show();
                $('#message').html(data.message);
                setTimeout(() => {
                    $('#liveToast').hide();
                }, 4000);
            }

            if (data.event == 'dosen') {
                getDosen();
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
        });

        //Interval Cuaca (default 15 Menit)
        setInterval(() => getCuaca(), <?= $cuaca_refresh; ?> * 1000);
    <?php } else { ?>
        setInterval(() => getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getInfo(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => getGaleri(), <?= $slide_refresh; ?> * 1000);
        setInterval(() => getDosen(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getCuaca(), <?= $cuaca_refresh; ?> * 1000);
    <?php } ?>

    // Get Tanggal
    function getDate() {
        const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const today = new Date();
        const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
        let Hari = weekday[today.getDay()];
        const Tanggal = date;
        $('#tanggal').html(Hari + ', ' + Tanggal);
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
                        weather += '<h5 class="mb-0">' +
                            ' ' + dataCuaca_weather[i].main + ', ' + dataCuaca_weather[i].description + ' <img class="mb-0" src="http://openweathermap.org/img/wn/' + dataCuaca_weather[i].icon + '.png" height="35">' +
                            '</h5>';
                    }
                    if (dataCuaca != null) {
                        $('#dataCuaca').show();
                        $('#cuacaKota').html('<h5 class="fw-bold mb-0">' + dataCuaca.name + ', ' + dataCuaca_sys.country + '</h5>');
                        $('#cuacaWeather').html(weather);
                        $('#temperature').html('<strong>' + Math.floor(dataCuaca_main.temp) + '</strong>&deg;C');
                    } else {
                        $('#dataCuaca').html('<h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>');
                        $('#cuacaKota').html('');
                        $('#cuacaWeather').html('');
                        $('#temperature').html('');
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

    //Get Info
    function getInfo() {
        $('#loader2').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/news/info')
            .then(res => {
                // handle success
                $('#loader2').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataInfo = data.data;
                    if (dataInfo != '') {
                        $('#informasi').show();
                        var html = '';
                        var i;
                        for (i = 0; i < dataInfo.length; i++) {
                            html += '' +
                                '<h5>' + dataInfo[i].tgl_news + '</h5>' +
                                '<h5 class="fw-bold">' + dataInfo[i].text_news + '</h5>' +
                                '<hr />';

                        }
                        $('#informasi').html(html);
                        $('#noInfo').html('');
                    } else {
                        $('#informasi').hide();
                        $('#noInfo').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i> <h5>Data Informasi masih kosong</h5></div>');
                    }
                } else {
                    $('#informasi').hide();
                    $('#noInfo').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i> <h5>Data Informasi masih kosong</h5></div>');
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
                        $('#agenda').show();
                        var html = '';
                        var i;
                        for (i = 0; i < dataAgenda.length; i++) {
                            html += '' +
                                '<h4 class="fw-bold">' + dataAgenda[i].nama_agenda + '</h4>' +
                                '<h5>Tempat: ' + dataAgenda[i].tempat_agenda + '</h5>' +
                                '<h5>Waktu: ' + dataAgenda[i].tgl_agenda + ', ' + dataAgenda[i].waktu + ' - selesai' + '</h5>' +
                                '<hr />';
                        }
                        $('#agenda').html(html);
                        $('#noAgenda').html('');
                    } else {
                        $('#agenda').hide();
                        $('#noAgenda').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i><h5> Belum Ada Agenda Bulan ini</h5></div>');
                    }
                } else {
                    $('#agenda').hide();
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
        $('#loader4').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/galeri')
            .then(res => {
                // handle success
                $('#loader4').html('');
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

    //Get Dosen
    function getDosen() {
        $('#loader3').html('<h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2><h2 class="placeholder-glow"><span class="placeholder col-12"></span></h2>');
        axios.get('<?= base_url() ?>api/display/dosen')
            .then(res => {
                // handle success
                $('#loader3').html('');
                var data = res.data;
                if (data.status == true) {
                    var dataDosen = data.data;
                    if (dataDosen != '') {
                        $('#carouselDosen').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataDosen.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselDosen" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<div class="d-flex justify-content-center "><img src="' + baseUrl + dataDosen[i].foto + '" class="mb-3" height="100"></div>' +
                                    '<h4 class="fw-bold">' + dataDosen[i].nama_lengkap + '</h4>' +
                                    '<h5>' + dataDosen[i].nip_nik + '</h5>' +
                                    '<h5>Jabatan: ' + dataDosen[i].jabatan + '</h5>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselDosen" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<div class="d-flex justify-content-center "><img src="' + baseUrl + dataDosen[i].foto + '" class="mb-3" height="100"></div>' +
                                    '<h4 class="fw-bold">' + dataDosen[i].nama_lengkap + '</h4>' +
                                    '<h5>' + dataDosen[i].nip_nik + '</h5>' +
                                    '<h5>Jabatan: ' + dataDosen[i].jabatan + '</h5>' +
                                    '</div>';
                            }
                        }
                        $('#navDosen').html(nav);
                        $('#innerDosen').html(html);
                        $('#noDosen').html('');
                    } else {
                        $('#carouselDosen').hide();
                        $('#noDosen').html('<h5><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum ada data Dosen di sistem</h5>');
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
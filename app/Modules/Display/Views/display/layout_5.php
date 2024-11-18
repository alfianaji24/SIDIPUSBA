<?php $this->section("style"); ?>
<style>
    #tanggal {
        color: white;
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

    #temperature {
        color: yellow !important;
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

        <!--tanggal dan jam-->
        <div class="text-center fw-bold">
            <p id="tanggal"></p>
            <p id="waktu"></p>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card d-flex justify-content-center transparan text-white border-0 h-100">
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
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white transparan border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-calendar"></i> <?= $name_agenda_instansi; ?>
                </div>
                <div class="card-body">
                    <div id="loader1"></div>
                    <div id="carouselAgenda" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators with-margin" id="navAgenda">

                        </div>
                        <div class="carousel-inner" id="innerAgenda">

                        </div>
                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselAgenda" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAgenda" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->
                    </div>
                    <div id="noAgenda"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white transparan border-0 mb-3 h-100">
                <div class="card-header h5">
                    <i class="mdi mdi-weather-cloudy"></i> Prakiraan Cuaca
                </div>
                <div class="card-body">
                    <div id="loader"></div>
                    <div id="dataCuaca">
                        <h3 class="mb-3" id="cuacaKota"></h3>
                        <div class="mb-3" id="cuacaWeather"></div>
                        <p class="h1 mb-3" id="temperature"></p>
                        <p class="mb-0" id="cuacaInfo"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card transparan text-white mt-4">
        <div class="card-header h5">
            <i class="mdi mdi-information"></i> Informasi
        </div>
        <div class="card-body text-center">
            <div id="loader2"></div>
            <div id="carouselInfo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators with-margin" id="navInfo">

                </div>
                <div class="carousel-inner mb-3" id="innerInfo">

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

    <div class="mt-4">
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
        getNews();
        getInfo();
        getAgenda();
        getCuaca();
        getJadwalsholat()
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

            if (data.event == 'sholat') {
                getJadwalsholat();
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

        //Interval Cuaca
        setInterval(() => getCuaca(), <?= $cuaca_refresh; ?> * 1000);
    <?php } else { ?>
        setInterval(() => getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => getInfo(), <?= $news_refresh; ?> * 1000);
        setInterval(() => getJadwalsholat(), <?= $slide_refresh; ?> * 1000);
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
                        weather += '<h4 class="mb-0">' +
                            '<img class="mb-0" src="http://openweathermap.org/img/wn/' + dataCuaca_weather[i].icon + '.png" height="50"> ' + dataCuaca_weather[i].main + ', ' + dataCuaca_weather[i].description +
                            '</h4>';
                    }
                    if (dataCuaca != null) {
                        $('#dataCuaca').show();
                        $('#cuacaKota').html('<h5 class="fw-bold mb-0">' + dataCuaca.name + ', ' + dataCuaca_sys.country + '</h5>');
                        $('#cuacaWeather').html(weather);
                        $('#temperature').html('<strong>' + Math.floor(dataCuaca_main.temp) + '</strong>&deg;C');
                        $('#cuacaInfo').html('Feels like ' + Math.floor(dataCuaca_main.feels_like) + '</strong>&deg;C' + '. Humidity ' + dataCuaca_main.humidity + '%');
                    } else {
                        $('#dataCuaca').html('<h5 class="fw-normal"><i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Tidak ada koneksi internet</h5>');
                        $('#cuacaKota').html('');
                        $('#cuacaWeather').html('');
                        $('#temperature').html('');
                        $('#cuacaInfo').html('');
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
                        $('#carouselInfo').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataInfo.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselInfo" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h4>' + dataInfo[i].tgl_news + '</h4>' +
                                    '<h3 class="fw-bold">' + dataInfo[i].text_news + '</h3>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselInfo" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h4>' + dataInfo[i].tgl_news + '</h4>' +
                                    '<h3 class="fw-bold">' + dataInfo[i].text_news + '</h3>' +
                                    '</div>';
                            }
                        }
                        $('#navInfo').html(nav);
                        $('#innerInfo').html(html);
                        $('#noInfo').html('');
                    } else {
                        $('#carouselInfo').hide();
                        $('#noInfo').html('<div class="text-center"><i class="mdi mdi-alert-octagon-outline mdi-48px text-danger"></i> <h5>Data Informasi masih kosong</h5></div>');
                    }
                } else {
                    $('#carouselInfo').hide();
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
                        $('#carouselAgenda').show();
                        var nav = '';
                        var html = '';
                        var i;
                        for (i = 0; i < dataAgenda.length; i++) {
                            if (i == 0) {
                                nav += '<button type="button" data-bs-target="#carouselAgenda" data-bs-slide-to="' + i + '" class="active" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item active">' +
                                    '<h3 class="fw-bold mb-3">' + dataAgenda[i].nama_agenda + ', ' + dataAgenda[i].tgl_agenda + '</h3>' +
                                    '<h4 class="fw-medium">Tempat: ' + dataAgenda[i].tempat_agenda + '</h4>' +
                                    '<h4 class="fw-medium">Waktu: ' + dataAgenda[i].waktu + ' - selesai' + '</h4>' +
                                    '</div>';
                            } else {
                                nav += '<button type="button" data-bs-target="#carouselAgenda" data-bs-slide-to="' + i + '" aria-current="true" aria-label="Slide ' + i + '"></button>';
                                html += '<div class="carousel-item">' +
                                    '<h3 class="fw-bold mb-3">' + dataAgenda[i].nama_agenda + ', ' + dataAgenda[i].tgl_agenda + '</h3>' +
                                    '<h4 class="fw-medium">Tempat: ' + dataAgenda[i].tempat_agenda + '</h4>' +
                                    '<h4 class="fw-medium">Waktu: ' + dataAgenda[i].waktu + ' - selesai' + '</h4>' +
                                    '</div>';
                            }
                        }
                        $('#navAgenda').html(nav);
                        $('#innerAgenda').html(html);
                        $('#noAgenda').html('');
                    } else {
                        $('#carouselAgenda').hide();
                        $('#noAgenda').html('<i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum Ada Agenda Bulan ini');
                    }
                } else {
                    $('#carouselAgenda').hide();
                    $('#noAgenda').html('<i class="mdi mdi-alert-octagon-outline mdi-24px text-danger"></i> Belum Ada Agenda Bulan ini');
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
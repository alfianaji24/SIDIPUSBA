<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <?php if ($meta_refresh_enable == 'yes') : ?>
        <meta http-equiv="refresh" content="<?= $meta_refresh_time; ?>">
    <?php endif; ?>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <meta name="description" content="<?= $title; ?>">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('images/favicon.png'); ?>">
    <link rel="shortcut icon" href="<?= base_url('images/favicon.png'); ?>" type="image/x-icon">
    <link href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/plyr.min.css') ?>" rel="stylesheet">
    <?= $this->renderSection('style') ?>
    <style>
        .carousel-indicators.with-margin{
            position: absolute;
            bottom: -35px;
        }
    </style>
</head>

<body style="background: url('<?= base_url() . $background ?>') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
        <div class="loader">
            <div class="loader-logo"><img src="<?= base_url('images/Logo_Puskesmas.png') ?>" alt="Preloader" width="64"></div>
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->
    <div id="app">
        <main>
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <?= $this->renderSection('modal') ?>

    <script>
        var BASE_URL = '<?= base_url() ?>';
        document.addEventListener('DOMContentLoaded', init, false);

        function init() {
            if ('serviceWorker' in navigator && navigator.onLine) {
                navigator.serviceWorker.register(BASE_URL + 'service-worker.js')
                    .then((reg) => {
                        console.log('Registrasi service worker Berhasil', reg);
                    }, (err) => {
                        console.error('Registrasi service worker Gagal', err);
                    });
            }
        }
    </script>
    
    <script src="<?= base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/axios.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/plyr.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/pusher.min.js') ?>"></script>

    <!-- Include script dari section js di semua views -->
    <?= $this->renderSection('js') ?>
</body>

</html>
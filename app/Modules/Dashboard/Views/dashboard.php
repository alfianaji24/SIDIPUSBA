<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <?php if (session()->getFlashdata('success')) { ?>
        <v-alert text outlined type="success" dense dismissible v-model="alert">
            <?= session()->getFlashdata('success') ?>
        </v-alert>
    <?php } ?>
    <v-card>
        <v-card-text>
            <?php if (session()->get('user_type') == 1) : ?>
                <h5 class="text-h5 font-weight-bold mb-3">Langkah Penggunaan</h5>
                <section id="setting" class="mb-5">
                    <h2 class="mb-3">1. Setting Aplikasi</h2>
                    <p>
                        Lakukan pengaturan aplikasi melalui menu Pengaturan, dalam menu pengaturan terdapat menu Setting Umum dan Setting Aplikasi.
                    </p>
                    <v-btn link href="<?= site_url('cuaca'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Kota/Provinsi &amp; Cuaca
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('setting/general'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Pengaturan Umum
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('setting/app'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Pengaturan Aplikasi
                    </v-btn>
                </section>
                <section id="input-display" class="mb-5">
                    <h2 class="mb-3">2. Input Data Display</h2>
                    <p>
                        Hal yang terpenting adalah menginputkan data Display yaitu data-data yang akan ditampilkan pada layar Display Informasi seperti :
                    </p>
                    <p>
                    <ul>
                        <li>Berita</li>
                        <li>Agenda</li>
                        <li>Video</li>
                        <li>Galeri</li>
                        <li>Jadwal Sholat</li>
                    </ul>
                    </p>
                    <p>
                        Untuk penggunaan pertama kali, lakukanlah sesuai dengan urutan diatas, anda dapat mengakses semua itu di menu Display.
                    </p>
                    <v-btn link href="<?= site_url('news'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Berita
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('agenda'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Agenda
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('galeri'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Galeri
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('video'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Video
                    </v-btn>&nbsp;
                    <v-btn link href="<?= site_url('jadwasholat'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Jadwal Sholat (Excel)
                    </v-btn>
                </section>
                <section id="php-ini" class="mb-5">
                    <h2 class="mb-3">3. Pengaturan file php.ini</h2>
                    <p>
                        Pengaturan file php.ini berguna dalam hal upload video dan performa aplikasi. Ukuran Maksimal berdasarkan php.ini: <strong><?= $maxsizeInfo; ?></strong>.</p>
                    <p>Ukuran Maksimal Upload Video MP4 adalah <strong>200 MB</strong>. Lokasi pengaturan ada di Modules > Video > Controllers > Api > Video.php public function upload() bagian 'rules' => max_size[video,204800] dalam ukuran KB, ganti nilai 204800 menjadi lebih besar sesuai kebutuhan (204800 KB = 200 MB), akan tetapi semakin besar ukuran file video akan menyebabkan Browser menjadi crash/freeze.
                    </p>
                    <p>Ukuran Maksimal Upload Gambar adalah <strong>50 MB</strong>. Lokasi pengaturan ada di Modules > Galeri/Kampus/RsKlinik/Sekolah/Setting > Controllers > Api > Galeri/Dosen/Dokter/Guru/Setting.php public function upload() bagian 'rules' => max_size[...,51200] dalam ukuran KB, ganti nilai 51200 menjadi lebih besar sesuai kebutuhan (51200 KB = 50 MB), akan tetapi semakin besar ukuran file akan menyebabkan Browser menjadi crash/freeze.
                    </p>
                    <p>
                    <ul>
                        <li>Lakukan pengaturan file php.ini di localhost server anda atau web server anda.<br />1. Xampp: C:\xampp\php\php.ini atau Xampp Panel > Apache > Config > PHP (php.ini). <br /> 2. Laragon: Laragon Panel > Menu > PHP > php.ini <br /> 3. cPanel: cPanel > Software > Select PHP Version (PHP Selector) > Tabs Options</li>
                        <li>Carilah parameter sebagai berikut :</li>
                        <strong>post_max_size = 200M</strong> (Rekomendasi 200M atau lebih sesuaikan kebutuhan) <br />
                        <strong>upload_max_filesize = 200M</strong> (Rekomendasi 200M atau lebih sesuaikan kebutuhan) <br />
                        <strong>memory_limit = 512M</strong> (Rekomendasi minimal 256M atau lebih sesuaikan kebutuhan) <br />
                        <br />
                        Catatan: jika Anda mengunggah file yang sangat besar (masing-masing lebih 500MB), Anda mungkin juga perlu mengubah pengaturan berikut: <br />
                        <strong>max_input_time</strong> di php.ini <br />
                        <strong>max_execution_time</strong> di php.ini <br />
                        <strong>FcgidMaxRequestLen</strong> di Apache, jika menggunakan fastcgi <br />
                        <strong>FcgidIOTimeout</strong> di Apache, jika menggunakan fastcgi <br />
                        <strong>Timeout</strong> di Apache <br />
                        <strong>LimitRequestBody</strong> in Apache <br />
                        <li>Restart Apache Webserver jika anda local host</li>
                        <li>Upload file video MP4 hingga selesai</li>
                    </ul>
                    </p>
                </section>
                <section id="pusher" class="mb-5">
                    <h2 class="mb-3">4. Pengaturan <v-badge color="error" content="new" offset-x="-2" overlap>PUSHER</v-badge>
                    </h2>
                    <p>Pusher memerlukan <strong>Koneksi Internet</strong>. Info selengkapnya ada di Folder "PDF Panduan" atau klik &nbsp;<v-btn color="primary" elevation="1" text small @click="show = true">Lihat Panduan <v-icon color="error">mdi-file-pdf-box</v-icon>
                        </v-btn>
                    </p>
                    <p>
                        1. <strong>Wajib</strong> Buat akun pusher dahulu di pusher.com lalu klik <a href="https://dashboard.pusher.com/accounts/sign_up" target="_blank">Sign up</a>
                        <br />
                        2. Masukkan Email anda dan Password Pusher (Bukan password Email) lalu klik "Sign up", setelah itu periksa inbox Email untuk klik link konfirmasi dari pusher.com<br />
                        3. Kembali ke pusher.com lalu "Sign in". Pada saat pertama kali masuk akan diarahkan untuk membuat channel app baru:<br />
                    <ul>
                        <li>Name your app: <strong>Sidipusba3-plus</strong> (Hanya contoh, isikan sesuaikan milik anda)</li>
                        <li>Select a cluster: <strong>ap1 (Asia Pacific (Singapore))</strong></li>
                        <li>Choose your tech stack (optional):</li>
                        <li>Frontend: <strong>JQuery</strong></li>
                        <li>Backend: <strong>PHP</strong></li>
                        <li>Lalu klik "Create app"</li>
                    </ul>
                    </p>
                    4. Masuk ke Channel "sidipusba3-plus" yang sudah dibuat, klik menu "App Keys".
                    Contohnya:<br />
                    <div class="pa-3">
                        <strong>App keys</strong><br />
                        app_id = "1567891"<br />
                        key = "g5ge5122f131013gbd87"<br />
                        secret = "1c42b461f7edddfc779c"<br />
                        cluster = "ap1"<br />
                    </div>
                    5. Buka file <strong>.env</strong> didalam source code project ini, buka dengan VSCode atau Notepad++ lalu scroll kebawah pada bagian "PUSHER". Isikan sesuai kode diatas seperti contoh dibawah:<br />
                    <ul>
                        <li>PUSHER_APP_ID = "1567891"</li>
                        <li>PUSHER_APP_KEY = "g5ge5122f131013gbd87"</li>
                        <li>PUSHER_APP_SECRET = "1c42b461f7edddfc779c"</li>
                    </ul><br />
                    6. Pengaturan PUSHER selesai
                </section>
                <section id="autoplay-policy" class="mb-5">
                    <h2 class="mb-3">5. Autoplay policy</h2>
                    <p>Autoplay dengan suara bisa di "allowed" jika: ada interaksi dari kita sebagai pengguna pada halaman website seperti click, tap dan confirm pada player video (play, pause). Informasi mengenai Chrome Autoplay policy ada disini <a href="https://developers.google.com/web/updates/2017/09/autoplay-policy-changes" target="_blank">Chrome Autoplay policy</a>. Oleh karena itu lakukan sedikit langkah "hack" yang dapat kita lakukan agar DISFO Video Autoplay bisa diputar dengan Suara (Sound), yaitu dengan cara-cara dibawah ini:</p>
                    <p><strong>Browser Chrome/Opera:</p></strong>
                    Sesuaikan OS Anda, Anda harus:<br />
                    a. Mac<br />
                    Open terminal dan execute command untuk membuka Chrome:<br />

                    <code style="font-size: 14px;">/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --autoplay-policy=no-user-gesture-required</code><br />

                    b. Windows<br />
                    Klik Kanan pada ikon Chrome/Opera di desktop >> Properties >> tambahkan dibelakang setelah <code style="font-size: 14px;">path\to\Application\chrome.exe"</code> atau <code style="font-size: 14px;">path\to\Programs\Opera\launcher.exe"</code>[Spasi]<code style="font-size: 14px;"><strong>--autoplay-policy=no-user-gesture-required</strong></code> pada kotak Target >> Apply dan OK.<br />

                    <v-img src="<?= base_url('images/chrome-autoplay.png'); ?>" max-width="400"></v-img>

                    Tutup dan Buka Kembali Browsernya.<br />
                    </p>
                    <p>Setelah selesai langkah diatas maka DISFO Video akan otomatis Autoplay dengan Suara (Sound).</p>
                    <p>Anda dapat memutar DISFO Video Autoplay tanpa Suara dengan mengaktifkan "video_muted" pada menu Dashboard > Pengaturan > Aplikasi > video_muted > klik pada ikon pencil > lalu Value Setting pilih "Ya" > lalu Simpan</p>
                    <p>Panduan selengkapnya ada di folder "PDF Panduan"</p>
                </section>
                <section id="display-show">
                    <h2 class="mb-3">6. Jalankan Display</h2>
                    <p>
                        Setelah semua siap hubungkan perangkat anda ke TV LED. Logout dan klik Menu <strong>Display</strong> untuk menjalankan tampilan Display Informasi anda. Tekan tombol
                        keyboard <strong>F11</strong> untuk fullscreen view. Atur Zoom in dan Zoom out pada tampilan browser anda. (minimum resolution VGA 1280 x 1024, rekomendasi FullHD 1920 x 1080)
                    </p>
                </section>
            <?php endif; ?>

            <?php if ((session()->get('user_type') == 2) || (session()->get('user_type') == 3)) : ?>
                <section id="layout" class="mb-5">
                    <h2 class="mb-3">1. Pilih Layout</h2>
                    <p>
                        Pilih Layout yang digunakan untuk Display.
                    </p>
                    <v-btn link href="<?= site_url('layout'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Layout
                    </v-btn>&nbsp;
                </section>
                <section id="display-show">
                    <h2 class="mb-3">2. Jalankan Display</h2>
                    <p>
                        Setelah semua siap hubungkan perangkat anda ke TV LED. Logout dan klik Menu <strong>Display</strong> untuk menjalankan tampilan Display Informasi anda. Tekan tombol
                        keyboard <strong>F11</strong> untuk fullscreen view. Atur Zoom in dan Zoom out pada tampilan browser anda. (minimum resolution TV 1366 x 768)
                    </p>
                    <v-btn link href="<?= site_url('display'); ?>">
                        <v-icon>mdi-arrow-right</v-icon> Lihat Display
                    </v-btn>&nbsp;
                </section>
            <?php endif; ?>
        </v-card-text>
    </v-card>
</template>

<!-- Modal -->
<template>
    <v-dialog v-model="show" fullscreen persistent scrollable>
        <v-card>
            <v-card-title>
                Panduan Pengaturan Pusher
                <v-spacer></v-spacer>
                <v-btn icon @click="show = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <object data="<?= base_url('files/Panduan_Pengaturan_PUSHER.pdf'); ?>" type="application/pdf" width="100%" height="100%">
                    <iframe src="<?= base_url('files/Panduan_Pengaturan_PUSHER.pdf'); ?>" width="100%" height="100%" style="border: none;">
                        This browser does not support PDFs. Please download the PDF to view it:
                        <a href="<?= base_url('files/Panduan_Pengaturan_PUSHER.pdf'); ?>">Download PDF</a>
                    </iframe>
                </object>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn large color="primary" @click="show = false" :loading="loading" elevation="1">
                    <?= lang('App.close') ?>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<!-- End Modal Save -->

<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    const token = JSON.parse(localStorage.getItem('access_token'));
    const options = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };
    // Deklarasi errorKeys
    var errorKeys = []
    computedVue = {
        ...computedVue,

    }
    dataVue = {
        ...dataVue,
        alert: true,

    }
    createdVue = function() {
        setTimeout(() => {
            this.alert = false
        }, 10000)

    }
    methodsVue = {
        ...methodsVue,

    }
</script>
<?php $this->endSection("js") ?>
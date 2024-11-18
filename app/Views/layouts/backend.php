<?php

use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['nama_aplikasi'];
$logo = $setting->info['logo'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title><?= $title ?> - <?= $appname ?></title>
    <link rel="apple-touch-icon" href="<?= base_url('images/favicon.png'); ?>">
    <link rel="shortcut icon" href="<?= base_url('images/favicon.png'); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/vuetify.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">

    <style>
        input[type="color"] {
            appearance: none;
            border: none;
            width: 32px;
            height: 32px;
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
        }
    </style>

</head>

<body>
    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
        <div class="loader">
            <div class="loader-logo"><img src="<?= base_url('images/Logo_Puskesmas.png'); ?>" alt="Preloader" width="64" style="margin-top: 5px !important"></div>
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
        <v-app>
            <v-app-bar app elevation="2">
                <v-app-bar-nav-icon @click.stop="sidebarMenu = !sidebarMenu"></v-app-bar-nav-icon>
                <v-toolbar-title></v-toolbar-title>
                <v-spacer></v-spacer>
                <?php if (!empty(session()->get('username'))) : ?>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn text v-bind="attrs" v-on="on">
                                <v-icon>mdi-account-circle</v-icon> <?= session()->get('username') ?> <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item class="d-flex justify-center">
                                <v-list-item-avatar size="100">
                                    <v-img src="<?= base_url('assets/images/default.png'); ?>"></v-img>
                                </v-list-item-avatar>
                            </v-list-item>
                            <v-list-item link>
                                <v-list-item-content>
                                    <v-list-item-title class="text-h6">
                                        Hallo, <?= session()->get('fullname') ?>
                                    </v-list-item-title>
                                    <v-list-item-subtitle><?= session()->get('email') ?></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-subheader>Login: &nbsp;<v-chip color="primary" small><?= session()->get('user_type') == 1 ? 'admin' : 'user'; ?></v-chip>
                            </v-subheader>
                            <v-list-item link href="<?= base_url(); ?>">
                                <v-list-item-icon>
                                    <v-icon>mdi-home</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Back to Home</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item link href="<?= base_url('logout'); ?>" @click="localStorage.removeItem('access_token')">
                                <v-list-item-icon>
                                    <v-icon>mdi-logout</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Logout</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                <?php endif; ?>
            </v-app-bar>

            <v-navigation-drawer color="blue darken-3" dark v-model="sidebarMenu" app floating :permanent="sidebarMenu" :mini-variant.sync="mini" v-if="!isMobile" class="elevation-3">
                <v-list color="blue darken-3" dense>
                    <v-list-item>
                        <v-list-item-action>
                            <v-icon @click.stop="toggleMini = !toggleMini">mdi-chevron-left</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="text-h6">
                                SIDIPUSBA
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-divider></v-divider>
                <v-list nav>
                    <?php $uri = new \CodeIgniter\HTTP\URI(current_url()); ?>

                    <v-list-item link href="<?= base_url('display'); ?>" alt="Lihat Display" title="Lihat Display" target="_blank">
                        <v-list-item-icon>
                            <v-icon>mdi-arrow-right</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Lihat Display</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link href="<?= base_url('dashboard'); ?>" <?php if ($uri->getSegment(1) == "dashboard") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> alt="Dashboard" title="Dashboard">
                        <v-list-item-icon>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Dashboard</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group v-for="(item, i) in displays" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.title"></v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                            <v-list-item-icon>
                                <v-icon>mdi-file-document</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="child.title">Display</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>

                    <?php if (session()->get('user_type') == 1) : ?>

                        <v-list-item link href="<?= base_url('layout'); ?>" <?php if ($uri->getSegment(1) == "layout") : ?><?php echo 'class="v-item--active v-list-item--active"'; ?><?php endif; ?> alt="Layout" title="Layout">
                            <v-list-item-icon>
                                <v-icon>mdi-view-dashboard</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Layout</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-group v-for="(item, i) in masjid" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white" v-show="menu_masjid == true">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                                <v-list-item-icon>
                                    <v-icon>mdi-mosque</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>

                        <v-list-group v-for="(item, i) in kampus" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white" v-show="menu_kampus == true">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                                <v-list-item-icon>
                                    <v-icon>mdi-school</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>

                        <v-list-group v-for="(item, i) in sekolah" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white" v-show="menu_sekolah == true">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                                <v-list-item-icon>
                                    <v-icon>mdi-school</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>

                        <v-list-group v-for="(item, i) in rsklinik" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white" v-show="menu_rsklinik == true">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                                <v-list-item-icon>
                                    <v-icon>mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>

                        <v-list-group v-for="(item, i) in settings" :key="item.title" v-model="item.active" :prepend-icon="item.action" color="white">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item v-for="child in item.items" :key="child.title" link :href="child.url" v-model="child.active">
                                <v-list-item-icon>
                                    <v-icon>{{child.icon}}</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.title"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    <?php endif; ?>

                    <?php if ((session()->get('user_type') == 2) || (session()->get('user_type') == 3)) : ?>

                    <?php endif; ?>
                </v-list>

                <template v-slot:append>
                    <v-divider></v-divider>
                    <div class="text-center">
                        <v-list-item>
                            <v-list-item-icon style="font-size:12px;" v-if="toggleMini">
                                &copy; 2022-{{ new Date().getFullYear() }}
                            </v-list-item-icon>
                            <v-list-item-content style="font-size:12px;" v-else>&copy; 2022-{{ new Date().getFullYear() }} <?= COMPANY_NAME; ?> - <?= APP_NAME . ' ' . APP_VERSION; ?></v-list-item-content>
                        </v-list-item>
                    </div>
                </template>

            </v-navigation-drawer>

            <v-main>
                <?php if ((env('PUSHER_APP_KEY') == "") && (env('PUSHER_APP_SECRET') == "") && (env('PUSHER_APP_ID') == "")) { ?>
                    <v-alert prominent type="error" icon="mdi-alert-octagon">
                        <v-row align="center">
                            <v-col class="grow">
                                Data Pusher (PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET) masih kosong di file <strong>.env</strong>
                            </v-col>
                            <v-col class="shrink">
                                <v-btn color="primary" href="<?= base_url(); ?>dashboard#pusher">Info</v-btn>
                            </v-col>
                        </v-row>
                    </v-alert>
                <?php } ?>
                <v-container class="pa-5" fluid>
                    <?= $this->renderSection('content') ?>
                </v-container>
            </v-main>

            <v-snackbar v-model="snackbar" :timeout="timeout" style="bottom:20px;">
                <span v-if="snackbar">{{snackbarMessage}}</span>
                <template v-slot:action="{ attrs }">
                    <v-btn text v-bind="attrs" @click="snackbar = false">
                        ok
                    </v-btn>
                </template>
            </v-snackbar>
        </v-app>
    </div>

    <script src="<?= base_url('assets/js/vue.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vuetify.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/axios.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/VuePlupload.umd.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vue-masonry-plugin-window.js') ?>"></script>

    <script>
        var vue = null;
        var computedVue = {
            mini: {
                get() {
                    return this.$vuetify.breakpoint.xsOnly || this.toggleMini;
                },
                set(value) {
                    this.toggleMini = value;
                }
            },
            isMobile() {
                if (this.$vuetify.breakpoint.xsOnly) {
                    return this.sidebarMenu = false
                }
            },
            themeText() {
                return this.$vuetify.theme.dark ? '<?= lang('App.dark') ?>' : '<?= lang('App.light') ?>'
            }
        }
        var createdVue = function() {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        }
        var mountedVue = function() {
            const theme = localStorage.getItem("dark_theme");
            if (theme) {
                if (theme === "true") {
                    this.$vuetify.theme.dark = true;
                    this.dark = true;
                } else {
                    this.$vuetify.theme.dark = false;
                    this.dark = false;
                }
            } else if (
                window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                this.$vuetify.theme.dark = false;
                localStorage.setItem(
                    "dark_theme",
                    this.$vuetify.theme.dark.toString()
                );
            }

            const menu_masjid = localStorage.getItem("menu_masjid");
            if (menu_masjid) {
                if (menu_masjid === "true") {
                    this.menu_masjid = true;
                } else {
                    this.menu_masjid = false;
                }
            }

            const menu_kampus = localStorage.getItem("menu_kampus");
            if (menu_kampus) {
                if (menu_kampus === "true") {
                    this.menu_kampus = true;
                } else {
                    this.menu_kampus = false;
                }
            }

            const menu_sekolah = localStorage.getItem("menu_sekolah");
            if (menu_sekolah) {
                if (menu_sekolah === "true") {
                    this.menu_sekolah = true;
                } else {
                    this.menu_sekolah = false;
                }
            }

            const menu_rsklinik = localStorage.getItem("menu_rsklinik");
            if (menu_rsklinik) {
                if (menu_rsklinik === "true") {
                    this.menu_rsklinik = true;
                } else {
                    this.menu_rsklinik = false;
                }
            }
        }
        var watchVue = {
            menu_masjid: function() {
                localStorage.setItem("menu_masjid", this.menu_masjid);
            },
            menu_kampus: function() {
                localStorage.setItem("menu_kampus", this.menu_kampus);
            },
            menu_sekolah: function() {
                localStorage.setItem("menu_sekolah", this.menu_sekolah);
            },
            menu_rsklinik: function() {
                localStorage.setItem("menu_rsklinik", this.menu_rsklinik);
            },
        }
        var dataVue = {
            sidebarMenu: true,
            rightMenu: false,
            toggleMini: false,
            dark: false,
            group: null,
            search: '',
            loading: false,
            loading1: false,
            loading2: false,
            loading3: false,
            loading4: false,
            loading5: false,
            valid: true,
            notifMessage: '',
            notifType: '',
            snackbar: false,
            timeout: 4000,
            snackbarType: '',
            snackbarMessage: '',
            show: false,
            show1: false,
            show2: false,
            rules: {
                email: v => !!(v || '').match(/@/) || '<?= lang('App.emailValid'); ?>',
                length: len => v => (v || '').length <= len || `<?= lang('App.invalidLength'); ?> ${len}`,
                password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
                    '<?= lang('App.strongPassword'); ?>',
                min: v => (v || '').length >= 8 || '<?= lang('App.minChar'); ?>',
                required: v => !!v || '<?= lang('App.isRequired'); ?>',
                number: v => Number.isInteger(Number(v)) || "<?= lang('App.isNumber'); ?>",
                zero: v => v > 0 || "<?= lang('App.isZero'); ?>",
                varchar: v => (v || '').length <= 255 || 'Maks 255 Karakter'
            },
            displays: [{
                title: 'Display',
                action: 'mdi-monitor-dashboard',
                active: <?php if ($uri->getSegment(1) == "news" || $uri->getSegment(1) == "agenda" || $uri->getSegment(1) == "galeri" || $uri->getSegment(1) == "video" || $uri->getSegment(1) == "cuaca" || $uri->getSegment(1) == "custom") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'News',
                        url: '<?= base_url('news'); ?>',
                        active: <?php if ($uri->getSegment(1) == "news") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Agenda',
                        url: '<?= base_url('agenda'); ?>',
                        active: <?php if ($uri->getSegment(1) == "agenda") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Galeri',
                        url: '<?= base_url('galeri'); ?>',
                        active: <?php if ($uri->getSegment(1) == "galeri") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Video',
                        url: '<?= base_url('video'); ?>',
                        active: <?php if ($uri->getSegment(1) == "video") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Cuaca',
                        url: '<?= base_url('cuaca'); ?>',
                        active: <?php if ($uri->getSegment(1) == "cuaca") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Custom',
                        url: '<?= base_url('custom'); ?>',
                        active: <?php if ($uri->getSegment(1) == "custom") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],
            }, ],
            menu_masjid: true,
            masjid: [{
                title: 'Masjid',
                action: 'mdi-mosque',
                active: <?php if ($uri->getSegment(1) == "jadwalsholat" || $uri->getSegment(1) == "agamaquotes" || $uri->getSegment(1) == "keuanganmasjid") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'Jadwal Sholat',
                        url: '<?= base_url('jadwalsholat'); ?>',
                        active: <?php if ($uri->getSegment(1) == "jadwalsholat") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Quotes Agama',
                        url: '<?= base_url('agamaquotes'); ?>',
                        active: <?php if ($uri->getSegment(1) == "agamaquotes") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Keuangan Masjid',
                        url: '<?= base_url('keuanganmasjid'); ?>',
                        active: <?php if ($uri->getSegment(1) == "keuanganmasjid") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],

            }, ],
            menu_kampus: true,
            kampus: [{
                title: 'Kampus',
                action: 'mdi-school',
                active: <?php if ($uri->getSegment(1) == "dosen" || $uri->getSegment(1) == "skripsi") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'Dosen & Staf',
                        url: '<?= base_url('dosen'); ?>',
                        active: <?php if ($uri->getSegment(1) == "dosen") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Ujian Skripsi',
                        url: '<?= base_url('skripsi'); ?>',
                        active: <?php if ($uri->getSegment(1) == "skripsi") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],

            }, ],
            menu_sekolah: true,
            sekolah: [{
                title: 'Sekolah',
                action: 'mdi-school',
                active: <?php if ($uri->getSegment(1) == "jadwalpelajaran" || $uri->getSegment(1) == "jampelajaran" || $uri->getSegment(1) == "haribelajar" || $uri->getSegment(1) == "kelas" || $uri->getSegment(1) == "guru") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'Jadwal Pelajaran',
                        url: '<?= base_url('jadwalpelajaran'); ?>',
                        active: <?php if ($uri->getSegment(1) == "jadwalpelajaran") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Jam Pelajaran',
                        url: '<?= base_url('jampelajaran'); ?>',
                        active: <?php if ($uri->getSegment(1) == "jampelajaran") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Hari Belajar',
                        url: '<?= base_url('haribelajar'); ?>',
                        active: <?php if ($uri->getSegment(1) == "haribelajar") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Kelas',
                        url: '<?= base_url('kelas'); ?>',
                        active: <?php if ($uri->getSegment(1) == "kelas") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Guru',
                        url: '<?= base_url('guru'); ?>',
                        active: <?php if ($uri->getSegment(1) == "guru") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],

            }, ],
            menu_rsklinik: true,
            rsklinik: [{
                title: 'RS/Klinik',
                action: 'mdi-medical-bag',
                active: <?php if ($uri->getSegment(1) == "dokter" || $uri->getSegment(1) == "ruangan" || $uri->getSegment(1) == "harilayanan" || $uri->getSegment(1) == "jampelayanan" || $uri->getSegment(1) == "jadwaldokter") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'Jadwal Dokter',
                        url: '<?= base_url('jadwaldokter'); ?>',
                        active: <?php if ($uri->getSegment(1) == "jadwaldokter") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Hari Layanan',
                        url: '<?= base_url('harilayanan'); ?>',
                        active: <?php if ($uri->getSegment(1) == "harilayanan") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Jam Pelayanan',
                        url: '<?= base_url('jampelayanan'); ?>',
                        active: <?php if ($uri->getSegment(1) == "jampelayanan") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Ruangan',
                        url: '<?= base_url('ruangan'); ?>',
                        active: <?php if ($uri->getSegment(1) == "ruangan") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Dokter',
                        url: '<?= base_url('dokter'); ?>',
                        active: <?php if ($uri->getSegment(1) == "dokter") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],

            }, ],
            settings: [{
                title: 'Pengaturan',
                action: 'mdi-cog',
                active: <?php if ($uri->getSegment(2) == "general" || $uri->getSegment(2) == "app" || $uri->getSegment(1) == "user" || $uri->getSegment(1) == "backup") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                items: [{
                        title: 'Umum',
                        icon: 'mdi-cog-outline',
                        url: '<?= base_url('setting/general'); ?>',
                        active: <?php if ($uri->getSegment(2) == "general") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Aplikasi',
                        icon: 'mdi-cog-outline',
                        url: '<?= base_url('setting/app'); ?>',
                        active: <?php if ($uri->getSegment(2) == "app") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Users',
                        icon: 'mdi-account-multiple',
                        url: '<?= base_url('user'); ?>',
                        active: <?php if ($uri->getSegment(1) == "user") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                    {
                        title: 'Backup DB',
                        icon: 'mdi-database',
                        url: '<?= base_url('backup'); ?>',
                        active: <?php if ($uri->getSegment(1) == "backup") { ?><?php echo 'true'; ?><?php } else { ?><?php echo 'false'; ?><?php } ?>,
                    },
                ],

            }, ],
        }
        var methodsVue = {
            toggleTheme() {
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
                localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            },
            initmenuMasjid: function() {
                const stored = localStorage.getItem("menu_masjid");
                if (stored === null) {
                    return true;
                } else {
                    return stored == 'true';
                }
            },
            initmenuKampus: function() {
                const stored = localStorage.getItem("menu_kampus");
                if (stored === null) {
                    return true;
                } else {
                    return stored == 'true';
                }
            },
            initmenuSekolah: function() {
                const stored = localStorage.getItem("menu_sekolah");
                if (stored === null) {
                    return true;
                } else {
                    return stored == 'true';
                }
            },
            initmenuRsklinik: function() {
                const stored = localStorage.getItem("menu_rsklinik");
                if (stored === null) {
                    return true;
                } else {
                    return stored == 'true';
                }
            }
        }
        Vue.use(VuePlupload);
        var VueMasonryPlugin = window["vue-masonry-plugin"].VueMasonryPlugin;
        Vue.use(VueMasonryPlugin);
    </script>
    <?= $this->renderSection('js') ?>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            computed: computedVue,
            data: dataVue,
            mounted: mountedVue,
            created: createdVue,
            watch: watchVue,
            methods: methodsVue,
        })
    </script>
</body>

</html>
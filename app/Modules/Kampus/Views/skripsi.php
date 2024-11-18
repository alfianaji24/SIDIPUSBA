<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1 class="font-weight-medium"><?= $title; ?></h1>
        </v-card-title>
        <v-toolbar flat>
            <!-- Button Tambah -->
            <v-btn color="primary" dark large @click="modalAddOpen" elevation="1">
                <v-icon>mdi-plus</v-icon> <?= lang('App.add') ?>
            </v-btn>
            <v-spacer></v-spacer>
            <v-text-field v-model="pencarian" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details>
            </v-text-field>
        </v-toolbar>
        <v-data-table :headers="dataHeader" :items="dataSkripsi" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.id}}</td>
                    <td>{{item.npm}}</td>
                    <td>{{item.nama_mhs}}</td>
                    <td>{{item.tanggal_skripsi}}</td>
                    <td>{{item.judul_skripsi}}</td>
                    <td>{{item.waktu}}</td>
                    <td>{{item.ruang}}</td>
                    <td width="200">
                        <v-btn color="primary" class="mr-2" icon @click="editItem(item)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn color="error" icon @click="deleteItem(item)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<!-- Modal -->
<!-- Modal Save -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" max-width="900px" persistent scrollable>
            <v-card>
                <v-card-title>
                    <?= lang('App.add') ?> <?= $title; ?>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalAddClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                        <v-row>
                            <v-col col="12" sm="5">
                                <p class="mb-2 text-subtitle-1">NPM</p>
                                <v-text-field v-model="npm" :error-messages="npmError" outlined></v-text-field>
                            </v-col>
                            <v-col col="12" sm="7">
                                <p class="mb-2 text-subtitle-1">Nama Mahasiswa</p>
                                <v-text-field v-model="namaMhs" :error-messages="nama_mhsError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                        <p class="mb-2 text-subtitle-1">Judul Skripsi</p>
                        <v-textarea v-model="judulSkripsi" :error-messages="judul_skripsiError" :rules="[rules.varchar]" rows="3" auto-grow counter outlined></v-textarea>

                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Ruangan</p>
                                <v-autocomplete v-model="ruang" label="Pilih Ruangan" :items="dataRuang" item-text="nama_ruang" item-value="nama_ruang" :error-messages="ruangError" :loading="loading2" outlined append-outer-icon="mdi-plus-thick" @click:append-outer="addRuang"></v-autocomplete>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tanggal</p>
                                <v-menu ref="date" v-model="date" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tanggalSkripsi" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggal_skripsiError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tanggalSkripsi" @input="date = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Waktu</p>
                                <v-menu ref="time" v-model="time" :close-on-content-click="false" :return-value.sync="waktu" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="waktu" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="waktuError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="time" v-model="waktu" full-width @click:minute="$refs.time.save(waktu)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveSkripsi" :loading="loading" elevation="1">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Save -->
<!-- Modal Edit -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalEdit" max-width="900px" persistent scrollable>
            <v-card>
                <v-card-title>
                    <?= lang('App.edit') ?> <?= $title; ?>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalEditClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                    <v-row>
                            <v-col col="12" sm="5">
                                <p class="mb-2 text-subtitle-1">NPM</p>
                                <v-text-field v-model="npm" :error-messages="npmError" outlined></v-text-field>
                            </v-col>
                            <v-col col="12" sm="7">
                                <p class="mb-2 text-subtitle-1">Nama Mahasiswa</p>
                                <v-text-field v-model="namaMhs" :error-messages="nama_mhsError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                        <p class="mb-2 text-subtitle-1">Judul Skripsi</p>
                        <v-textarea v-model="judulSkripsi" :error-messages="judul_skripsiError" :rules="[rules.varchar]" rows="3" auto-grow counter outlined></v-textarea>

                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Ruangan</p>
                                <v-autocomplete v-model="ruang" label="Pilih Ruangan" :items="dataRuang" item-text="nama_ruang" item-value="nama_ruang" :error-messages="ruangError" :loading="loading2" outlined append-outer-icon="mdi-plus-thick" @click:append-outer="addRuang"></v-autocomplete>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tanggal</p>
                                <v-menu ref="date" v-model="date" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tanggalSkripsi" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggal_skripsiError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tanggalSkripsi" @input="date = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Waktu</p>
                                <v-menu ref="time" v-model="time" :close-on-content-click="false" :return-value.sync="waktu" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="waktu" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="waktuError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="time" v-model="waktu" full-width @click:minute="$refs.time.save(waktu)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateSkripsi" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Edit -->
<!-- Modal Delete -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalDelete" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> <?= lang('App.delConfirm') ?>
                </v-card-title>
                <v-card-text>
                    <div class="mt-5 py-4">
                        <h2 class="font-weight-regular">Apakah anda yakin ingin menghapus?</h2>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large text @click="modalDeleteClose"><?= lang('App.no') ?></v-btn>
                    <v-btn large color="primary" dark @click="deleteSkripsi" :loading="loading"><?= lang('App.yes') ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<!-- Modal Ruang -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalRuang" persistent max-width="700px">
            <v-card class="pa-2">
                <v-card-title>
                    Daftar Ruangan
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalRuangClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="form" v-model="valid">
                        <v-container>
                            <v-row>
                                <v-col cols="12" md="7">
                                    <v-text-field label="Nama Ruang" v-model="namaRuang" type="text" :error-messages="nama_ruangError"></v-text-field>
                                </v-col>

                                <v-col cols="12" md="5">
                                    <v-btn color="primary" large @click="saveRuang" :loading="loading2"><?= lang('App.add') ?></v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                    <v-data-table :headers="tbRuang" :items="dataRuang" :items-per-page="5" class="elevation-1" :loading="loading1">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="error" icon @click="deleteRuang(item)" :loading="loading4">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text large @click="modalRuangClose"><?= lang('App.close') ?></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<!-- Loading4 -->
<v-dialog v-model="loading4" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            Memuat, silahkan tunggu...
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
<!-- End Loading4 -->
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    const token = JSON.parse(localStorage.getItem('access_token'));
    const options = {
        headers: {
            //"Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    // Deklarasi errorKeys
    var errorKeys = []

    dataVue = {
        ...dataVue,
        pencarian: "",
        modalAdd: false,
        modalEdit: false,
        modalShow: false,
        modalDelete: false,
        modalRuang: false,
        date: false,
        date2: false,
        time: false,
        time2: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "NPM",
            value: "npm"
        }, {
            text: "Nama",
            value: "nama_mhs"
        }, {
            text: "Tanggal",
            value: "tanggal_skripsi"
        }, {
            text: "Judul",
            value: "judul"
        }, {
            text: "Waktu",
            value: "waktu"
        }, {
            text: "Ruang",
            value: "ruang"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataSkripsi: [],
        dataRuang: [],
        idSkripsi: "",
        npm: "",
        npmError: "",
        namaMhs: "",
        nama_mhsError: "",
        tanggalSkripsi: "",
        tanggal_skripsiError: "",
        judulSkripsi: "",
        judul_skripsiError: "",
        waktu: "",
        waktuError: "",
        ruang: "",
        ruangError: "",
        namaRuang: "",
        nama_ruangError: "",
        jenisRuang: "kampus",
        jenis_ruangError: "",
        tbRuang: [{
                text: '#',
                value: 'id'
            },
            {
                text: 'Nama Ruang',
                value: 'nama_ruang'
            },
            {
                text: '<?= lang('App.action') ?>',
                value: 'actions',
                sortable: false
            },
        ],
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getSkripsi();
        this.getRuang();
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
            //this.$refs.form.resetValidation();
            //this.$refs.form.reset();
        },

        modalAddClose: function() {
            this.modalAdd = false;
            //this.$refs.form.resetValidation();
        },

        // Get Data
        getSkripsi: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/skripsi')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataSkripsi = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Save Skripsi
        saveSkripsi: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/skripsi/save`, {
                    npm: this.npm,
                    nama_mhs: this.namaMhs,
                    tanggal_skripsi: this.tanggalSkripsi,
                    judul_skripsi: this.judulSkripsi,
                    waktu: this.waktu,
                    ruang: this.ruang,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getSkripsi();
                        this.npm = "";
                        this.namaMhs = "";
                        this.tanggalSkripsi = "";
                        this.judulSkripsi = "";
                        this.waktu = "";
                        this.ruang = "";
                        this.modalAdd = false;
                        this.$refs.form.resetValidation();
                        this.$refs.form.reset();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.modalAdd = true;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Item Edit
        editItem: function(item) {
            this.modalEdit = true;
            this.idSkripsi = item.id;
            this.npm = item.npm;
            this.namaMhs = item.nama_mhs;
            this.tanggalSkripsi = item.tanggal_skripsi;
            this.judulSkripsi = item.judul_skripsi;
            this.waktu = item.waktu;
            this.ruang = item.ruang;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Skripsi
        updateSkripsi: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/skripsi/update/${this.idSkripsi}`, {
                    npm: this.npm,
                    nama_mhs: this.namaMhs,
                    tanggal_skripsi: this.tanggalSkripsi,
                    judul_skripsi: this.judulSkripsi,
                    waktu: this.waktu,
                    ruang: this.ruang,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getSkripsi();
                        this.npm = "";
                        this.namaMhs = "";
                        this.tanggalSkripsi = "";
                        this.judulSkripsi = "";
                        this.waktu = "";
                        this.ruang = "";
                        this.modalEdit = false;
                        this.$refs.form.resetValidation();
                        this.$refs.form.reset();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.modalEdit = true;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Item Delete
        deleteItem: function(item) {
            this.modalDelete = true;
            this.idSkripsi = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Skripsi
        deleteSkripsi: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/skripsi/delete/${this.idSkripsi}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getSkripsi();
                        this.modalDelete = false;
                        this.$refs.form.resetValidation();
                        this.$refs.form.reset();
                    } else {
                        this.modalDelete = true;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Ruang
        getRuang: function() {
            this.loading1 = true;
            axios.get('<?= base_url(); ?>api/ruang_kampus', options)
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.dataRuang = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Modal Ruang
        addRuang: function() {
            this.modalRuang = true;
        },
        modalRuangClose: function() {
            this.modalRuang = false;
            this.$refs.form.resetValidation();
        },

        // Save Ruang
        saveRuang: function() {
            this.loading2 = true;
            axios.post(`<?= base_url(); ?>api/ruang/save`, {
                    nama_ruang: this.namaRuang,
                    jenis_ruang: this.jenisRuang,
                }, options)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.namaRuang = "";
                        this.getRuang();
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Delete Ruang
        deleteRuang: function(item) {
            this.loading4 = true;
            axios.delete(`<?= base_url(); ?>api/ruang/delete/${item.id}`, options)
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getRuang();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },
    }
</script>
<?php $this->endSection("js") ?>
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
                <v-icon>mdi-calendar</v-icon> Isi Jadwal
            </v-btn>
            <v-spacer></v-spacer>
            <v-select v-model="idHari" label="Hari" :items="dataHari" item-text="text" item-value="value" single-line hide-details style="width: 50px;" @change="submitJadwal" multiple></v-select>

            <v-text-field v-model="pencarian" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details>
            </v-text-field>
        </v-toolbar>
        <v-data-table :headers="dataHeader" :items="dataJadwal" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.id}}</td>
                    <td>{{item.hari.toUpperCase()}}</td>
                    <td>{{item.nama_kelas}}</td>
                    <td>{{item.jam_ke}} ({{item.mulai}}-{{item.selesai}})</td>
                    <td>{{item.nama_lengkap}}</td>
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
                    <?= lang('App.add') ?> <?= $title; ?> {{String(idHari).toUpperCase()}}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalAddClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                        <p class="mb-2 text-subtitle-1">Hari</p>
                        <p>{{String(idHari).toUpperCase()}}</p>

                        <p class="mb-2 text-subtitle-1">Jam Ke</p>
                        <v-select v-model="jamKe" :items="dataJam" :item-text="dataJam =>`KBM Jam Ke: ${dataJam.jam_ke}, Waktu: ${dataJam.mulai} - ${dataJam.selesai} `" item-value="jam_ke" label="Pilih Jam" :error-messages="jam_keError" outlined></v-select>

                        <p class="mb-2 text-subtitle-1">Kelas</p>
                        <v-autocomplete v-model="idKelas" :items="dataKelas" item-text="nama_kelas" item-value="id" label="Pilih Kelas" :error-messages="id_kelasError" outlined></v-autocomplete>

                        <p class="mb-2 text-subtitle-1">Guru</p>
                        <v-autocomplete v-model="idGuru" :items="dataGuru" :item-text="dataGuru =>`${dataGuru.nip_nik} / ${dataGuru.nama_lengkap} - ${dataGuru.jabatan} `" item-value="id" label="Pilih Guru" :error-messages="id_guruError" outlined></v-autocomplete>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveJadwal" :loading="loading" elevation="1">
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
                        <p class="mb-2 text-subtitle-1">Hari</p>
                        <p>{{String(idHari).toUpperCase()}}</p>

                        <p class="mb-2 text-subtitle-1">Jam Ke</p>
                        <v-select v-model="jamKe" :items="dataJam" :item-text="dataJam =>`KBM Jam Ke: ${dataJam.jam_ke}, Waktu: ${dataJam.mulai} - ${dataJam.selesai} `" item-value="jam_ke" label="Pilih Jam" outlined></v-select>

                        <p class="mb-2 text-subtitle-1">Kelas</p>
                        <v-autocomplete v-model="idKelas" :items="dataKelas" item-text="nama_kelas" item-value="id" label="Pilih Kelas" outlined></v-autocomplete>

                        <p class="mb-2 text-subtitle-1">Guru</p>
                        <v-autocomplete v-model="idGuru" :items="dataGuru" :item-text="dataGuru =>`${dataGuru.nip_nik} / ${dataGuru.nama_lengkap} - ${dataGuru.jabatan} `" item-value="id" label="Pilih Guru" outlined></v-autocomplete>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateJadwal" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteJadwal" :loading="loading"><?= lang('App.yes') ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<v-dialog v-model="modalShow" persistent width="500">
    <v-card>
        <v-card-title class="text-h5 grey lighten-2 mb-5">
            Daftar Hari
        </v-card-title>

        <v-card-text>
            <v-select v-model="idHari" label="Pilih Hari" :items="dataHari" item-text="text" item-value="value" class="mb-1" single-line hide-details @change="submitJadwal" multiple outlined></v-select>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click="modalShow = false" :disabled="idHari == ''">
                Simpan
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

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
        modalShow: true,
        modalDelete: false,
        modalTgl: false,
        modalJam: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Hari",
            value: "hari"
        }, {
            text: "Kelas",
            value: "nama_kelas"
        }, {
            text: "Jam Ke",
            value: "jam_ke"
        }, {
            text: "Guru",
            value: "nama_lengkap"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataJadwal: [],
        dataHari: [{
            text: "Senin",
            value: "senin"
        }, {
            text: "Selasa",
            value: "selasa"
        }, {
            text: "Rabu",
            value: "rabu"
        }, {
            text: "Kamis",
            value: "kamis"
        }, {
            text: "Jumat",
            value: "jumat"
        }, {
            text: "Sabtu",
            value: "sabtu"
        }],
        dataKelas: [],
        dataGuru: [],
        dataJam: [],
        idJadwal: "",
        idKelas: "",
        id_kelasError: "",
        jamKe: "",
        jam_keError: "",
        idHari: "",
        hariError: "",
        idGuru: "",
        id_guruError: ""
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getJadwal();
        this.getJam();
        this.getKelas();
        this.getGuru();
    }

    watchVue = {
        ...watchVue,
        idHari: function() {
            if (this.idHari.length > 1) {
                this.idHari.pop();
                this.snackbar = true;
                this.snackbarMessage = "Anda hanya dapat memilih 1";
            }
        },
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

        submitJadwal: function() {
            this.getJadwal();
            this.getJam();
        },

        // Get Data
        getJadwal: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>api/jadwalpelajaran?hari=${this.idHari}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataJadwal = data.data;
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

        // Get Data
        getGuru: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/guru')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataGuru = data.data;
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

        // Get Data
        getKelas: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/kelas')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataKelas = data.data;
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

        // Get Data
        getJam: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>api/harijambelajar?hari=${this.idHari}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataJam = data.data;
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

        // Save Jadwal
        saveJadwal: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/jadwalpelajaran/save`, {
                    id_kelas: this.idKelas,
                    jam_ke: this.jamKe,
                    hari: this.idHari,
                    id_guru: this.idGuru,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.submitJadwal();
                        this.idKelas = "";
                        this.jamKe = "";
                        this.idGuru = "";
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
            this.idJadwal = item.id;
            this.idKelas = item.id_kelas;
            this.jamKe = item.jam_ke;
            this.idHari = item.hari;
            this.idGuru = item.id_guru;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Jadwal
        updateJadwal: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/jadwalpelajaran/update/${this.idJadwal}`, {
                    id_kelas: this.idKelas,
                    jam_ke: this.jamKe,
                    hari: this.idHari,
                    id_guru: this.idGuru,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.submitJadwal();
                        this.idKelas = "";
                        this.jamKe = "";
                        this.idGuru = "";
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
            this.idJadwal = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Jadwal
        deleteJadwal: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/jadwalpelajaran/delete/${this.idJadwal}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.submitJadwal();
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
    }
</script>
<?php $this->endSection("js") ?>
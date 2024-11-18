<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1 class="font-weight-medium"><?= $title; ?></h1>
            <v-spacer></v-spacer>
            <v-switch v-model="jadwalSholat" value="jadwalSholat" false-value="excel" true-value="api" label="Gunakan Jadwal Sholat Online (API MyQuran.com)" color="success" @click="setJadwalSholat" hide-details></v-switch>
        </v-card-title>
        <v-toolbar flat>
            <!-- Button Tambah -->
            <v-btn color="success" dark large @click="modalAddOpen" class="mr-3" elevation="1">
                <v-icon>mdi-file-excel</v-icon> Import
            </v-btn>
            <v-btn color="error" large text outlined @click="confirmDelete(selected)" :disabled="selected == ''" elevation="1">
                <v-icon>mdi-delete</v-icon> <?= lang('App.delete') ?> (ALL)
            </v-btn>
            <v-spacer></v-spacer>
            <p class="mb-0 mr-3">Month:</p>
            <v-select v-model="idBulan" label="Bulan" :items="dataBulan" item-text="text" item-value="value" single-line hide-details class="mr-3" style="width: 50px;" @change="getJadwalsholat" multiple></v-select>

            <p class="ml-3 mb-0">Date:&nbsp;</p>
            <template>
                <v-menu v-model="menu" :close-on-content-click="false" offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-filter-menu</v-icon>
                        </v-btn>
                    </template>
                    <v-card width="250">
                        <v-card-text>
                            <p class="mb-1">Dari Tanggal - Sampai Tanggal</p>
                            <v-text-field v-model="startDate" type="date"></v-text-field>
                            <v-text-field v-model="endDate" type="date"></v-text-field>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="menu = false">
                                <?= lang('App.close'); ?>
                            </v-btn>
                            <v-btn color="primary" text @click="handleSubmit" :loading="loading">
                                Filter
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu>
                {{startDate}}<br/>{{endDate}}
            </template>

            <!-- <v-text-field v-model="pencarian" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details>
            </v-text-field> -->
        </v-toolbar>
        <v-data-table v-model="selected" item-key="id" show-select :headers="dataHeader" :items="dataJadwalsholat" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item, isSelected, select}">
                <tr :class="isSelected ? 'grey lighten-2':''" @click="toggle(isSelected,select,$event)">
                    <td>
                        <v-icon color="primary" v-if="isSelected">mdi-checkbox-marked</v-icon>
                        <v-icon v-else>mdi-checkbox-blank-outline</v-icon>
                    </td>
                    <td>{{item.id}}</td>
                    <td>{{item.date}}</td>
                    <td>{{item.imsak}}</td>
                    <td>{{item.subuh}}</td>
                    <td>{{item.terbit}}</td>
                    <td>{{item.dhuha}}</td>
                    <td>{{item.dzuhur}}</td>
                    <td>{{item.ashar}}</td>
                    <td>{{item.maghrib}}</td>
                    <td>{{item.isya}}</td>
                </tr>
            </template>
        </v-data-table>
    </v-card>
</template>

<!-- Modal -->
<!-- Modal Save -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" max-width="700px" persistent scrollable>
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
                        <p class="mb-0 text-subtitle-1">Bulan</p>
                        <v-select v-model="idBulan" label="Pilih Bulan" :items="dataBulan" item-text="text" item-value="value" class="mb-3" single-line hide-details multiple outlined></v-select>

                        <p class="mb-0 text-subtitle-1">File</p>
                        <v-file-input v-model="file" show-size label="File Upload" id="file" class="mb-2" accept=".xls, .xlsx" prepend-icon="mdi-file-excel" @change="onFileChange" :loading="loading2" filled :disabled="idBulan == ''"></v-file-input>

                        <v-alert type="info" text>
                            Download Excel:
                            <a href="<?= base_url('files/excel/Jadwal_sholat.xlsx'); ?>">Format Jadwal Sholat</a> dan
                            <a href="<?= base_url('files/excel/Contoh_jadwal_sholat.xlsx'); ?>">Contoh Jadwal Sholat</a>
                        </v-alert>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" text @click="modalAdd = false" :loading="loading" elevation="0">
                        <?= lang('App.close') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Save -->

<template>
    <v-dialog v-model="modalShow" persistent width="500">
        <v-card>
            <v-card-title class="text-h5 grey lighten-2 mb-5">
                Pilih Bulan
            </v-card-title>

            <v-card-text>
                <v-select v-model="idBulan" label="Pilih Bulan" :items="dataBulan" item-text="text" item-value="value" class="mb-1" single-line hide-details @change="getJadwalsholat" multiple outlined></v-select>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="modalShow = false" :disabled="idBulan == ''">
                    <?= lang('App.save'); ?>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<template>
    <v-row justify="center">
        <v-dialog v-model="modalDeleteMultiple" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> Confirm Delete
                </v-card-title>
                <v-card-text>
                    <div class="mt-5 py-5">
                        <h2 class="font-weight-regular"><?= lang('App.delConfirm'); ?></h2>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="modalDeleteMultiple = false" elevation="1" large><?= lang('App.close'); ?></v-btn>
                    <v-btn color="red" dark @click="deleteMultiple" :loading="loading" elevation="1" large><?= lang('App.delete'); ?> (All)</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {
            type: contentType
        });
        return blob;
    }

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
        modalDeleteMultiple: false,
        modalTgl: false,
        modalJam: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Tanggal",
            value: "date"
        }, {
            text: "Imsak",
            value: "imsak"
        }, {
            text: "Subuh",
            value: "subuh"
        }, {
            text: "Terbit",
            value: "terbit"
        }, {
            text: "Dhuha",
            value: "dhuha"
        }, {
            text: "Dzuhur",
            value: "dzuhur"
        }, {
            text: "Ashar",
            value: "ashar"
        }, {
            text: "Maghrib",
            value: "maghrib"
        }, {
            text: "Isya",
            value: "isya"
        }],
        dataJadwalsholat: [],
        dataBulan: [{
            text: "Januari",
            value: "1"
        }, {
            text: "Februari",
            value: "2"
        }, {
            text: "Maret",
            value: "3"
        }, {
            text: "April",
            value: "4"
        }, {
            text: "Mei",
            value: "5"
        }, {
            text: "Juni",
            value: "6"
        }, {
            text: "Juli",
            value: "7"
        }, {
            text: "Agustus",
            value: "8"
        }, {
            text: "September",
            value: "9"
        }, {
            text: "Oktober",
            value: "10"
        }, {
            text: "November",
            value: "11"
        }, {
            text: "Desember",
            value: "12"
        }],
        idJadwalsholat: "",
        idBulan: "",
        tanggal: "",
        imsak: "",
        subuh: "",
        terbit: "",
        duha: "",
        dzuhur: "",
        ashar: "",
        magrib: "",
        isya: "",
        file: null,
        filePreview: null,
        idSetting: "15",
        jadwalSholat: "<?= $modejadwalSholat; ?>",
        menu: false,
        startDate: "",
        endDate: "",
        selected: [],
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getJadwalsholat();
    }

    watchVue = {
        ...watchVue,
        idBulan: function() {
            if (this.idBulan.length > 1) {
                this.idBulan = "";
                this.idBulan.pop();
                this.snackbar = true;
                this.snackbarMessage = "Anda hanya dapat memilih 1";
                this.startDate = "";
                this.endDate = "";
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

        // Handle Submit Filter
        handleSubmit: function() {
            this.idBulan = "";
            this.getJadwalsholat();
        },

        toggle(isSelected, select, e) {
            select(!isSelected)
        },

        // Get Data
        getJadwalsholat: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>api/jadwalsholat?idbulan=${this.idBulan}&tgl_start=${this.startDate}&tgl_end=${this.endDate}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataJadwalsholat = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataJadwalsholat = data.data;
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

        //Upload
        onFileChange() {
            const reader = new FileReader()
            reader.readAsDataURL(this.file)
            reader.onload = e => {
                this.filePreview = e.target.result;
                this.uploadFile(this.filePreview);
            }
        },
        onFileClear() {
            this.file = null;
            this.filePreview = null;
            this.snackbar = true;
            this.snackbarMessage = 'File dihapus';
        },
        uploadFile: function(file) {
            var formData = new FormData() // Split the base64 string in data and contentType
            var block = file.split(";"); // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif" get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            formData.append('fileexcel', blob);
            formData.append('idbulan', this.idBulan);
            this.loading2 = true;
            axios.post(`<?= base_url() ?>api/jadwalsholat/import`, formData)
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.file = null;
                        this.filePreview = null;
                        this.getJadwalsholat();
                        this.modalAdd = false;
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

        //Change Mode Jadwal Sholat
        setJadwalSholat: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/setting/change/${this.idSetting}`, {
                    value_setting: this.jadwalSholat,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
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

        // Confirm Delete
        confirmDelete: function(selected) {
            this.modalDeleteMultiple = true;
            this.deleted = JSON.stringify(selected);;
            //console.log(this.deleted);
        },

        // Delete Multi
        deleteMultiple: function() {
            var data = this.deleted;
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/jadwalsholat/delete/multiple`, {
                    data
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getJadwalsholat();
                        this.modalDeleteMultiple = false;
                        this.selected = [];
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
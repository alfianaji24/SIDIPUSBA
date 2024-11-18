<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h2><?= $title; ?></h2>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
        </v-card-title>
        <v-data-table :headers="dataTable" :items="dataSettingWithIndex" :items-per-page="-1" :loading="loading" :search="search" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.index}}</td>
                    <td>{{item.variable_setting}}</td>
                    <td>
                        <div v-if="item.variable_setting == 'kota'">
                            <div v-for="items in dataKota" :key="items.id" v-if="items.id == item.value_setting">
                                {{items.lokasi}}
                            </div>
                        </div>
                        <div v-else-if="item.variable_setting == 'provinsi'">
                            <div v-for="items in dataProvinsi" :key="items.id" v-if="items.id == item.value_setting">
                                {{items.provinsi}}
                            </div>
                        </div>
                        <div v-else>
                            {{item.value_setting}}
                        </div>
                    </td>
                    <td><i>{{item.deskripsi_setting}}</i></td>
                    <td>{{item.updated_at}}</td>
                    <td>
                        <div v-if="item.variable_setting == 'background' || item.variable_setting == 'background_masjid'">
                            <v-btn color="primary" @click="editItem(item)" icon>
                                <v-icon>mdi-camera</v-icon>
                            </v-btn>
                        </div>
                        <div v-else-if="item.variable_setting == 'kota' || item.variable_setting == 'provinsi'">
                            <v-btn color="primary" @click="modalProvinsiKotaOpen" icon>
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </div>
                        <div v-else-if="item.variable_setting == 'developer' || item.variable_setting == 'nama_aplikasi'">
                        </div>
                        <div v-else>
                            <v-btn color="primary" @click="editItem(item)" icon>
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </div>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-card>

</template>

<!-- Modal Edit -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalEdit" persistent scrollable width="600px">
            <v-card>
                <v-card-title>Edit '{{variableEdit}}'
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalEditClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-3">
                    <v-form ref="form" v-model="valid">
                        <v-alert v-if="notifType != ''" dismissible dense outlined :type="notifType">{{notifMessage}}</v-alert>
                        <p class="mb-2 text-subtitle-1">Deskripsi Setting</p>
                        <v-textarea v-model="deskripsiEdit" rows="3" :error-messages="deskripsi_settingError" outlined disabled></v-textarea>
                        <p class="mb-2 text-subtitle-1">Value Setting</p>

                        <div v-if="variableEdit == 'ver'">
                            <v-select v-model="valueEdit" :items="dataVersi" label="Pilih Versi" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'layout'">
                            <v-select v-model="valueEdit" :items="dataLayout" label="Pilih Layout" item-text="nama_layout" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'background' || variableEdit == 'background_masjid' ">
                            <img v-bind:src="'<?= base_url() ?>' + valueEdit" width="400" class="mb-2" />
                            <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading3" :error-messages="imageError"></v-file-input>
                            <v-alert color="yellow lighten-2" icon="mdi-information" light class="text-body-2" dense>Ukuran Maksimal <strong><?= $uploadSize; ?></strong>. (Berdasarkan php.ini: <?= $maxsizeInfo; ?>)</v-alert>
                            <div v-show="imagePreview">
                                <v-img :src="imagePreview" max-width="200">
                                    <v-overlay v-model="overlay" absolute :opacity="0.1">
                                        <v-btn small class="ma-2" color="success" dark>
                                            OK
                                            <v-icon dark right>
                                                mdi-checkbox-marked-circle
                                            </v-icon>
                                        </v-btn>
                                    </v-overlay>
                                </v-img>
                            </div>
                        </div>

                        <div v-else-if="variableEdit == 'video_muted' || variableEdit == 'video_youtube' || variableEdit == 'use_pusher' || variableEdit == 'meta_refresh_enable'">
                            <v-select v-model="valueEdit" :items="dataYesNo" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'video_plugin'">
                            <v-select v-model="valueEdit" :items="dataPlugin" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'fontsize_nama' || variableEdit == 'fontsize_alamat'">
                            <v-select v-model="valueEdit" :items="dataFontSize" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'fontweight_nama'">
                            <v-select v-model="valueEdit" :items="dataFontWeight" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else-if="variableEdit == 'bgcolor_jam' || variableEdit == 'bgcolor_newsticker'">
                            <v-text-field type="color" v-model="valueEdit" :error-messages="value_settingError" outlined>
                            </v-text-field>
                        </div>

                        <div v-else-if="variableEdit == 'jadwal_sholat'">
                            <v-select v-model="valueEdit" :items="dataSholat" label="Pilih Jadwal Sholat" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                            <v-alert type="info" text>
                                <strong>Informasi!</strong> API jadwal sholat yang digunakan adalah milik pihak ketiga yaitu website https://api.myquran.com (MyQuran.com). Klik <a href="https://api.myquran.com/v2/sholat/kota/semua" class="" target="_blank" alt="api.myquran.com">Disini</a> untuk melihat status API sedang bisa diakses atau tidak (Error 500 dsb), jika Error 500 maka tampilan Display Jadwal Sholat akan Error.
                            </v-alert>
                        </div>

                        <div v-else-if="variableEdit == 'developer'">
                            <v-text-field v-model="valueEdit" :error-messages="value_settingError" outlined disabled></v-text-field>
                        </div>

                        <div v-else-if="variableEdit == 'framework_display'">
                            <v-select v-model="valueEdit" :items="dataFramework" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                            </v-select>
                        </div>

                        <div v-else>
                            <v-textarea v-model="valueEdit" :error-messages="value_settingError" rows="3" outlined></v-textarea>
                        </div>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions v-if="variableEdit == 'background' || variableEdit == 'background_masjid'">
                    Progress:
                    <v-spacer></v-spacer>
                    <v-container>
                        <v-progress-linear color="success" buffer-value="100" height="10" :value="uploadPercentage" striped></v-progress-linear>
                    </v-container>
                    <v-spacer></v-spacer>
                    <v-btn large @click="modalEditClose" elevation="0">
                        Tutup
                    </v-btn>
                </v-card-actions>
                <v-card-actions v-else>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateSetting" :loading="loading2" elevation="1">
                        <v-icon>mdi-content-save</v-icon> Simpan
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Edit -->

<template>
    <v-row justify="center">
        <v-dialog v-model="modalProvinsiKota" persistent scrollable width="600px">
            <v-card>
                <v-card-title> Ganti Provinsi - Kota/Kabupaten
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalProvinsiKotaClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                        <v-autocomplete v-model="provinsi" label="Provinsi" :items="dataProvinsi" item-text="provinsi" item-value="id" :eager="true" :loading="loading2" :error-messages="value_settingError" :rules="[rules.required]" outlined></v-autocomplete>
                        <v-autocomplete v-model="kota" label="Kota/Kabupaten" :items="dataKota" item-text="lokasi" item-value="id" :eager="true" :loading="loading3" :error-messages="value_settingError" :rules="[rules.required]" outlined></v-autocomplete>
                    </v-form>

                    <v-btn large color="primary" @click="saveProvinsiKota" :loading="loading4" elevation="1" class="mb-5" :disabled="provinsi == null || kota == null">
                        <v-icon>mdi-content-save</v-icon> Simpan
                    </v-btn>

                    <v-alert type="info" outlined dense>
                        Informasi: Kota/Kabupaten digunakan untuk Cuaca dan Jadwal Sholat (REST API). Khusus Cuaca jika Data Kota belum ada di openweathermap.org maka akan menggunakan Data Provinsi. Jadwal Sholat (REST API) hanya menggunakan Data Kota/Kabupaten.
                    </v-alert>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<v-dialog v-model="loading2" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            <?= lang('App.loadingWait'); ?>
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
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
        modalEdit: false,
        modalProvinsiKota: false,
        settingData: [],
        dataTable: [{
            text: '#',
            value: 'id'
        }, {
            text: 'Variable',
            value: 'variable_setting'
        }, {
            text: 'Value',
            value: 'value_setting'
        }, {
            text: 'Deskripsi',
            value: 'deskripsi_setting'
        }, {
            text: 'Tgl Update',
            value: 'updated_at'
        }, {
            text: 'Aksi',
            value: 'actions',
            sortable: false
        }, ],
        settingId: "",
        groupEdit: "",
        variableEdit: "",
        deskripsiEdit: "",
        valueEdit: "",
        deskripsi_settingError: "",
        value_settingError: "",
        image: null,
        imagePreview: null,
        overlay: false,
        dataVersi: [{
            text: 'ALL IN ONE',
            value: 'AIO'
        }, ],
        dataYesNo: [{
            text: 'Ya',
            value: 'yes'
        }, {
            text: 'Tidak',
            value: 'no'
        }],
        dataLayout: [],
        dataKota: [],
        kota: "<?= $kota; ?>",
        dataProvinsi: [],
        provinsi: "<?= $provinsi; ?>",
        dataSholat: [{
            text: 'REST API MyQuran.com https://api.myquran.com',
            value: 'api'
        }, {
            text: 'Excel (Upload Manual)',
            value: 'excel'
        }],
        dataPlugin: [{
            text: 'Plyr.io',
            value: 'Plyr.io'
        }],
        dataFontSize: [{
            text: 'H1 - Paling Besar',
            value: 'h1'
        }, {
            text: 'H2 - Besar',
            value: 'h2'
        }, {
            text: 'H3 - Sedang',
            value: 'h3'
        }, {
            text: 'H4 - Kecil',
            value: 'h4'
        }, {
            text: 'H5 - Lebih Kecil',
            value: 'h5'
        }, {
            text: 'H6 - Paling Kecil',
            value: 'h6'
        }],
        dataFontWeight: [{
            text: 'FW Light',
            value: 'fw-light'
        }, {
            text: 'FW Normal',
            value: 'fw-normal'
        }, {
            text: 'FW Semibold',
            value: 'fw-semibold'
        }, {
            text: 'FW Bold',
            value: 'fw-bold'
        }],
        dataBgColor: [{
            text: 'Primary (Biru)',
            value: 'text-bg-primary'
        }, {
            text: 'Secondary (Abu-abu)',
            value: 'text-bg-secondary'
        }, {
            text: 'Success (Hijau)',
            value: 'text-bg-success'
        }, {
            text: 'Warning (Kuning)',
            value: 'text-bg-warning'
        }, {
            text: 'Danger (Merah)',
            value: 'text-bg-danger'
        }, {
            text: 'Light (Putih)',
            value: 'text-bg-light'
        }, {
            text: 'Dark (Hitam)',
            value: 'text-bg-dark'
        }],
        imageError: "",
        uploadPercentage: 0,
        dataFramework: [{
            text: 'JQuery',
            value: 'jquery'
        },{
            text: 'Vue.js',
            value: 'vue.js'
        }],
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getSetting();
        this.getKota();
        this.getProvinsi();
    }

    computedVue = {
        ...computedVue,
        dataSettingWithIndex() {
            return this.settingData.map(
                (items, index) => ({
                    ...items,
                    index: index + 1
                }))
        },
    }

    watchVue = {
        ...watchVue,
        provinsi: function() {
            if (!isNaN(this.provinsi)) {
                this.getKotaGet();
                this.kota = null;
            }
        },
    }

    methodsVue = {
        ...methodsVue,
        onFileChange() {
            const reader = new FileReader()
            reader.readAsDataURL(this.image)
            reader.onload = e => {
                this.imagePreview = e.target.result;
                this.uploadFile(this.imagePreview);
            }
        },
        onFileClear() {
            this.image = null;
            this.imagePreview = null;
            this.overlay = false;
            this.imageError = "";
            this.uploadPercentage = 0;
            this.snackbar = true;
            this.snackbarMessage = 'Image dihapus';
        },
        uploadFile: function(file) {
            var formData = new FormData() // Split the base64 string in data and contentType
            var block = file.split(";"); // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif" get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            formData.append('image', blob);
            formData.append('id', this.settingId);
            this.loading3 = true;
            axios.post(`<?= base_url() ?>api/setting/upload`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function(progressEvent) {
                        this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                })
                .then(res => {
                    // handle success
                    this.loading3 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.valueEdit = data.data
                        this.overlay = true;
                        this.imageError = "";
                        this.getSetting();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        this.uploadPercentage = 0;
                        this.modalEdit = true;
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

        // Get Setting
        getSetting: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/setting/app')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.settingData = data.data;
                        //console.log(this.settingData);
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

        // Get Item Edit
        editItem: function(item) {
            this.modalEdit = true;
            this.notifType = "";
            this.settingId = item.id;
            this.groupEdit = item.group_setting;
            this.variableEdit = item.variable_setting;
            this.deskripsiEdit = item.deskripsi_setting;
            this.valueEdit = item.value_setting;
            this.getLayout();
            this.image = null;
            this.imageError = "";
            this.imagePreview = null;
        },

        modalEditClose: function() {
            this.modalEdit = false;
            this.image = null;
            this.imagePreview = null;
            this.overlay = false;
            this.$refs.form.resetValidation();
        },

        //Update
        updateSetting: function() {
            this.loading2 = true;
            axios.put(`<?= base_url() ?>api/setting/update/${this.settingId}`, {
                    deskripsi_setting: this.deskripsiEdit,
                    value_setting: this.valueEdit
                })
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.uploadPercentage = 0;
                        this.imageError = "";
                        this.modalEdit = false;
                        this.getSetting();
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

        //Get Provinsi
        getProvinsi: function() {
            this.loading2 = true;
            axios.get('<?= base_url() ?>api/setting/provinsi')
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataProvinsi = data.data;
                        //console.log(this.settingData);
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

        //Get Kota
        getKota: function() {
            this.loading3 = true;
            axios.get(`<?= base_url() ?>api/setting/kota`)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataKota = data.data;
                        //console.log(this.settingData);
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

        //Get Kota Get
        getKotaGet: function() {
            this.loading3 = true;
            axios.get(`<?= base_url() ?>api/setting/kota/get?provinsi=${this.provinsi}`)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataKota = data.data;
                        //console.log(this.settingData);
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

        //Get Layout
        getLayout: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/setting/layout')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataLayout = data.data;
                        //console.log(this.settingData);
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

        //Dialog Provinsi Kota
        modalProvinsiKotaOpen: function() {
            this.modalProvinsiKota = true;
            this.getProvinsi();
            this.getKotaGet();
        },

        modalProvinsiKotaClose: function() {
            this.modalProvinsiKota = false;
            this.getSetting();
            this.getKota();
            this.getProvinsi();
        },

        //Simpan Provinsi Kota
        saveProvinsiKota: function() {
            this.updateProvinsi();
            setTimeout(() => this.updateKota(), 1000);
        },

        //Update Provinsi
        updateProvinsi: function() {
            this.loading4 = true;
            axios.put(`<?= base_url() ?>api/setting/update/17`, {
                    value_setting: this.provinsi
                })
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
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

        //Update Kota
        updateKota: function() {
            this.loading5 = true;
            axios.put(`<?= base_url() ?>api/setting/update/16`, {
                    value_setting: this.kota
                })
                .then(res => {
                    // handle success
                    this.loading5 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalProvinsiKota = false;
                        this.getSetting();
                        this.getKota();
                        this.getProvinsi();
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
    }
</script>
<?php $this->endSection("js") ?>
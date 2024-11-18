<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <h1 class="text-h4 font-weight-medium"><?= $title; ?></h1>
    <p>Tampilan Display yang informatif dan indah dibuat dengan sepenuh hati.</p>

    <v-tabs>
        <v-tab>
            Semua Layout
        </v-tab>
        <v-tab>
            Konfigurasi
        </v-tab>

        <v-tab-item class="mt-4">
            <v-item-group v-model="selected">
                <v-row v-masonry transition-duration="0.3s" item-selector=".item" class="masonry-container" style="margin-bottom: 160px !important;">
                    <v-col v-masonry-tile class="item" v-for="(item, i) in dataLayout" :key="i" cols="12" sm="6" md="4" @click="update(item)">
                        <v-item v-slot="{ active, toggle }">
                            <v-card min-height="300" @click="toggle">
                                <v-img :src="'<?= base_url(); ?>' + item.preview" class="text-right pa-2">
                                    <v-btn icon x-large dark>
                                        <v-icon>
                                            {{ active ? 'mdi-heart' : 'mdi-heart-outline' }}
                                        </v-icon>
                                    </v-btn>
                                </v-img>
                                <v-card-title>
                                    {{item.nama_layout}}
                                    <v-spacer></v-spacer>
                                    <v-chip color="green" class="white--text" small v-show="active">
                                        {{ active ? 'Aktif' : '' }}
                                    </v-chip>
                                </v-card-title>
                            </v-card>
                        </v-item>
                    </v-col>
                </v-row>
            </v-item-group>
        </v-tab-item>
        <v-tab-item class="mt-4">
            <v-card outlined>
                <v-data-table :headers="dataTable" :items="dataSettingWithIndex" :items-per-page="-1" :loading="loading" :search="search" loading-text="<?= lang('App.loadingWait'); ?>">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{item.index}}</td>
                            <td>{{item.variable_setting}}</td>
                            <td>
                                <div v-if="item.variable_setting == 'kota'">
                                    <v-autocomplete v-model="item.value_setting" :items="dataKota" item-text="lokasi" item-value="id" readonly>
                                    </v-autocomplete>
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
                                <div v-else-if="item.variable_setting == 'app_version' || item.variable_setting == 'app_release' || item.variable_setting == 'app_developer'">
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
        </v-tab-item>
    </v-tabs>
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
                        <v-text-field v-model="deskripsiEdit" :error-messages="deskripsi_settingError" outlined disabled></v-text-field>
                        <p class="mb-2 text-subtitle-1">Value Setting</p>

                        <div v-if="variableEdit == 'layout'">
                            <v-select v-model="valueEdit" :items="dataLayout" label="Pilih Layout" item-text="nama_layout" item-value="value" :error-messages="value_settingError" outlined>
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

                        <div v-else>
                            <v-textarea v-model="valueEdit" :error-messages="value_settingError" rows="3" outlined></v-textarea>
                        </div>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <div v-if="variableEdit == 'background'">
                        <v-btn large @click="modalEditClose" elevation="0">
                            Tutup
                        </v-btn>
                    </div>
                    <div v-else>
                        <v-btn large color="primary" @click="updateSetting" :loading="loading2" elevation="1">
                            <v-icon>mdi-content-save</v-icon> Simpan
                        </v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Edit -->

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
        dataLayout: [],
        selected: <?= $active; ?>,
        idSetting: "8",
        valueLayout: "",
        modalEdit: false,
        search: "Layout",
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
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getLayout();
        this.getSetting();
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

    methodsVue = {
        ...methodsVue,
        // Get Data
        getLayout: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/layout')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataLayout = data.data;
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

        update(item) {
            this.valueLayout = item.value;
            this.updateLayout();
        },

        //Change Layout
        updateLayout: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/setting/change/${this.idSetting}`, {
                    value_setting: this.valueLayout,
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

    }
</script>
<?php $this->endSection("js") ?>
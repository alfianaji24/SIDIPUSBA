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
        <v-data-table :headers="dataHeader" :items="dataCustom" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td>{{item.tipe}}</td>
                    <td>{{item.bgcolor}}</td>
                    <td>{{item.title}}</td>
                    <td>
                        <span v-if="item.konten == 'video' || item.konten == 'galeri' || item.konten == 'agenda' || item.konten == 'jadwalsholat' || item.konten == 'quotesagama' || item.konten == 'infonews' || item.konten == 'infomasjid'">{{item.konten}}</span>
                        <span v-else="">html (raw)</span>
                    </td>
                    <td>
                        <v-switch v-model="item.status" value="status" false-value="0" true-value="1" color="success" @click="setAktif(item)"></v-switch>
                    </td>
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
                            <v-col cols="12" md="6">
                                <p class="mb-2 text-subtitle-1">Tipe <small>Informasi Column ada <a href="https://getbootstrap.com/docs/5.2/layout/grid/#grid-options" target="_blank">disini</a></small></p>
                                <v-select v-model="tipe" label="Tipe Kolom" :items="dataColumn" item-text="text" item-value="value" :error-messages="tipeError" outlined>
                                </v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="mb-2 text-subtitle-1">Bg Color</p>
                                <v-select v-model="bgColor" label="Background Color" :items="dataBgColor" item-text="text" item-value="value" :error-messages="bgcolorError" outlined>
                                </v-select>
                            </v-col>
                        </v-row>

                        <p class="mb-2 text-subtitle-1">Judul</p>
                        <v-text-field v-model="title" label="Judul" :error-messages="titleError" outlined></v-text-field>

                        <p class="mb-2 text-subtitle-1">Konten</p>
                        <v-select v-model="source" :items="dataSource" item-text="text" item-value="value" placeholder="Pilih Source Konten" :rules="[rules.required]" outlined></v-select>
                        <div v-if="source == 'html'">
                            <v-textarea v-model="konten" label="Isi Konten (Raw HTML)" rows="10" :error-messages="kontenError" outlined></v-textarea>
                        </div>

                        <p class="mb-2 text-subtitle-1">Status</p>
                        <v-checkbox v-model="status" label="Aktif" class="mt-0" :error-messages="statusError"></v-checkbox>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveCustom" :loading="loading" elevation="1">
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
                            <v-col cols="12" md="6">
                                <p class="mb-2 text-subtitle-1">Tipe</p>
                                <v-select v-model="tipe" label="Tipe Kolom" :items="dataColumn" item-text="text" item-value="value" :error-messages="tipeError" outlined>
                                </v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="mb-2 text-subtitle-1">Bg Color</p>
                                <v-select v-model="bgColor" label="Background Color" :items="dataBgColor" item-text="text" item-value="value" :error-messages="bgcolorError" outlined>
                                </v-select>
                            </v-col>
                        </v-row>

                        <p class="mb-2 text-subtitle-1">Judul</p>
                        <v-text-field v-model="title" label="Judul" :error-messages="titleError" outlined></v-text-field>

                        <p class="mb-3 text-subtitle-1">Konten</p>
                        <v-select v-model="source" :items="dataSource" item-text="text" item-value="value" placeholder="Pilih Source Konten" :rules="[rules.required]" outlined></v-select>
                        <div v-if="source == 'html'">
                            <v-textarea v-model="konten" label="Isi Konten (Raw HTML)" rows="10" :error-messages="kontenError" outlined></v-textarea>
                        </div>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateCustom" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.update') ?>
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
                    <v-btn large color="primary" dark @click="deleteCustom" :loading="loading"><?= lang('App.yes') ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->
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
        modalShow: false,
        modalDelete: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Tipe",
            value: "tipe"
        }, {
            text: "Bg Color",
            value: "bgcolor"
        }, {
            text: "Judul",
            value: "title"
        }, {
            text: "Konten",
            value: "konten"
        }, {
            text: "Aktif",
            value: "status"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataCustom: [],
        source: "",
        dataSource: [{
            text: "HTML (Raw)",
            value: "html"
        }, {
            text: "Video (Display)",
            value: "video"
        }, {
            text: "Galeri (Display)",
            value: "galeri"
        }, {
            text: "Agenda (Display)",
            value: "agenda"
        }, {
            text: "Info Umum (Display)",
            value: "infonews"
        }, {
            text: "Info Masjid (Display)",
            value: "infomasjid"
        }, {
            text: "Jadwal Sholat (Masjid)",
            value: "jadwalsholat"
        }, {
            text: "Quotes Agama (Masjid)",
            value: "quotesagama"
        }],
        idCustom: "",
        tipe: "",
        tipeError: "",
        bgColor: "",
        bgcolorError: "",
        title: "",
        titleError: "",
        konten: "",
        kontenError: "",
        status: false,
        statusError: "",
        dataColumn: [{
            text: 'Col 3 (Bisa untuk 4 kolom)',
            value: 'col-sm-3'
        }, {
            text: 'Col 4 (Bisa untuk 3 kolom)',
            value: 'col-sm-4'
        }, {
            text: 'Col 6 (Half / Bisa untuk 2 kolom)',
            value: 'col-sm-6'
        }, {
            text: 'Col 12 (Full / Hanya 1 kolom)',
            value: 'col-sm-12'
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
        this.getCustom();
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
        getCustom: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/custom')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataCustom = data.data;
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

        // Save Custom
        saveCustom: function() {
            this.loading = true;
            if (this.source == 'video') {
                var konten = 'video';
            } else if (this.source == 'galeri') {
                var konten = 'galeri';
            } else if (this.source == 'agenda') {
                var konten = 'agenda';
            } else if (this.source == 'jadwalsholat') {
                var konten = 'jadwalsholat';
            } else if (this.source == 'quotesagama') {
                var konten = 'quotesagama';
            } else if (this.source == 'infonews') {
                var konten = 'infonews';
            } else if (this.source == 'infomasjid') {
                var konten = 'infomasjid';
            } else {
                var konten = this.konten;
            }
            axios.post(`<?= base_url(); ?>api/custom/save`, {
                    tipe: this.tipe,
                    bgcolor: this.bgColor,
                    title: this.title,
                    konten: konten,
                    status: this.status,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getCustom();
                        this.tipe = "";
                        this.bgColor = "";
                        this.title = "";
                        this.konten = "";
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
            this.idCustom = item.id;
            this.tipe = item.tipe;
            this.bgColor = item.bgcolor;
            this.title = item.title;
            this.konten = item.konten;
            if (item.konten == 'video') {
                this.source = 'video';
            } else if (item.konten == 'galeri') {
                this.source = 'galeri';
            } else if (item.konten == 'agenda') {
                this.source = 'agenda';
            } else if (item.konten == 'jadwalsholat') {
                this.source = 'jadwalsholat';
            } else if (item.konten == 'quotesagama') {
                this.source = 'quotesagama';
            } else if (item.konten == 'infonews') {
                this.source = 'infonews';
            } else if (item.konten == 'infomasjid') {
                this.source = 'infomasjid';
            } else {
                this.source = 'html';
            }
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Custom
        updateCustom: function() {
            this.loading = true;
            if (this.source == 'video') {
                var konten = 'video';
            } else if (this.source == 'galeri') {
                var konten = 'galeri';
            } else if (this.source == 'agenda') {
                var konten = 'agenda';
            } else if (this.source == 'jadwalsholat') {
                var konten = 'jadwalsholat';
            } else if (this.source == 'quotesagama') {
                var konten = 'quotesagama';
            } else if (this.source == 'infonews') {
                var konten = 'infonews';
            } else if (this.source == 'infomasjid') {
                var konten = 'infomasjid';
            } else {
                var konten = this.konten;
            }
            axios.put(`<?= base_url(); ?>api/custom/update/${this.idCustom}`, {
                    tipe: this.tipe,
                    bgcolor: this.bgColor,
                    title: this.title,
                    konten: konten,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getCustom();
                        this.tipe = "";
                        this.bgColor = "";
                        this.konten = "";
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
            this.idCustom = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Custom
        deleteCustom: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/custom/delete/${this.idCustom}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getCustom();
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

        // Set Item Aktif
        setAktif: function(item) {
            this.loading = true;
            this.idCustom = item.id;
            this.status = item.status;
            axios.put(`<?= base_url(); ?>api/custom/setaktif/${this.idCustom}`, {
                    status: this.status,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getCustom();
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
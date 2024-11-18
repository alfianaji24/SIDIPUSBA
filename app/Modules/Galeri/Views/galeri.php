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
        <v-data-table :headers="dataHeader" :items="dataGaleri" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td width="150">{{item.label}}</td>
                    <td>{{item.deskripsi}}</td>
                    <td>
                        <v-avatar rounded size="100">
                            <img :src="'<?= base_url() ?>' + item.image_url" v-if="item.image_url != null">
                        </v-avatar>
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
                        <p class="mb-3 text-subtitle-1">Label</p>
                        <v-text-field v-model="label" label="Label/Caption Gambar" :error-messages="labelError" outlined></v-text-field>

                        <p class="mb-3 text-subtitle-1">Deskripsi</p>
                        <v-text-field v-model="deskripsi" label="Deskripsi Gambar" :error-messages="deskripsiError" outlined></v-text-field>

                        <p class="mb-0 text-subtitle-1">Gambar</p>
                        <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading2" :error-messages="imageError"></v-file-input>
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

                        <p class="mb-3 text-subtitle-1">Status</p>
                        <v-checkbox v-model="status" label="Aktif" class="mt-0" :error-messages="statusError"></v-checkbox>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    Progress:
                    <v-spacer></v-spacer>
                    <v-container>
                        <v-progress-linear color="success" buffer-value="100" height="10" :value="uploadPercentage" striped></v-progress-linear>
                    </v-container>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveGaleri" :loading="loading" elevation="1" :disabled="imageUrl == ''">
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
        <v-dialog v-model="modalEdit" max-width="700px" persistent scrollable>
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
                        <p class="mb-3 text-subtitle-1">Label</p>
                        <v-text-field v-model="label" label="Label/Caption Gambar" :error-messages="labelError" outlined></v-text-field>

                        <p class="mb-3 text-subtitle-1">Deskripsi</p>
                        <v-text-field v-model="deskripsi" label="Deskripsi Gambar" :error-messages="deskripsiError" outlined></v-text-field>

                        <p class="mb-0 text-subtitle-1">Gambar</p>
                        <img v-bind:src="'<?= base_url() ?>' + imageUrlEdit" width="200" class="mb-0" />

                        <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading2" hint="Kosongkan jika tidak ingin mengganti gambar" persistent-hint :error-messages="imageError"></v-file-input>
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
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    Progress:
                    <v-spacer></v-spacer>
                    <v-container>
                        <v-progress-linear color="success" buffer-value="100" height="10" :value="uploadPercentage" striped></v-progress-linear>
                    </v-container>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateGaleri" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteGaleri" :loading="loading"><?= lang('App.yes') ?></v-btn>
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
            text: "Label",
            value: "label"
        }, {
            text: "Deskripsi",
            value: "deskripsi"
        }, {
            text: "Gambar",
            value: "image_url"
        }, {
            text: "Aktif",
            value: "status"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataGaleri: [],
        idGaleri: "",
        label: "",
        labelError: "",
        deskripsi: "",
        deskripsiError: "",
        imageUrl: "",
        imageError: "",
        imageUrlEdit: null,
        image: null,
        imagePreview: null,
        overlay: false,
        status: false,
        statusError: "",
        uploadPercentage: 0
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getGaleri();
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
            this.status = true;
            this.imageUrl = "";
            //this.$refs.form.resetValidation();
            //this.$refs.form.reset();
        },
        modalAddClose: function() {
            this.modalAdd = false;
            //this.$refs.form.resetValidation();
        },

        // Get Data
        getGaleri: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/galeri')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataGaleri = data.data;
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

        //Upload
        onFileChange() {
            const reader = new FileReader()
            reader.readAsDataURL(this.image)
            reader.onload = e => {
                this.imagePreview = e.target.result;
                this.uploadFile(this.imagePreview);
            }
        },
        onFileClear() {
            this.imageUrl = "";
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
            this.loading2 = true;
            axios.post(`<?= base_url() ?>api/galeri/upload`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function(progressEvent) {
                        this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                })
                .then(res => {
                    // handle success
                    this.loading2 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.uploadData = data.data;
                        this.imageUrl = this.uploadData.url;
                        this.overlay = true;
                        this.imageError = "";
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        this.uploadPercentage = 0;
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


        // Save Galeri
        saveGaleri: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/galeri/save`, {
                    label: this.label,
                    deskripsi: this.deskripsi,
                    image_url: this.imageUrl,
                    status: this.status,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getGaleri();
                        this.label = "";
                        this.deskripsi = "";
                        this.imageUrl = "";
                        this.imagePreview = null;
                        this.overlay = false;
                        this.uploadPercentage = 0;
                        this.imageError = "";
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
            this.idGaleri = item.id;
            this.label = item.label;
            this.deskripsi = item.deskripsi;
            this.imageUrlEdit = item.image_url;
            this.image = null;
            this.imageError = "";
            this.imagePreview = null;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Galeri
        updateGaleri: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/galeri/update/${this.idGaleri}`, {
                    label: this.label,
                    deskripsi: this.deskripsi,
                    image_url: this.imageUrl,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getGaleri();
                        this.label = "";
                        this.deskripsi = "";
                        this.imageUrl = null;
                        this.imagePreview = null;
                        this.overlay = false;
                        this.uploadPercentage = 0;
                        this.imageError = "";
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
            this.idGaleri = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Galeri
        deleteGaleri: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/galeri/delete/${this.idGaleri}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getGaleri();
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
            this.idGaleri = item.id;
            this.status = item.status;
            axios.put(`<?= base_url(); ?>api/galeri/setaktif/${this.idGaleri}`, {
                    status: this.status,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getGaleri();
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
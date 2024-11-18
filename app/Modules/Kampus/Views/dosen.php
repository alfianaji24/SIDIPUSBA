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
        <v-data-table :headers="dataHeader" :items="dataDosen" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td>
                        <v-list-item class="ma-n3 pa-n3" two-line>
                            <v-list-item-avatar size="50" rounded>
                                <v-img :src="'<?= base_url() ?>' + item.foto"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <p class="text-subtitle-1 text-underlined primary--text">{{item.nama_lengkap}}</p>
                                <p class="mb-0">{{item.nip_nik}}</p>
                            </v-list-item-content>
                        </v-list-item>
                    </td>
                    <td>{{item.jabatan}}</td>
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
            <v-card :loading="loading2">
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
                        <p class="mb-2 text-subtitle-1">Nama Dosen & Gelar</p>
                        <v-text-field v-model="namaDosen" :error-messages="nama_lengkapError" outlined></v-text-field>

                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">NIP/NIK</p>
                                <v-text-field v-model="nip" :error-messages="nip_nikError" outlined></v-text-field>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Jabatan</p>
                                <v-text-field v-model="jabatan" :error-messages="jabatanError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tempat Lahir</p>
                                <v-text-field v-model="tempatLahir" :error-messages="tempat_lahirError" outlined></v-text-field>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tanggal Lahir</p>
                                <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tanggalLahir" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggal_lahirError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tanggalLahir" @input="menu = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>

                        <p class="mb-0 text-subtitle-1">Foto</p>
                        <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading2" :error-messages="fotoError"></v-file-input>
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
                    <v-btn large color="primary" @click="saveDosen" :loading="loading" elevation="1">
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
                        <p class="mb-2 text-subtitle-1">Nama Dosen & Gelar</p>
                        <v-text-field v-model="namaDosen" :error-messages="nama_lengkapError" outlined></v-text-field>

                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">NIP/NIK</p>
                                <v-text-field v-model="nip" :error-messages="nip_nikError" outlined></v-text-field>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Jabatan</p>
                                <v-text-field v-model="jabatan" :error-messages="jabatanError" outlined></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tempat Lahir</p>
                                <v-text-field v-model="tempatLahir" :error-messages="tempat_lahirError" outlined></v-text-field>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Tanggal Lahir</p>
                                <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tanggalLahir" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggal_lahirError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tanggalLahir" @input="menu2 = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>

                        <p class="mb-0 text-subtitle-1">Foto</p>
                        <v-img :src="'<?= base_url() ?>' + foto" width="100" class="mb-0"></v-img>

                        <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading2" :error-messages="fotoError" hint="Kosongkan jika tidak ingin mengganti foto" persistent-hint></v-file-input>
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
                    <v-btn large color="primary" @click="updateDosen" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteDosen" :loading="loading"><?= lang('App.yes') ?></v-btn>
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

    // Deklarasi errorKeys
    var errorKeys = []

    const token = JSON.parse(localStorage.getItem('access_token'));
    const options = {
        headers: {
            //"Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    dataVue = {
        ...dataVue,
        pencarian: "",
        modalAdd: false,
        modalEdit: false,
        modalShow: false,
        modalDelete: false,
        menu: false,
        menu2: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Dosen",
            value: "nama_lengkap"
        }, {
            text: "Jabatan",
            value: "jabatan"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataDosen: [],
        idDosen: "",
        nip: "",
        nip_nikError: "",
        namaDosen: "",
        nama_lengkapError: "",
        tempatLahir: "",
        tempat_lahirError: "",
        tanggalLahir: "",
        tanggal_lahirError: "",
        jabatan: "",
        jabatanError: "",
        imageUrl: "",
        foto: null,
        fotoError: "",
        image: null,
        imagePreview: null,
        overlay: false,
        uploadPercentage: 0
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getDosen();
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
        getDosen: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/dosen')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataDosen = data.data;
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
            formData.append('foto', blob);
            this.loading2 = true;
            axios.post(`<?= base_url() ?>api/dosen/upload`, formData, {
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
                        this.fotoError = "";
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

        // Save Dosen
        saveDosen: function() {
            this.loading = true;
            if (this.imageUrl == '' || this.imageUrl == null) {
                var image = 'images/photo.png';
            } else {
                var image = this.imageUrl;
            }
            axios.post(`<?= base_url(); ?>api/dosen/save`, {
                    nip_nik: this.nip,
                    nama_lengkap: this.namaDosen,
                    tempat_lahir: this.tempatLahir,
                    tanggal_lahir: this.tanggalLahir,
                    foto: image,
                    jabatan: this.jabatan,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getDosen();
                        this.nip = "";
                        this.namaDosen = "";
                        this.tempatLahir = "";
                        this.tanggalLahir = "";
                        this.jabatan = "";
                        this.imageUrl = null;
                        this.imagePreview = null;
                        this.overlay = false;
                        this.uploadPercentage = 0;
                        this.fotoError = "";
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
            this.idDosen = item.id;
            this.nip = item.nip_nik;
            this.namaDosen = item.nama_lengkap;
            this.tempatLahir = item.tempat_lahir;
            this.tanggalLahir = item.tanggal_lahir;
            this.jabatan = item.jabatan;
            this.foto = item.foto;
            this.fotoError = "";
            this.image = null;
            this.imagePreview = null;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Dosen
        updateDosen: function() {
            this.loading = true;
            if (this.image == null) {
                var image = this.foto;
            } else {
                var image = this.imageUrl;
            }
            axios.put(`<?= base_url(); ?>api/dosen/update/${this.idDosen}`, {
                    nip_nik: this.nip,
                    nama_lengkap: this.namaDosen,
                    tempat_lahir: this.tempatLahir,
                    tanggal_lahir: this.tanggalLahir,
                    foto: image,
                    jabatan: this.jabatan,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getDosen();
                        this.nip = "";
                        this.namaDosen = "";
                        this.tempatLahir = "";
                        this.tanggalLahir = "";
                        this.jabatan = "";
                        this.imageUrl = null;
                        this.imagePreview = null;
                        this.overlay = false;
                        this.uploadPercentage = 0;
                        this.fotoError = "";
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
            this.idDosen = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Dosen
        deleteDosen: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/dosen/delete/${this.idDosen}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getDosen();
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
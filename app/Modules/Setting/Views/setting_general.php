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
        <v-data-table :headers="dataTable" :items="dataSettingWithIndex" :items-per-page="5" :loading="loading" :search="search" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{item.index}}</td>
                    <td>{{item.variable_setting}}</td>
                    <td>{{item.value_setting}}</td>
                    <td><i>{{item.deskripsi_setting}}</i></td>
                    <td>{{item.updated_at}}</td>
                    <td>
                        <div v-if="item.variable_setting == 'logo'">
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

</template>

<!-- Modal Edit -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalEdit" persistent scrollable width="600px">
            <v-card>
                <v-card-title>Edit {{deskripsiEdit}}
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
                        <div v-if="variableEdit == 'logo'">
                            <img v-bind:src="'<?= base_url() ?>' + valueEdit" width="150" class="mb-2" />
                            <v-file-input v-model="image" show-size label="Browse File" id="file" class="mb-2" accept=".jpg, .jpeg, .png" prepend-icon="mdi-camera" @change="onFileChange" @click:clear="onFileClear" :loading="loading3" :error-messages="imageError"></v-file-input>
                            <v-alert color="yellow lighten-2" icon="mdi-information" light class="text-body-2" dense>Ukuran Maksimal <strong><?= $uploadSize; ?></strong>. (Berdasarkan php.ini: <?= $maxsizeInfo; ?>)</v-alert>
                            <div v-show="imagePreview">
                                <v-img :src="imagePreview" max-width="150">
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
                        <div v-else-if="groupEdit == 'icon'">
                            <v-select v-model="valueEdit" :items="dataIcon" item-text="text" item-value="value" :error-messages="value_settingError" outlined>
                                <template v-slot:item="props">
                                    <img v-bind:src="'<?= base_url() ?>' + 'assets/images/' + props.item.value" width="30" class="me-2" />
                                    {{props.item.text}}
                                </template>
                            </v-select>
                        </div>
                        <div v-else>
                            <v-textarea v-model="valueEdit" :error-messages="value_settingError" rows="3" outlined></v-textarea>
                        </div>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions v-if="variableEdit == 'logo'">
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
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    // Deklarasi errorKeys
    var errorKeys = []

    dataVue = {
        ...dataVue,
        modalEdit: false,
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
        dataIcon: [{
            text: 'School 1',
            value: 'school1.png'
        }, {
            text: 'School 2',
            value: 'school2.png'
        }, {
            text: 'School 3',
            value: 'school3.png'
        }, {
            text: 'School 4',
            value: 'school4.png'
        }, {
            text: 'School 5',
            value: 'school5.png'
        }],
        imageError: "",
        uploadPercentage: 0
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
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
        // Get
        getSetting: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/setting/general')
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
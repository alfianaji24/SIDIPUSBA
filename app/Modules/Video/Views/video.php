<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1 class="font-weight-medium"><?= $title; ?></h1>
            <v-spacer></v-spacer>
            <v-switch v-model="videoYoutube" value="videoYoutube" false-value="no" true-value="yes" label="Aktifkan Youtube" color="error" @click="setYoutube" hide-details></v-switch>
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
        <v-data-table :headers="dataHeader" :items="dataVideo" :items-per-page="5" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td width="150">{{item.judul}}<br />{{item.upload_time}}</td>
                    <td>
                        <div v-if="item.source == 1">
                            <video width="220" controls>
                                <source :src="'<?= base_url() ?>' + item.video_url" type="video/mp4">
                                Browser Anda tidak mendukung video HTML5.
                            </video>
                        </div>
                        <div v-else>
                            <iframe width="220" :src="'https://www.youtube.com/embed/' + item.kode_youtube" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
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
                        <p class="mb-3 text-subtitle-1">Judul</p>
                        <v-text-field v-model="judul" label="Judul Video" :error-messages="judulError" outlined></v-text-field>

                        <p class="mb-3 text-subtitle-1">Source Video</p>
                        <v-select v-model="source" :items="dataSource" item-text="text" item-value="value" placeholder="Pilih Source Video" :error-messages="sourceError" outlined></v-select>

                        <div class="mb-3" v-if="source == 1">
                            <p class="mb-3 text-subtitle-1">Upload Video</p>
                            <v-alert color="yellow lighten-2" icon="mdi-information" light class="text-body-2">Ukuran Maksimal <strong><?= $uploadSize; ?></strong>. (Berdasarkan php.ini: <?= $maxsizeInfo; ?>)</v-alert>
                            <v-icon large>mdi-movie-play</v-icon>&nbsp;
                            <vue-plupload @added="handleAdded" @progress="handleProgress" @error="handleError" @uploaded="handleUploaded" :options="uploadOpt" className="" text="Click to Browse file..." style="padding: 10px;" v-if="videoUrl == ''"></vue-plupload>
                            <span v-else>
                                <a :href="'<?= base_url(); ?>' + videoUrl" target="_blank"><?= base_url(); ?>{{videoUrl}}</a>
                                &nbsp;
                                <v-btn icon @click="deleteUploaded" title="Delete Video"><v-icon color="error">mdi-delete</v-icon></v-btn>
                            </span>
                        </div>
                        <div class="mb-3" v-else-if="source == 2">
                            <v-text-field v-model="kodeYoutube" label="Kode Video Youtube" :error-messages="kode_youtubeError" outlined hint="Contoh: https://www.youtube.com/watch?v=IvjxrQ8c4-w. Copy kode IvjxrQ8c4-w sebagai kode Youtube." persistent-hint></v-text-field>
                            <v-alert color="yellow lighten-2" icon="mdi-information" light class="text-body-2 mt-2" @click="">
                                Infomasi! menggunakan video youtube membutuhkan resource memory yang lebih banyak dan kemungkinan membuat Komputer anda menjadi lambat.
                            </v-alert>
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
                    <v-btn large color="primary" @click="saveVideo" :loading="loading" elevation="1" :disabled="videoUrl == '' && kodeYoutube == ''">
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
                        <p class="mb-3 text-subtitle-1">Judul</p>
                        <v-text-field v-model="judul" label="Judul Video" :error-messages="judulError" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateVideo" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteVideo" :loading="loading"><?= lang('App.yes') ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->
<!-- Loading2-->
<v-dialog v-model="loading2" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            <?= lang('App.loadingWait'); ?>
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
<!-- End Loading2 -->
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
            text: "Judul",
            value: "judul"
        }, {
            text: "Video",
            value: "video_url"
        }, {
            text: "Status",
            value: "status"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataVideo: [],
        dataSource: [{
            text: "MP4",
            value: "1"
        }, {
            text: "Youtube",
            value: "2"
        }],
        idVideo: "",
        judul: "",
        judulError: "",
        source: "1",
        sourceError: "",
        videoUrl: "",
        videoError: "",
        videoUrlEdit: null,
        kodeYoutube: "",
        kode_youtubeError: "",
        status: true,
        statusError: "",
        video: null,
        videoPreview: null,
        overlay: false,
        idSetting: "19",
        videoYoutube: "<?= $videoYoutube; ?>",
        uploadPercentage: 0,
        uploadOpt: {
            url: "<?= base_url() ?>api/video/plupload",
            filters: {
                max_file_size: '<?= env('PLUPLOAD_MAXFILESIZE'); ?>',
                mime_types: [{
                    title: "Video files",
                    extensions: "mp4"
                }]
            },
        },
        log: "",
        logDialog: false,
    }

    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getVideo();
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function() {
            this.modalAdd = true;
            this.source = "1";
            this.kodeYoutube = "";
            this.status = true;
            //this.$refs.form.resetValidation();
            //this.$refs.form.reset();
        },
        modalAddClose: function() {
            this.modalAdd = false;
            //this.$refs.form.resetValidation();
        },

        // Get Data
        getVideo: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/video')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataVideo = data.data;
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
        /* onFileChange() {
            const reader = new FileReader()
            reader.readAsDataURL(this.video)
            reader.onload = e => {
                this.videoPreview = e.target.result;
                this.uploadFile(this.videoPreview);
            }
        },
        onFileClear() {
            this.videoUrl = "";
            this.video = null;
            this.videoPreview = null;
            this.videoError = "";
            this.uploadPercentage = 0;
            this.snackbar = true;
            this.snackbarMessage = 'Video dihapus';
        },
        uploadFile: function(file) {
            var formData = new FormData() // Split the base64 string in data and contentType
            var block = file.split(";"); // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif" get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."

            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            formData.append('video', blob);
            this.loading2 = true;
            axios.post(`<?= base_url() ?>api/video/upload`, formData, {
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
                        this.videoUrl = this.uploadData.url;
                        this.videoError = "";
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
        }, */

        // New Plupload handle Video Upload
        handleAdded: function(uploader, files) {
            files.forEach(function(file) {
                this.log += "begin upload file:" + file.name + "\n";
            });
            uploader.start();
            this.logDialog = true;
        },

        handleProgress: function(uploader, file) {
            this.log += "file:" + file.name + " uploading, progress:" + file.percent + "\n";
            this.uploadPercentage = file.percent;
            this.loading2 = true;
        },

        handleError: function(uploader, err) {
            this.log += "upload error:\n======\n" + JSON.stringify(err) + "\n======\n";
            this.loading2 = false;
        },

        handleUploaded: function(uploader, file, result) {
            this.log += "file:" + file.name + " upload complete!";
            this.loading2 = false;
            var data = JSON.parse(result.response);
            if (data.status == true) {
                this.snackbar = true;
                this.snackbarMessage = data.message;
                this.uploadData = data.data;
                this.videoUrl = this.uploadData.url;
                this.videoError = "";
            } else {
                this.snackbar = true;
                this.snackbarMessage = data.message;
                errorKeys = Object.keys(data.data);
                errorKeys.map((el) => {
                    this[`${el}Error`] = data.data[el];
                });
                this.uploadPercentage = 0;
            }
        },

        deleteUploaded: function() {
            this.loading2 = true;
            axios.delete(`<?= base_url(); ?>api/video/plupload/delete/delete_uploaded?video_url=${this.videoUrl}`)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.videoUrl = "";
                        this.videoError = "";
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
        // End Plupload

        // Save Video
        saveVideo: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/video/save`, {
                    judul: this.judul,
                    source: this.source,
                    video_url: this.videoUrl,
                    kode_youtube: this.kodeYoutube,
                    status: this.status,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getVideo();
                        this.judul = "";
                        this.kodeYoutube = "";
                        this.source = "";
                        this.videoUrl = "";
                        this.video = null;
                        this.videoPreview = null;
                        this.uploadPercentage = 0;
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
            this.idVideo = item.id;
            this.judul = item.judul;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Video
        updateVideo: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/video/update/${this.idVideo}`, {
                    judul: this.judul,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getVideo();
                        this.judul = "";
                        this.uploadPercentage = 0;
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
            this.idVideo = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Video
        deleteVideo: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/video/delete/${this.idVideo}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getVideo();
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
            this.idVideo = item.id;
            this.status = item.status;
            axios.put(`<?= base_url(); ?>api/video/setaktif/${this.idVideo}`, {
                    status: this.status,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getVideo();
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

        //Change Youtube
        setYoutube: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/setting/change/${this.idSetting}`, {
                    value_setting: this.videoYoutube,
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
    }
</script>
<?php $this->endSection("js") ?>
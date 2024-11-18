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
        <v-data-table :headers="dataHeader" :items="dataJam" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="150">{{item.jam_ke}}</td>
                    <td>{{item.mulai}}</td>
                    <td>{{item.selesai}}</td>
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
                        <p class="mb-2 text-subtitle-1">Jam Ke</p>
                        <v-text-field v-model="jamKe" :error-messages="jam_keError" outlined></v-text-field>

                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Mulai</p>
                                <v-menu ref="mulai1" v-model="mulai1" :close-on-content-click="false" :return-value.sync="mulai" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="mulai" label="Pilih Waktu Mulai" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="mulaiError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="mulai1" v-model="mulai" full-width @click:minute="$refs.mulai1.save(mulai)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Selesai</p>
                                <v-menu ref="selesai1" v-model="selesai1" :close-on-content-click="false" :return-value.sync="selesai" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="selesai" label="Pilih Waktu Selesai" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="selesaiError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="selesai1" v-model="selesai" full-width @click:minute="$refs.selesai1.save(selesai)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveJam" :loading="loading" elevation="1">
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
                        <p class="mb-2 text-subtitle-1">Jam Ke</p>
                        <v-text-field v-model="jamKe" :error-messages="jam_keError" outlined></v-text-field>

                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Mulai</p>
                                <v-menu ref="mulai2" v-model="mulai2" :close-on-content-click="false" :return-value.sync="mulai" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="mulai" label="Pilih Waktu Mulai" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="mulaiError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="mulai2" v-model="mulai" full-width @click:minute="$refs.mulai2.save(mulai)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Selesai</p>
                                <v-menu ref="selesai2" v-model="selesai2" :close-on-content-click="false" :return-value.sync="selesai" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="selesai" label="Pilih Waktu Selesai" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="selesaiError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="selesai2" v-model="selesai" full-width @click:minute="$refs.selesai2.save(selesai)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateJam" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteJam" :loading="loading"><?= lang('App.yes') ?></v-btn>
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
        mulai1: false,
        mulai2: false,
        selesai1: false,
        selesai2: false,
        dataHeader: [{
            text: "Jam Ke",
            value: "jam_ke"
        }, {
            text: "Mulai",
            value: "mulai"
        }, {
            text: "Selesai",
            value: "selesai"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataJam: [],
        idJam: "",
        jamKe: "",
        jam_keError: "",
        mulai: "",
        mulaiError: "",
        selesai: "",
        selesaiError: "",
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getJam();
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
        getJam: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/jampelayanan')
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

        // Save Jam
        saveJam: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/jampelayanan/save`, {
                    jam_ke: this.jamKe,
                    mulai: this.mulai,
                    selesai: this.selesai,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getJam();
                        this.jamKe = "";
                        this.mulai = "";
                        this.selesai = "";
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
            this.idJam = item.id;
            this.jamKe = item.jam_ke;
            this.mulai = item.mulai;
            this.selesai = item.selesai;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Jam
        updateJam: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/jampelayanan/update/${this.idJam}`, {
                    jam_ke: this.jamKe,
                    mulai: this.mulai,
                    selesai: this.selesai,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getJam();
                        this.jamKe = "";
                        this.mulai = "";
                        this.selesai = "";
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
            this.idJam = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Jam
        deleteJam: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/jampelayanan/delete/${this.idJam}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getJam();
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
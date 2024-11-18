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
        <v-data-table :headers="dataHeader" :items="dataAgenda" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td width="150">{{item.nama_agenda}}</td>
                    <td>{{item.tempat_agenda}}</td>
                    <td>{{item.tgl_agenda}}</td>
                    <td>{{item.waktu}}</td>
                    <td>
                        <v-chip>{{item.jenis_agenda == '1' ? 'Agenda':'-'}}</v-chip>
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
                        <p class="mb-3 text-subtitle-1">Nama Agenda</p>
                        <v-text-field v-model="namaAgenda" label="Nama Agenda" :error-messages="nama_agendaError" outlined></v-text-field>
                        <p class="mb-3 text-subtitle-1">Tempat</p>
                        <v-text-field v-model="tempatAgenda" label="Tempat Agenda" :error-messages="tempat_agendaError" outlined></v-text-field>
                        <v-row>
                            <v-col>
                                <p class="mb-3 text-subtitle-1">Tanggal</p>
                                <v-menu ref="date" v-model="date" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tglAgenda" label="Pilih Tanggal" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tgl_agendaError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tglAgenda" @input="date = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col>
                                <p class="mb-3 text-subtitle-1">Jam</p>
                                <v-menu ref="time" v-model="time" :close-on-content-click="false" :return-value.sync="waktu" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="waktu" label="Pilih Waktu" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="waktuError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="time" v-model="waktu" full-width @click:minute="$refs.time.save(waktu)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveAgenda" :loading="loading" elevation="1">
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
                        <p class="mb-3 text-subtitle-1">Nama Agenda</p>
                        <v-text-field v-model="namaAgenda" label="Nama Agenda" :error-messages="nama_agendaError" outlined></v-text-field>
                        <p class="mb-3 text-subtitle-1">Tempat</p>
                        <v-text-field v-model="tempatAgenda" label="Tempat Agenda" :error-messages="tempat_agendaError" outlined></v-text-field>
                        <v-row>
                            <v-col>
                                <p class="mb-3 text-subtitle-1">Tanggal</p>
                                <v-menu ref="date2" v-model="date2" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="tglAgenda" label="Pilih Tanggal" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tgl_agendaError" outlined></v-text-field>
                                    </template>
                                    <v-date-picker v-model="tglAgenda" @input="date2 = false" color="primary"></v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col>
                                <p class="mb-3 text-subtitle-1">Jam</p>
                                <v-menu ref="time2" v-model="time2" :close-on-content-click="false" :return-value.sync="waktu" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="waktu" label="Pilih Waktu" prepend-inner-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" :error-messages="waktuError" outlined></v-text-field>
                                    </template>
                                    <v-time-picker v-if="time2" v-model="waktu" full-width @click:minute="$refs.time2.save(waktu)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateAgenda" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteAgenda" :loading="loading"><?= lang('App.yes') ?></v-btn>
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
        date: false,
        date2: false,
        time: false,
        time2: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Nama",
            value: "nama_agenda"
        }, {
            text: "Tempat",
            value: "tempat_agenda"
        }, {
            text: "Tanggal",
            value: "tgl_agenda"
        }, {
            text: "Waktu",
            value: "waktu"
        }, {
            text: "Jenis",
            value: "jenis_agenda"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataAgenda: [],
        dataJenis: [{
            text: "News",
            value: "1"
        }, {
            text: "Info",
            value: "2"
        }],
        idAgenda: "",
        namaAgenda: "",
        nama_agendaError: "",
        tempatAgenda: "",
        tempat_agendaError: "",
        tglAgenda: "",
        tgl_agendaError: "",
        waktu: null,
        waktuError: "",
        jenisAgenda: "",
        jenis_agendaError: "",
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getAgenda();
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
        getAgenda: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/agenda')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataAgenda = data.data;
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

        // Save Agenda
        saveAgenda: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/agenda/save`, {
                    nama_agenda: this.namaAgenda,
                    tempat_agenda: this.tempatAgenda,
                    tgl_agenda: this.tglAgenda,
                    waktu: this.waktu,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getAgenda();
                        this.namaAgenda = "";
                        this.tempatAgenda = "";
                        this.tglAgenda = "";
                        this.waktu = "";
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
            this.idAgenda = item.id;
            this.namaAgenda = item.nama_agenda;
            this.tempatAgenda = item.tempat_agenda;
            this.tglAgenda = item.tgl_agenda;
            this.waktu = item.waktu;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update Agenda
        updateAgenda: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/agenda/update/${this.idAgenda}`, {
                    nama_agenda: this.namaAgenda,
                    tempat_agenda: this.tempatAgenda,
                    tgl_agenda: this.tglAgenda,
                    waktu: this.waktu,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getAgenda();
                        this.namaAgenda = "";
                        this.tempatAgenda = "";
                        this.tglAgenda = "";
                        this.waktu = "";
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
            this.idAgenda = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete Agenda
        deleteAgenda: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/agenda/delete/${this.idAgenda}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getAgenda();
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
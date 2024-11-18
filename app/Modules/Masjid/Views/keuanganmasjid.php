<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1 class="font-weight-medium"><?= $title; ?></h1>
            <v-spacer></v-spacer>
            <h3>Saldo: {{Ribuan(saldo ?? "0")}}</h3>
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
        <v-data-table :headers="dataHeader" :items="dataKeuangan" :items-per-page="10" :loading="loading" :search="pencarian" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>">
            <template v-slot:item="{ item }">
                <tr>
                    <td width="80">{{item.id}}</td>
                    <td>{{item.tanggal}}</td>
                    <td width="300">{{item.uraian}}</td>
                    <td>{{Ribuan(item.pemasukan)}}</td>
                    <td>{{Ribuan(item.pengeluaran)}}</td>
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
                        <p class="mb-3 text-subtitle-1">Tanggal</p>
                        <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="tanggal" label="Pilih Tanggal" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggalError" outlined></v-text-field>
                            </template>
                            <v-date-picker v-model="tanggal" @input="menu = false" color="primary"></v-date-picker>
                        </v-menu>

                        <p class="mb-3 text-subtitle-1">Jenis</p>
                        <v-select v-model="jenis" :items="dataJenis" item-text="text" item-value="value" placeholder="Pilih Jenis Keuangan" :error-messages="jenisError" outlined></v-select>

                        <p class="mb-3 text-subtitle-1">Uraian</p>
                        <v-textarea v-model="uraian" :rules="[rules.varchar]" rows="3" auto-grow counter :error-messages="uraianError" outlined></v-textarea>

                        <p class="mb-3 text-subtitle-1">Nominal</p>
                        <v-text-field type="number" v-model="nominal" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveKeuangan" :loading="loading" elevation="1">
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
                        <p class="mb-3 text-subtitle-1">Tanggal</p>
                        <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="tanggal" label="Pilih Tanggal" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :error-messages="tanggalError" outlined></v-text-field>
                            </template>
                            <v-date-picker v-model="tanggal" @input="menu2 = false" color="primary"></v-date-picker>
                        </v-menu>

                        <p class="mb-3 text-subtitle-1">Jenis</p>
                        <v-select v-model="jenis" :items="dataJenis" item-text="text" item-value="value" placeholder="Pilih Jenis Keuangan" :error-messages="jenisError" outlined></v-select>

                        <p class="mb-3 text-subtitle-1">Uraian</p>
                        <v-textarea v-model="uraian" :rules="[rules.varchar]" rows="3" auto-grow counter :error-messages="uraianError" outlined></v-textarea>

                        <p class="mb-3 text-subtitle-1">Nominal</p>
                        <v-text-field type="number" v-model="nominal" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateKeuangan" :loading="loading">
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
                    <v-btn large color="primary" dark @click="deleteKeuangan" :loading="loading"><?= lang('App.yes') ?></v-btn>
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
        menu: false,
        menu2: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
            text: "Tanggal",
            value: "tanggal"
        }, {
            text: "Uraian",
            value: "uraian"
        }, {
            text: "Pemasukan",
            value: "pemasukan"
        }, {
            text: "Pengeluaran",
            value: "pengeluaran"
        }, {
            text: "<?= lang('App.action') ?>",
            value: "actions",
            sortable: false
        }, ],
        dataKeuangan: [],
        dataJenis: [{
            text: "Pemasukan",
            value: "1"
        }, {
            text: "Pengeluaran",
            value: "2"
        }],
        idKeuangan: "",
        tanggal: "",
        tanggalError: "",
        uraian: "",
        uraianError: "",
        jenis: "",
        jenisError: "",
        nominal: "",
        saldo: "",
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getKeuangan();
    }

    methodsVue = {
        ...methodsVue,
        Ribuan(key) {
            var number_string = key.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        },

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
        getKeuangan: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/keuanganmasjid')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataKeuangan = data.data;
                        this.getSaldo();
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

        getSaldo: function() {
            this.loading = true;
            axios.get('<?= base_url(); ?>api/keuanganmasjid/saldo')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.saldo = data.data;
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

        // Save
        saveKeuangan: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/keuanganmasjid/save`, {
                    tanggal: this.tanggal,
                    uraian: this.uraian,
                    jenis: this.jenis,
                    nominal: this.nominal,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeuangan();
                        this.tanggal = "";
                        this.uraian = "";
                        this.jenis = "";
                        this.nominal = "";
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
            this.idKeuangan = item.id;
            this.tanggal = item.tanggal;
            this.uraian = item.uraian;
            this.jenis = item.jenis;
            if (this.jenis == '1') {
                this.nominal = item.pemasukan
            } else {
                this.nominal = item.pengeluaran
            }
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        //Update
        updateKeuangan: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/keuanganmasjid/update/${this.idKeuangan}`, {
                    tanggal: this.tanggal,
                    uraian: this.uraian,
                    jenis: this.jenis,
                    nominal: this.nominal,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeuangan();
                        this.tanggal = "";
                        this.uraian = "";
                        this.jenis = "";
                        this.nominal = "";
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
            this.idKeuangan = item.id;
        },

        modalDeleteClose: function() {
            this.modalDelete = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Delete
        deleteKeuangan: function() {
            this.loading = true;
            axios.delete(`<?= base_url(); ?>api/keuanganmasjid/delete/${this.idKeuangan}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getKeuangan();
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
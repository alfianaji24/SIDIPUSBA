<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title>
            <h1 class="font-weight-medium mb-3"><?= $title; ?></h1>
        </v-card-title>
        <v-card-text>
            <v-simple-table>
                <template v-slot:default>
                    <thead class="bg-black">
                        <tr>
                            <th colspan="2" class="text-center">Jam Ke</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                            <th>Sabtu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataJam as $jam) { ?>
                            <tr>
                                <td class="text-center"><?= $jam['jam_ke']; ?></td>
                                <td class="text-center font-weight-medium"><?= $jam['mulai']; ?>-<?= $jam['selesai']; ?></td>

                                <?php
                                helper('disfo');
                                $db = \Config\Database::connect();
                                $builder = $db->table('harilayanans');
                                $builder = $builder->where(['id_jampelayanan' => $jam['id']]);
                                $query = $builder->get();

                                $id_hari = "";
                                $senin = "";
                                $selasa = "";
                                $rabu = "";
                                $kamis = "";
                                $jumat = "";
                                $sabtu = "";
                                foreach ($query->getResult() as $row) {
                                    $id_hari = $row->id;
                                    $senin = layanan($row->senin)['id'];
                                    $selasa = layanan($row->selasa)['id'];
                                    $rabu = layanan($row->rabu)['id'];
                                    $kamis = layanan($row->kamis)['id'];
                                    $jumat = layanan($row->jumat)['id'];
                                    $sabtu = layanan($row->sabtu)['id'];
                                }
                                ?>
                                <td class="<?= ($senin == "Libur" ? "error" : ""); ?><?= ($senin == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($senin) ? $senin : ""); ?> </td>
                                <td class="<?= ($selasa == "Libur" ? "error" : ""); ?><?= ($selasa == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($selasa) ? $selasa : ""); ?></td>
                                <td class="<?= ($rabu == "Libur" ? "error" : ""); ?><?= ($rabu == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($rabu) ? $rabu : ""); ?></td>
                                <td class="<?= ($kamis == "Libur" ? "error" : ""); ?><?= ($kamis == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($kamis) ? $kamis : ""); ?></td>
                                <td class="<?= ($jumat == "Libur" ? "error" : ""); ?><?= ($jumat == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($jumat) ? $jumat : ""); ?></td>
                                <td class="<?= ($sabtu == "Libur" ? "error" : ""); ?><?= ($sabtu == "Istirahat" ? "yellow" : ""); ?>"><?= (isset($sabtu) ? $sabtu : ""); ?></td>
                                <td>
                                    <?php if (empty($id_hari)) { ?>
                                        <v-btn small color="success" class="mr-2" @click="modalAddOpen(<?= $jam['id']; ?>)">
                                            <v-icon small>mdi-plus</v-icon> <?= lang('App.add'); ?>
                                        </v-btn>
                                    <?php } else { ?>
                                        <v-btn small color="primary" class="mr-2" @click="editItem(<?= $jam['id']; ?>, <?= $id_hari; ?>)">
                                            <v-icon small>mdi-pencil</v-icon> Setup
                                        </v-btn>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<!-- Modal -->
<!-- Modal Save -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" max-width="800px" persistent scrollable>
            <v-card>
                <v-card-title>
                    <?= $title; ?> Jam Ke: {{dataJam.jam_ke}}, Waktu: {{dataJam.mulai}}-{{dataJam.selesai}}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalAddClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Senin</p>
                                <v-select v-model="senin" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="seninError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Selasa</p>
                                <v-select v-model="selasa" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="selasaError" outlined></v-select>
                            </v-col>
                        </v-row>
                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Rabu</p>
                                <v-select v-model="rabu" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="rabuError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Kamis</p>
                                <v-select v-model="kamis" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="kamisError" outlined></v-select>
                            </v-col>
                        </v-row>
                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Jumat</p>
                                <v-select v-model="jumat" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="jumatError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Sabtu</p>
                                <v-select v-model="sabtu" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="sabtuError" outlined></v-select>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveHari" :loading="loading" elevation="1">
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
        <v-dialog v-model="modalEdit" max-width="800px" persistent scrollable>
            <v-card>
                <v-card-title>
                    <?= $title; ?> Jam Ke: {{dataJam.jam_ke}}, Waktu: {{dataJam.mulai}}-{{dataJam.selesai}}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalEditClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="pt-5">
                    <v-form ref="form" v-model="valid">
                        <v-row>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Senin</p>
                                <v-select v-model="senin" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="seninError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Selasa</p>
                                <v-select v-model="selasa" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="selasaError" outlined></v-select>
                            </v-col>
                        </v-row>
                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Rabu</p>
                                <v-select v-model="rabu" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="rabuError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Kamis</p>
                                <v-select v-model="kamis" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="kamisError" outlined></v-select>
                            </v-col>
                        </v-row>
                        <v-row class="mt-0">
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Jumat</p>
                                <v-select v-model="jumat" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="jumatError" outlined></v-select>
                            </v-col>
                            <v-col>
                                <p class="mb-2 text-subtitle-1">Sabtu</p>
                                <v-select v-model="sabtu" :items="dataJadwal" item-text="text" item-value="value" label="Pilih" :error-messages="sabtuError" outlined></v-select>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateHari" :loading="loading">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
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
        pencarian: "",
        modalAdd: false,
        modalEdit: false,
        modalShow: false,
        modalDelete: false,
        dataHeader: [{
            text: "#",
            value: "id"
        }, {
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
        dataJadwal: [{
            text: 'Not Set',
            value: '0'
        }, {
            text: 'Libur/Off',
            value: '1'
        }, {
            text: 'Buka',
            value: '2'
        }, {
            text: 'Istirahat',
            value: '3'
        }, ],
        dataJam: [],
        idJam: "",
        idHari: "",
        senin: "",
        seninError: "",
        selasa: "",
        selasaError: "",
        rabu: "",
        rabuError: "",
        kamis: "",
        kamisError: "",
        jumat: "",
        jumatError: "",
        sabtu: "",
        sabtuError: "",
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
    }

    methodsVue = {
        ...methodsVue,
        modalAddOpen: function(id_jam) {
            this.modalAdd = true;
            this.idJam = id_jam;
            this.getJam();
        },

        modalAddClose: function() {
            this.modalAdd = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Get Item Edit
        editItem: function(id_jam, id_hari) {
            this.modalEdit = true;
            this.idJam = id_jam;
            this.idHari = id_hari;
            this.getJam();
            this.getHari();
        },

        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
            this.$refs.form.reset();
        },

        // Get Data
        getJam: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>api/jampelayanan/${this.idJam}`)
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

        // Get Data
        getHari: function() {
            this.loading = true;
            axios.get(`<?= base_url(); ?>api/harilayanan/${this.idHari}`)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataHari = data.data;
                        this.senin = this.dataHari.senin;
                        this.selasa = this.dataHari.selasa;
                        this.rabu = this.dataHari.rabu;
                        this.kamis = this.dataHari.kamis;
                        this.jumat = this.dataHari.jumat;
                        this.sabtu = this.dataHari.sabtu;
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

        // Save Hari
        saveHari: function() {
            this.loading = true;
            axios.post(`<?= base_url(); ?>api/harilayanan/save`, {
                    id_jampelayanan: this.idJam,
                    senin: this.senin,
                    selasa: this.selasa,
                    rabu: this.rabu,
                    kamis: this.kamis,
                    jumat: this.jumat,
                    sabtu: this.sabtu,
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalAdd = false;
                        this.$refs.form.resetValidation();
                        this.$refs.form.reset();
                        setTimeout(() => location.reload(), 1000);
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


        //Update Hari
        updateHari: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/harilayanan/update/${this.idHari}`, {
                    id_jampelayanan: this.idJam,
                    senin: this.senin,
                    selasa: this.selasa,
                    rabu: this.rabu,
                    kamis: this.kamis,
                    jumat: this.jumat,
                    sabtu: this.sabtu,
                })
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalEdit = false;
                        this.$refs.form.resetValidation();
                        this.$refs.form.reset();
                        setTimeout(() => location.reload(), 1000);
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
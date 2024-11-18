<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <v-card>
        <v-card-title class="text-h5">
            <i class="mdi mdi-weather-cloudy"></i> &nbsp;<?= $title; ?>
        </v-card-title>
        <v-card-text>
            <h2>{{ dataCuaca.name }}, {{ dataCuaca_sys.country }}</h2>
            <div v-for="item in dataCuaca.weather" :key="item.id">
                <h2><img :src="'http://openweathermap.org/img/wn/' + item.icon + '.png'"> {{ item.main }}, {{ item.description }}</h2>
            </div>
            <br />
            <h1 class="text-h2"><strong>{{ Math.ceil(dataCuaca_main.temp_max) }}</strong>&deg;<span>C</span></h1>

            <p>Feels like {{ Math.ceil(dataCuaca_main.feels_like) }}&deg;<span>C</span>. Humidity {{ dataCuaca_main.humidity }}%</p>

            <p class="text-muted">Data API openweathermap.org</p>
        </v-card-text>
    </v-card>

    <br/>

    <v-card>
        <v-card-title class="text-h5">
            Ganti Provinsi - Kota/Kabupaten
        </v-card-title>
        <v-card-text>
            <v-form ref="form" v-model="valid">
                <v-autocomplete v-model="provinsi" label="Provinsi" :items="list_provinsi" item-text="provinsi" item-value="id" :eager="true" :loading="loading2" :error-messages="value_settingError" :rules="[rules.required]" outlined></v-autocomplete>
                <v-autocomplete v-model="kota" label="Kota/Kabupaten" :items="list_kota" item-text="lokasi" item-value="id" :eager="true" :loading="loading3" :error-messages="value_settingError" :rules="[rules.required]" outlined></v-autocomplete>
            </v-form>

            <v-btn large color="primary" @click="saveProvinsiKota" :loading="loading4" elevation="1" class="mb-5" :disabled="provinsi == null || kota == null">
                <v-icon>mdi-content-save</v-icon> Simpan
            </v-btn>

            <v-alert type="info" outlined dense>
                Informasi: Kota/Kabupaten digunakan untuk Cuaca dan Jadwal Sholat (REST API). Khusus Cuaca jika Data Kota belum ada di openweathermap.org maka akan menggunakan Data Provinsi. Jadwal Sholat (REST API) hanya menggunakan Data Kota/Kabupaten.
            </v-alert>
        </v-card-text>
    </v-card>
</template>

<!-- Loading -->
<v-dialog v-model="loading" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            Memuat, silahkan tunggu...
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
<!-- End Loading -->

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
        dataCuaca: [],
        dataCuaca_weather: [],
        dataCuaca_main: [],
        dataCuaca_sys: [],
        list_provinsi: [],
        list_kota: [],
        provinsi: "<?= $provinsi; ?>",
        kota: "<?= $kota; ?>",
        value_settingError: "",
    }
    
    createdVue = function() {
        axios.defaults.headers['Authorization'] = 'Bearer ' + token;
        this.getCuaca();
        this.getProvinsi();
        this.getKota();
    }

    watchVue = {
        ...watchVue,
        provinsi: function() {
            if (!isNaN(this.provinsi)) {
                this.getKota();
                this.kota = null;
            }
        },
    }

    methodsVue = {
        ...methodsVue,
        // Get
        getCuaca: function() {
            this.loading = true;
            axios.get('<?= base_url() ?>api/cuaca')
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataCuaca = data.data;
                        this.dataCuaca_weather = this.dataCuaca.weather;
                        this.dataCuaca_main = this.dataCuaca.main;
                        this.dataCuaca_sys = this.dataCuaca.sys;
                        //console.log(this.dataCuaca);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        getProvinsi: function() {
            this.loading2 = true;
            axios.get(`<?= base_url() ?>api/setting/provinsi`, options)
                .then(res => {
                    // handle success
                    var data = res.data;
                    this.list_provinsi = data.data;
                    this.loading2 = false;
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        getKota: function() {
            this.loading3 = true;
            axios.get(`<?= base_url() ?>api/setting/kota/get?provinsi=${this.provinsi}`, options)
                .then(res => {
                    // handle success
                    var data = res.data;
                    this.list_kota = data.data;
                    this.loading3 = false;
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },

        saveProvinsiKota: function() {
            this.updateProvinsi();
            setTimeout(() => this.updateKota(), 1000);
        },

        //Update Provinsi
        updateProvinsi: function() {
            this.loading4 = true;
            axios.put(`<?= base_url() ?>api/setting/update/17`, {
                    value_setting: this.provinsi
                })
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
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

        //Update Kota
        updateKota: function() {
            this.loading5 = true;
            axios.put(`<?= base_url() ?>api/setting/update/16`, {
                    value_setting: this.kota
                })
                .then(res => {
                    // handle success
                    this.loading5 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getCuaca();
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
<?php $this->extend("layouts/frontend"); ?>
<?php $this->section("content"); ?>
<v-container>
    <v-parallax id="home">
        <v-row align="center" justify="center">
            <v-col class="text-center" cols="12">
                <h1 class="text-h1 font-weight-medium mb-4 judul-home">
                    SIDIPUSBA
                </h1>
                <h1 class="deskripsi-home">
                    Sistem Informasi Digital Puskesmas Balaraja
                </h1>
            </v-col>
        </v-row>
    </v-parallax>
</v-container>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    computedVue = {
        ...computedVue,

    }
    createdVue = function() {

    }
    watchVue = {

    }
    dataVue = {
        ...dataVue,

    }
    methodsVue = {
        ...methodsVue,

    }
</script>
<?php $this->endSection("js") ?>
<?php $this->extend("layouts/display"); ?>
<?php $this->section("style"); ?>
<style>
	html,
	body {
		width: 100%;
		margin: 0px;
		overflow: auto;
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		color: white;
		font-size: 100%;
	}

	@media screen and (max-height: 768px) {

		html,
		body {
			font-size: 95%;
		}
	}

	.transparent {
		background-color: rgba(0, 0, 0, 0.1) !important;
	}

	.transparan {
		background-color: rgba(0, 0, 0, 0.8) !important;
	}

	.transparan-abu {
		background-color: rgba(208, 211, 212, 0.8) !important;
		color: black;
	}

	.bg-blue {
		background-color: rgba(25, 118, 210, 0.8) !important;
	}

	.bg-red {
		background-color: rgba(244, 67, 54, 0.8) !important;
	}

	.bg-blue-grey {
		background-color: rgba(96, 125, 139, 0.8) !important;
	}

	.bg-cyan {
		background-color: rgba(0, 188, 212, 0.8) !important;
	}

	.bg-green {
		background-color: rgba(76, 175, 80, 0.8) !important;
	}

	.bg-yellow {
		background-color: rgba(255, 235, 59, 0.8) !important;
	}

	.bg-orange {
		background-color: rgba(255, 152, 0, 0.8) !important;
	}

	.bg-pink {
		background-color: rgba(233, 30, 99, 0.8) !important;
	}

	.bg-purple {
		background-color: rgba(103, 58, 183, 0.8) !important;
	}

	.bg-indigo {
		background-color: rgba(48, 63, 159, 0.8) !important;
	}

	#judul_1 {
		line-height: 30px;
		margin-bottom: 0
	}

	#judul_2 {
		margin-bottom: 0
	}

	/*bottom container*/
	#tanggal-jam {
		position: absolute;
		top: 90vh;
		width: 20%;
		height: 10vh;
		padding: 5px;
		background: <?= $bgcolor_jam; ?>;
		z-index: 3;
		overflow: hidden;
	}

	#tanggal {
		font-weight: bold;
		font-size: <?= $fs_tanggal; ?>px;
		color: #fdfefe;
		line-height: 1;
	}

	#waktu {
		font-weight: bold;
		font-size: <?= $fs_jam; ?>px;
		color: #fdfefe;
		line-height: 0.3;
	}

	/* text scroller */
	#news-container {
		position: absolute;
		top: 90vh;
		left: 20%;
		width: 80%;
		height: 10vh;
		background: <?= $bgcolor_news; ?>;
		z-index: 2;
		overflow: hidden;
		/*transform: translate3d(0, 0, 0);*/
	}

	/* Make it a marquee */
	.marquee {
		color: #f2f2f2;
		width: 100%;
		font-size: <?= $fs_marquee; ?>px;
		font-weight: 600;
		margin: 0 auto;
		overflow: hidden;
		white-space: nowrap;
		box-sizing: border-box;
		animation: marquee <?= $marquee_speed; ?>s linear infinite;
	}

	.marquee:hover {
		animation-play-state: paused
	}

	/* Make it move */
	@keyframes marquee {
		0% {
			text-indent: 27.5em
		}

		100% {
			text-indent: -55em;
			/*transform: translateX(-66.6666%);*/
		}
	}

	#waktu-sholat {
		position: absolute;
		bottom: 10vh;
		width: 100%;
		z-index: 3;
		overflow: hidden;
	}

	.nama-solat {
		font-size: 1.8vw;
		font-weight: bold;
		line-height: 0.8;
	}

	.waktu-solat {
		font-size: 3.5vw;
		font-weight: bold;
		line-height: 1;
	}

	.min-height {
		min-height: 350px;
	}

	.img-height {
		height: 300px;
	}

	@media screen and (max-height: 768px) {
		.img-height {
			height: 250px;
		}
	}

	.navbar-mb {
		margin-bottom: 2.5rem !important;
	}

	@media screen and (max-height: 768px) {
		.navbar-mb {
			margin-bottom: 1rem !important;
		}
	}
</style>
<?php $this->endSection("style") ?>

<?php $this->section("content"); ?>
<?= $this->include($content); ?>

<!-- Toast Message -->
<div class="toast-container position-fixed p-3" style="left: 50%;bottom: 10%;transform: translate(-50%, 0px);z-index: 9999;">
	<div id="liveToast" class="toast text-bg-dark border-0 py-1" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body" id="message">
	
			</div>
			<button type="button" class="btn text-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close">OK</button>
		</div>
	</div>
</div>

<div class="toast-container position-fixed p-3" style="left: 50%;top: 0;transform: translate(-50%, 0px);z-index: 9999;">
	<div id="liveToast2" class="toast text-bg-dark border-0 py-0" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body" id="toastFullscreen">
				Tampilkan Mode Full Screen (Tekan F11)
			</div>
			<button type="button" class="btn text-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fullscreen" @click="">OK</button>
		</div>
	</div>
</div>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
	$(document).ready(function() {
		$('#liveToast2').show();
	})

	setTimeout(() => {
		$('#liveToast2').hide();
	}, 10000); // 10 detik
</script>
<?php $this->endSection("js") ?>
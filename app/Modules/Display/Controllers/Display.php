<?php

namespace  App\Modules\Display\Controllers;

use App\Controllers\BaseController;
use App\Modules\Video\Models\VideoModel;
use App\Modules\Custom\Models\CustomModel;
use App\Libraries\Settings;

class Display extends BaseController
{
	protected $setting;
	protected $video;
	protected $custom;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->video = new VideoModel();
		$this->custom = new CustomModel();
	}

	public function index()
	{
		if ($this->setting->info['framework_display'] == 'jquery') {
			$view = "view";
			$content1 = 'App\Modules\Display\Views\display/layout_1';
			$content2 = 'App\Modules\Display\Views\display/layout_2';
			$content3 = 'App\Modules\Display\Views\display/layout_3';
			$content4 = 'App\Modules\Display\Views\display/layout_4';
			$content5 = 'App\Modules\Display\Views\display/layout_5';
			$content6 = 'App\Modules\Display\Views\display/layout_6';
			$content7 = 'App\Modules\Display\Views\display/layout_7';
			$content8 = 'App\Modules\Display\Views\display/layout_8';
			$content9 = 'App\Modules\Display\Views\display/layout_9';
			$content10 = 'App\Modules\Display\Views\display/layout_10';
			$content11 = 'App\Modules\Display\Views\display/layout_11';
			$content12 = 'App\Modules\Display\Views\display/layout_12';
			$content13 = 'App\Modules\Display\Views\display/layout_13';
			$content14 = 'App\Modules\Display\Views\display/layout_14';
			$content15 = 'App\Modules\Display\Views\display/layout_15';
			$content16 = 'App\Modules\Display\Views\display/layout_16';
			$content17 = 'App\Modules\Display\Views\display/layout_17';
			$content18 = 'App\Modules\Display\Views\display/layout_18';
			$content19 = 'App\Modules\Display\Views\display/layout_19';
			$content20 = 'App\Modules\Display\Views\display/layout_20';
			$content21 = 'App\Modules\Display\Views\display/layout_21';
			$content22 = 'App\Modules\Display\Views\display/layout_22';
			$content23 = 'App\Modules\Display\Views\display/layout_23';
			$content24 = 'App\Modules\Display\Views\display/layout_24';
			$content25 = 'App\Modules\Display\Views\display/layout_25';
			$content26 = 'App\Modules\Display\Views\display/layout_26';
			$content27 = 'App\Modules\Display\Views\display/layout_27';
			$content28 = 'App\Modules\Display\Views\display/layout_28';
			$content29 = 'App\Modules\Display\Views\display/layout_29';
			$content30 = 'App\Modules\Display\Views\display/layout_30';
			$content31 = 'App\Modules\Display\Views\display/layout_31';
			$content32 = 'App\Modules\Display\Views\display/layout_32';
		} else if ($this->setting->info['framework_display'] == 'vue.js') {
			$view = "view_vue";
			$content1 = 'App\Modules\Display\Views\display/layout_1_vue';
			$content2 = 'App\Modules\Display\Views\display/layout_2_vue';
			$content3 = 'App\Modules\Display\Views\display/layout_3_vue';
			$content4 = 'App\Modules\Display\Views\display/layout_4_vue';
			$content5 = 'App\Modules\Display\Views\display/layout_5_vue';
			$content6 = 'App\Modules\Display\Views\display/layout_6_vue';
			$content7 = 'App\Modules\Display\Views\display/layout_7_vue';
			$content8 = 'App\Modules\Display\Views\display/layout_8_vue';
			$content9 = 'App\Modules\Display\Views\display/layout_9_vue';
			$content10 = 'App\Modules\Display\Views\display/layout_10_vue';
			$content11 = 'App\Modules\Display\Views\display/layout_11_vue';
			$content12 = 'App\Modules\Display\Views\display/layout_12_vue';
			$content13 = 'App\Modules\Display\Views\display/layout_13_vue';
			$content14 = 'App\Modules\Display\Views\display/layout_14_vue';
			$content15 = 'App\Modules\Display\Views\display/layout_15_vue';
			$content16 = 'App\Modules\Display\Views\display/layout_16_vue';
			$content17 = 'App\Modules\Display\Views\display/layout_17_vue';
			$content18 = 'App\Modules\Display\Views\display/layout_18_vue';
			$content19 = 'App\Modules\Display\Views\display/layout_19_vue';
			$content20 = 'App\Modules\Display\Views\display/layout_20_vue';
			$content21 = 'App\Modules\Display\Views\display/layout_21_vue';
			$content22 = 'App\Modules\Display\Views\display/layout_22_vue';
			$content23 = 'App\Modules\Display\Views\display/layout_23_vue';
			$content24 = 'App\Modules\Display\Views\display/layout_24_vue';
			$content25 = 'App\Modules\Display\Views\display/layout_25_vue';
			$content26 = 'App\Modules\Display\Views\display/layout_26_vue';
			$content27 = 'App\Modules\Display\Views\display/layout_27_vue';
			$content28 = 'App\Modules\Display\Views\display/layout_28_vue';
			$content29 = 'App\Modules\Display\Views\display/layout_29_vue';
			$content30 = 'App\Modules\Display\Views\display/layout_30_vue';
			$content31 = 'App\Modules\Display\Views\display/layout_31_vue';
			$content32 = 'App\Modules\Display\Views\display/layout_32_vue';
		}

		switch ($this->setting->info['layout']) {
			case 'layout_2':
				$background = $this->setting->info['background'];
				$content = $content2;
				break;
			case 'layout_3':
				$background = $this->setting->info['background'];
				$content = $content3;
				break;
			case 'layout_4':
				$background = $this->setting->info['background'];
				$content = $content4;
				break;
			case 'layout_5':
				$background = $this->setting->info['background'];
				$content = $content5;
				break;
			case 'layout_6':
				$background = $this->setting->info['background'];
				$content = $content6;
				break;
			case 'layout_7':
				$background = $this->setting->info['background'];
				$content = $content7;
				break;
			case 'layout_8':
				$background = $this->setting->info['background'];
				$content = $content8;
				break;
			case 'layout_9':
				$background = $this->setting->info['background'];
				$content = $content9;
				break;
			case 'layout_10':
				$background = $this->setting->info['background'];
				$content = $content10;
				break;
			case 'layout_11':
				$background = $this->setting->info['background_masjid'];
				$content = $content11;
				break;
			case 'layout_12':
				$background = $this->setting->info['background_masjid'];
				$content = $content12;
				break;
			case 'layout_13':
				$background = $this->setting->info['background_masjid'];
				$content = $content13;
				break;
			case 'layout_14':
				$background = $this->setting->info['background'];
				$content = $content14;
				break;
			case 'layout_15':
				$background = $this->setting->info['background'];
				$content = $content15;
				break;
			case 'layout_16':
				$background = $this->setting->info['background'];
				$content = $content16;
				break;
			case 'layout_17':
				$background = $this->setting->info['background'];
				$content = $content17;
				break;
			case 'layout_18':
				$background = $this->setting->info['background'];
				$content = $content18;
				break;
			case 'layout_19':
				$background = $this->setting->info['background'];
				$content = $content19;
				break;
			case 'layout_20':
				$background = $this->setting->info['background'];
				$content = $content20;
				break;
			case 'layout_21':
				$background = $this->setting->info['background'];
				$content = $content21;
				break;
			case 'layout_22':
				$background = $this->setting->info['background'];
				$content = $content22;
				break;
			case 'layout_23':
				$background = $this->setting->info['background'];
				$content = $content23;
				break;
			case 'layout_24':
				$background = $this->setting->info['background'];
				$content = $content24;
				break;
			case 'layout_25':
				$background = $this->setting->info['background'];
				$view = "view_vue";
				$content = $content25;
				break;
			case 'layout_26':
				$background = $this->setting->info['background'];
				$view = "view_vue";
				$content = $content26;
				break;
			case 'layout_27':
				$background = $this->setting->info['background'];
				$view = "view_vue";
				$content = $content27;
				break;
			case 'layout_28':
				$background = $this->setting->info['background'];
				$view = "view_vue";
				$content = $content28;
				break;
			case 'layout_29':
				$background = $this->setting->info['background'];
				$custom = $this->custom->where('status', 1)->findAll();
				$content = $content29;
				break;
			case 'layout_30':
				$background = $this->setting->info['background'];
				$content = $content30;
				break;
			case 'layout_31':
				$background = $this->setting->info['background'];
				$content = $content31;
				break;
			case 'layout_32':
				$background = $this->setting->info['background'];
				$custom = $this->custom->where('status', 1)->findAll();
				$content = $content32;
				break;
			default:
				$background = $this->setting->info['background'];
				$content = $content1;
		}

		//Video MP4 Muted
		$video_muted = $this->setting->info['video_muted'];
		if ($video_muted == 'yes') {
			$muted = true;
		} else {
			$muted = false;
		}

		//Video Youtube
		$video = $this->video->where(['source' => 2, 'status' => 1])->orderBy('upload_time', 'DESC')->first();
		if ($video) {
			$videoYT = $video['kode_youtube'];
		}

		return view('App\Modules\Display\Views/' . $view, [
			'layout_aktif' => $this->setting->info['layout'],
			'title' => $this->setting->info['nama_aplikasi'],
			'background' => $background,
			'logo' => $this->setting->info['logo'],
			'nama_instansi' => $this->setting->info['nama_instansi'],
			'alamat' => $this->setting->info['alamat'],
			'news_refresh' => $this->setting->info['news_refresh'],
			'agenda_refresh' => $this->setting->info['agenda_refresh'],
			'slide_refresh' => $this->setting->info['slide_refresh'],
			'jadwal_sholat' => $this->setting->info['jadwal_sholat'],
			'video_youtube' => $this->setting->info['video_youtube'],
			'name_agenda_instansi' => $this->setting->info['name_agenda_instansi'],
			'videoId' => $videoYT ?? "0",
			'video_muted' => $muted,
			'content' => $content,
			'fs_nama' => $this->setting->info['fontsize_nama'],
			'fs_alamat' => $this->setting->info['fontsize_alamat'],
			'fw_nama' => $this->setting->info['fontweight_nama'],
			'bgcolor_jam' => $this->setting->info['bgcolor_jam'],
			'bgcolor_news' => $this->setting->info['bgcolor_newsticker'],
			'ccol_height' => $this->setting->info['custom_col_maxheight'],
			'custom' => $custom ?? "",
			'vc_autoplaytimeout' => $this->setting->info['carousel_autoplay_timeout'],
			'marquee_speed' => $this->setting->info['marquee_speed'],
			'cuaca_refresh' => $this->setting->info['cuaca_refresh'],
			'use_pusher' => $this->setting->info['use_pusher'],
			'meta_refresh_enable' => $this->setting->info['meta_refresh_enable'],
			'meta_refresh_time' => $this->setting->info['meta_refresh_time'],
			'fs_tanggal' => $this->setting->info['fontsize_tanggal'],
			'fs_jam' => $this->setting->info['fontsize_jam'],
			'fs_marquee' => $this->setting->info['fontsize_marquee'],
			'vc_imageheight' => $this->setting->info['carousel_image_height']
		]);
	}
}

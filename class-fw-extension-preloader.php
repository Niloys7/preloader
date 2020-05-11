<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Preloader extends FW_Extension {
	
	/**
	 * @internal
	 */
	public function _init() {
        
		add_action( 'fw_customizer_options', [$this,'_filter_theme_fw_customizer_options'] );
		add_action( 'wp_footer', [$this,'_render_preloader'] );
		add_action( 'wp_enqueue_scripts', [$this,'_enqueue_scripts'] );
		


	}
// fw_ext('builder')->get_uri('/static/css/frontend-grid.css'),
	function _enqueue_scripts(){
		$animation_file = fw_get_db_customizer_option('preloader/true/preloader_type/preloader_css/animation');
		wp_enqueue_style( 'preloader-animation', fw_ext('preloader')->get_uri('/assets/css/'.$animation_file.'.min.css'), null, '1.0' );

		$color = fw_get_db_customizer_option('preloader/true/preloader_type/preloader_css/prelaoder_color'); //E.g. #FF0000
		$bg_color = fw_get_db_customizer_option('preloader/true/bg_color');
		$preloader_css = "
		@keyframes pulse {
		from { transform: scale(1); }
		50% { transform: scale(0.8); }
		to { transform: scale(1); }
		}

		.fe-pulse-w-pause {
		animation-name: pulse;
		animation-duration: 1s;
		animation-iteration-count: infinite;
		}
		.cix-preloader {
			position: fixed;
			height: 100%;
			width: 100%;
			background: #000;
			z-index: 9999;
			top: 0;
			background: {$bg_color};
		}
		.cix-preloader > div,.cix-preloader >img {
			position: absolute;
			
			
		}
		.cix-preloader > div{
			width:64px;
		}
		.cix-preloader >img{
			margin-left:-75px;
			margin-top:-20px;
		
		}
		.prelaoder-color{
            color: {$color};
		}";
		wp_add_inline_style( 'preloader-animation', $preloader_css );
		wp_add_inline_script( 'jquery-migrate', "

		function setMargins() {
			width = jQuery(window).width();
			height = jQuery(window).height();
			containerWidth = jQuery(\"#preloader > div,#preloader > img\").width(); 

			containerHeight = jQuery(\"#preloader > div,#preloader > img\").height();  
			
			topMargin = (height-containerWidth)/2;    
			leftMargin = (width-containerWidth)/2;    
			jQuery(\"#preloader > div,#preloader > img\").css(\"marginLeft\", leftMargin);    
			jQuery(\"#preloader > div,#preloader > img\").css(\"marginTop\", topMargin);    
		}

		jQuery(window).on('load', function() { 
           jQuery('#preloader > div,#preloader > img').fadeOut(); 
           jQuery('#preloader').delay(350).fadeOut('slow'); 
		   jQuery('body').delay(350).css({'overflow':'visible'});
		   
		   setMargins();
			jQuery(window).resize(function() {
				setMargins();    
			});
	
          })");
		

	}


	function _render_preloader() {
		$animation_value = fw_get_db_customizer_option('preloader/true/preloader_type/preloader_css/animation');
		//fw_print(fw_get_db_customizer_option('preloader/true/preloader_type/logo/pre_logo/url'));

		$logo = fw_get_db_customizer_option('preloader/true/preloader_type/selector');
		$logo_url = fw_get_db_customizer_option('preloader/true/preloader_type/logo/pre_logo/url');
		if($logo == 'logo'){
			echo '<div id="preloader" class="cix-preloader" "><img style="width:150px"; class="fe-pulse-w-pause" src="'.esc_url($logo_url).'" alt="prelaoder img" /></div>';
		}else{
			echo '<div id="preloader" class="cix-preloader">'.$this->animation_html($animation_value).'</div>';
		}

	
		
	}


	/*
	Preloader Animation Html 
	*/
	static function animation_html($animation){

		$markup = array(
			'ball-atom' => '<div class="prelaoder-color la-ball-atom la-2x"> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-beat' => '<div class="prelaoder-color la-ball-beat la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-circus' => '<div class="prelaoder-color la-ball-circus la-2x"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-climbing-dot' => '<div class="prelaoder-color la-ball-climbing-dot la-2x"> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-clip-rotate' => '<div class="prelaoder-color la-ball-clip-rotate la-2x"> <div></div> </div>',
			'ball-clip-rotate-multiple' => '<div class="prelaoder-color la-ball-clip-rotate-multiple la-2x"> <div></div> <div></div> </div>',
			'ball-clip-rotate-pulse' => '<div class="prelaoder-color la-ball-clip-rotate-pulse la-2x"> <div></div> <div></div> </div>',
			'ball-fall' => '<div class="prelaoder-color la-ball-fall la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-fussion' => '<div class="prelaoder-color la-ball-fussion la-2x"> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-grid-beat' => '<div class="prelaoder-color la-ball-grid-beat la-2x"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-newton-cradle' => '<div class="prelaoder-color la-ball-newton-cradle la-2x"> <div></div> <div></div> <div></div> <div></div> </div>',

			'ball-pulse-rise' => '<div class="prelaoder-color la-ball-pulse-rise la-2x"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-pulse-sync' => '<div class="prelaoder-color la-ball-pulse-sync la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-pulse' => '<div class="prelaoder-color la-ball-pulse la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-rotate' => '<div class="prelaoder-color la-ball-rotate la-2x"> <div></div> <div></div> <div></div> </div>',
			
			'ball-scale-multiple' => '<div class="prelaoder-color la-ball-scale-multiple  la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-scale-pulse' => '<div class="prelaoder-color la-ball-scale-pulse la-2x"> <div></div> <div></div> </div>',
			'ball-scale-ripple-multiple' => '<div class="prelaoder-color la-ball-scale-ripple-multiple la-2x"> <div></div> <div></div> <div></div> </div>',
			'ball-scale-ripple' => '<div class="prelaoder-color la-ball-scale-ripple  la-2x"> <div></div> </div>',

			'ball-scale' => '<div class="prelaoder-color la-2x la-ball-scale"> <div></div> </div>',
			'ball-spin-clockwise-fade' => '<div class="prelaoder-color la-2x la-ball-spin-clockwise-fade"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-spin-clockwise' => '<div class="prelaoder-color la-2x la-ball-spin-clockwise"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-spin-rotate' => '<div class="prelaoder-color la-2x la-ball-spin-rotate"> <div></div> <div></div> </div>',
			'ball-square-clockwise-spin' => '<div class="prelaoder-color la-2x la-ball-square-clockwise-spin"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'ball-triangle-path' => '<div class="prelaoder-color la-2x la-ball-triangle-path"> <div></div> <div></div> <div></div> </div>',
			'ball-zig-zag-deflect' => '<div class="prelaoder-color la-2x la-ball-zig-zag-deflect"> <div></div> <div></div> </div>',

			'cog' => '<div class="prelaoder-color la-2x la-cog"> <div></div> </div>',
			'cube-transition' => '<div class="prelaoder-color la-2x la-cube-transition"> <div></div> <div></div> </div>',
			'fire' => '<div class="prelaoder-color la-2x la-fire"> <div></div> <div></div> <div></div> </div>',
			'line-scale-party' => '<div class="prelaoder-color la-2x la-line-scale-party"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'line-scale-pulse-out-rapid' => '<div class="prelaoder-color la-2x la-line-scale-pulse-out-rapid"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'line-scale' => '<div class="prelaoder-color la-2x la-line-scale"> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'line-spin-clockwise-fade-rotating' => '<div class="prelaoder-color la-2x la-line-spin-clockwise-fade-rotating"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'line-spin-fade-rotating' => '<div class="prelaoder-color la-2x la-line-spin-fade-rotating"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'line-spin-fade' => '<div class="prelaoder-color la-2x la-line-spin-fade"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'pacman' => '<div class="prelaoder-color la-2x la-pacman"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>',
			'square-jelly-box' => '<div class="prelaoder-color la-2x la-square-jelly-box"> <div></div> <div></div> </div>',
			'square-loader' => '<div class="prelaoder-color la-2x la-square-loader"> <div></div> </div>',
			'square-spin' => '<div class="prelaoder-color la-2x la-square-spin"> <div></div> </div>',
			'timer' => '<div class="prelaoder-color la-2x la-timer"> <div></div> </div>',
			'triangle-skew-spin' => '<div class="prelaoder-color la-2x la-triangle-skew-spin"> <div></div> </div>',
			
		);

		return $markup[$animation];
	}
	
	public function _filter_theme_fw_customizer_options($options) {

		$options['preloader'] = array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'picker' => array(
					'gadget' => array(
						'label' => false,
						'attr'  => array( 'class' => 'hidden'),
						'type' => 'switch',
						
						'right-choice' => array(
							'value' => 'true',
							'label' => esc_html__('Yes', 'bariel')
						),
						'value' => 'true'
					)
				),

				'choices' => array(
					'true' => array(
						
						'preloader_type' =>  array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'selector' => array(
									'label' => __('Preloader Type', 'fw'),								
									'type'    => 'select',
									'value' => 'preloader_css',
									'choices' => array(
										'preloader_css' => __('Animated Preloader', 'fw'),
										'logo'  => __('Logo Preloader', 'fw'),
										
									),
								)
							),
							'choices' => array(
								'logo' => array(
									'pre_logo' => array(
										'type'  => 'upload',
										'images_only' => true,
										'label' => __('Upload Logo', 'fw'),
										
									),
								
								),
								'preloader_css' => array(
									'animation' => array(
									'type'  => 'select',
									'value' => 'ball-fussion',
									'label' => __('Select Loading Animation', 'fw'),
									
									'choices' => array(
										array( // optgroup
											'attr'    => array('label' => __('Special Effects', 'fw')),
											'choices' => array(
												'cog' => 'Cog',
												'fire' => 'Fire',
												'pacman' => 'Pacman',
												'timer' => 'Timer',
												'triangle-skew-spin' => 'Triangle Skew Spin',
												
											),
										),
										array( // optgroup
											'attr'    => array('label' => __('Line Effects', 'fw')),
											'choices' => array(
												'line-scale-party' => 'Line Scale Party',
												'line-scale-pulse-out-rapid' => 'Line Scale Pulse Out Rapid',
												'line-scale' => 'Line Scale',
												'line-spin-clockwise-fade-rotating' => 'Line Spin Clockwise Fade Rotating',
												'line-spin-fade-rotating' => 'Line Spin Fade Rotating',
												'line-spin-fade' => 'Line Spin Fade',
												
											),
										),
										array( // optgroup
											'attr'    => array('label' => __('Square Effects', 'fw')),
											'choices' => array(
												
												'square-jelly-box' => 'Square Jelly Box',
												'square-loader' => 'Square Loader',
												'square-spin' => 'Square spin',
												
											),
										),
										array( // optgroup
											'attr'    => array('label' => __('Ball Effects', 'fw')),
											'choices' => array(
												'ball-atom' => 'Ball Atom',
												'ball-beat' => 'Ball Beat',
												'ball-circus' => 'Ball Circus',
												'ball-climbing-dot' => 'Ball Climbing Dot',
												'ball-clip-rotate' => 'Ball Clip Rotate',
												'ball-clip-rotate-multiple' => 'Ball Clip Rotate Multiple',
												'ball-clip-rotate-pulse' => 'Ball Clip Rotate Pulse',
												'ball-fall' => 'Ball Fall',
												'ball-fussion' => 'Ball Fussion',
												'ball-grid-beat' => 'Ball Grid Beat',
												'ball-newton-cradle' => 'Ball Newton Cradle',
												'ball-pulse-rise' => 'Ball Pulse Rise',
												'ball-pulse-sync' => 'Ball Pulse Sync',
												'ball-pulse' => 'Ball Pulse',
												'ball-rotate' => 'Ball Rotate',									
												'ball-scale-multiple' => 'Ball Scale Multiple',
												'ball-scale-pulse' => 'Ball Scale Pulse',
												'ball-scale-ripple-multiple' => 'Ball Scale Ripple Multiple',
												'ball-scale-ripple' => 'Ball Scale Ripple',

												'ball-scale' => 'Ball Scale ',
												'ball-spin-clockwise-fade' => 'Ball Spin Clockwise Fade',
												'ball-spin-clockwise' => 'Ball Spin Clockwise',
												'ball-spin-rotate' => 'Ball Scale Rotate',
												'ball-square-clockwise-spin' => 'Ball Spin Clockwise Spin',
												'ball-triangle-path' => 'Ball Triangle Path',
												
												'ball-zig-zag-deflect' => 'Ball Zig Zag',

												
											),
										),
										
									
										
										
										
									),
									
								),
								'prelaoder_color' => array(
									'type'  => 'color-picker',
									'value' => '#f53b57',
									'label' => __('Loading Animation Color', 'fw'),
									'palettes' => array( '#f53b57', '#3c40c6', '#0fbcf9','#05c46b','#808e9b','#1e272e' ,'#4834d4','#be2edd','#3B3B98'),
									
								),			
								)
							),
						),
						'bg_color' => array(
							'type'  => 'rgba-color-picker',
							'value' => 'rgba(255,255,255,0.91)',
							'label' => __('Background Color', 'fw'),
							'palettes' => array( '#f53b57', '#3c40c6', '#0fbcf9','#05c46b','#808e9b','#1e272e' ,'#4834d4','#be2edd','#3B3B98'),
							
						),


						
						
					)
				),
		);
              

		return $options;
	}


}
    
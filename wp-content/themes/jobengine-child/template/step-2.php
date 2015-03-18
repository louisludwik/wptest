<?php
* Step Job Info
?>
	<div class="toggle-title f-left-all <?php if ( et_is_logged_in() ) { echo "bg-toggle-active"; } ?> <?php if(!!$job) echo 'toggle-complete';?>">
			<form id="job_form" method="post" enctype="multipart/form-data" novalidate="novalidate" autocomplete="on">
					<div class="form-item">
							<h6 class="font-quicksand"><?php _e('JOB TITLE', ET_DOMAIN );?></h6>
		</div>
							<input class="bg-default-input" tabindex="1" name="title" id="title" type="text" value="<?php if(isset($job['title'])) echo esc_attr($job['title']);?>" />
					</div>
							<?php 
									wp_editor( $content ,'content' , je_job_editor_settings () );
								<?php 
									if(isset($job['location'])) 	$location 			=	 $job['location'];
								<div class="map-inner" id="map"></div>
						</div>
					<!-- How to apply -->
						</div>
							<input type="hidden" id="apply_method" value="">
								<span class=""><?php _e("Send applications to this email address:", ET_DOMAIN); ?></span>&nbsp;
							<input type="radio" name="apply_method" id="ishowtoapply" value="ishowtoapply" <?php if( $apply_method == 'ishowtoapply') echo 'checked' ?> />
							<div class="applicant_detail">
						</div>
					</div>
					<!-- END How to apply -->
							<?php et_job_type_select('job_types'); ?>
						<div class="label">
							<?php _e('Select a category for your job', ET_DOMAIN );?>
						<div class="select-style btn-background border-radius">
						</div>

						<input name="register_term" class="required not_empty" id="term_of_post" type="checkbox" />
					  	</div>
					<div class="btn-cancel">
				</div>
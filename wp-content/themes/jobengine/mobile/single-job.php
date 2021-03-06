<?php et_get_mobile_header('mobile'); ?>
<?php
global  $post , $current_user, $user_ID;
$job = $post;
if(have_posts()) {
	the_post ();

	$job_cat 		= et_get_the_job_category ($job->ID);
	$job_types		= et_get_the_job_type($job->ID);
	$colours        = et_get_job_type_colors($job->ID);
	$company		= new WP_User($post->post_author);
	$job_location	= et_get_post_field ($job->ID,'location');

	$id_color = isset($colours[$job_types[0]->term_id]) ? $colours[$job_types[0]->term_id] :'';

?>

	<div data-role="content" class="post-content resume-contentpage">
		<h1 class="title-resume">
			<?php the_title(); ?>
			<a href="#" class="post-title-link icon" data-icon="A"></a>
		</h1>
		<div class="content-info inset-shadow">
			<span class="arrow-right"></span>
			<a class="list-link job-employer" data-transition="slide" href="<?php echo get_author_posts_url($post->post_author); ?>"
				title="<?php printf(__('View posted jobs by %s', ET_DOMAIN), $company->display_name); ?>">
				<span>@</span>
				<?php echo $company->display_name; ?>
			</a>
			<div class="mblDomButtonGrayArrow arrow">
				<div></div>
			</div>
		</div>
		<?php if($job_location != '') { ?>
		<div class="content-info">
			<span class="arrow-right"></span>
			<a class="list-link job-loc" href="<?php echo home_url(); ?>?location=<?php echo $job_location; ?>" rel="external" data-transition="slide" id="com_location"><span class="icon" data-icon="@"></span> <?php echo $job_location; ?> </a>
			<div class="mblDomButtonGrayArrow arrow">
				<div></div>
			</div>
		</div>
		<?php } ?>
		<?php if(!empty($job_types)) { ?>
		<div class="content-info">
			<span class="arrow-right"></span>
			<a href="<?php echo home_url(); ?>?job_type=<?php echo $job_types[0]->slug; ?>&status=publish" class="list-link job-loc color-<?php echo $id_color ; ?>" rel="external" data-transition="slide">
				<span class="icon-label flag"></span><?php echo $job_types[0]->name; ?></a>
			<div class="mblDomButtonGrayArrow arrow">
				<div></div>
			</div>
		</div>
		<?php } ?>
		<div class="content-info content-text">
		<?php
		 	the_content();
			do_action( 'je_single_job_fields', $job);
		 ?>
		</div>

		<div class="content-info content-info-last content-text">
			<?php
			$apply_method	=	et_get_post_field( $job->ID, 'apply_method');
			if( $apply_method != 'ishowtoapply' ) {
				?>
				<a href="#modal_apply" class="ui-btn-s btn-blue btn-wide modal-open"><?php  _e('Apply For This Job',ET_DOMAIN); ?></a>
				<?php

			}	else { ?>
				<a href="#modal_apply" class="ui-btn-s btn-blue btn-wide modal-open"><?php  _e('How To Apply',ET_DOMAIN); ?></a>
			<?php } ?>
		</div>
		<?php
			if(et_get_auto_email('remind')) {
		?>
		<div class="content-info content-info-last content-text" style="border-top:1px solid #E6E6E6;">
			<?php
				_e("Busy right now? You can remind this Job by your email", ET_DOMAIN);
			 ?>
				<a href="#modal_remind" data-msg="<?php _e("You have to use jobseeker account to apply job.", ET_DOMAIN); ?>" class="remind ui-btn-s btn-white btn-wide modal-open">
					<?php  _e('Remind This Job',ET_DOMAIN); ?>
				</a>
		</div>
		<?php }	?>
		<div id="modal_remind" class="modal apply-popup" style="display: none">
			<input type="hidden" id="current_job_id" value="<?php echo $job->ID; ?>">
			<h3><?php _e('Email reminder',ET_DOMAIN); ?></h3>
			<p><?php _e('We will send you an email with the job information for later review.',ET_DOMAIN); ?></p>
			<div class="input-text-remind">
				<input type="text" name="emails" id="remind_email">
				<span class="icon input-icon" data-icon="M"></span>
			</div>
			<a href="#" id="et_remind_email" class="ui-btn-s btn-blue btn-wide"><?php _e('Save this job',ET_DOMAIN); ?></a>
		</div>

		<div id="modal_apply" class="modal apply-popup" style="display: none" >
			<?php if( $apply_method != 'ishowtoapply' ) { ?>
				<input type="hidden" id="current_job_id" value="<?php echo $job->ID; ?>">
				<h3><?php _e('Apply for this job',ET_DOMAIN); ?></h3>

					<form id="jobseeker_apply_form">

						<input type="hidden" name="job_id" value="<?php echo $job->ID ?>" id="job_id">
					<?php
					$roles	=	$current_user->roles;
					$role	=	array_pop($roles);

					if( $user_ID && $role == 'jobseeker'  )	 { ?>
						<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="<?php echo wp_create_nonce( 'apply_job' ) ?>">
						<input type="hidden" id="jobseeker_id" name="jobseeker_id" value="<?php echo $user_ID; ?>">
						<input required type="hidden" id="emp_name" name="emp_name" value="<?php echo empty($current_user->display_name) ? '' : $current_user->display_name ?>">
						<input required type="hidden" id="emp_email" name="emp_email" value="<?php echo empty($current_user->user_email) ? '' : $current_user->user_email; ?>">

						<div class="logged-name">
							<?php printf(__('Logged in as <span>%s</span>.', ET_DOMAIN ) , $current_user->ID ? $current_user->display_name : '' ) ?>
							<a href="<?php echo wp_logout_url(get_permalink( $job->ID )) ?>" title="<?php _e("Log out?", ET_DOMAIN); ?>" ><?php  _e("Log out?", ET_DOMAIN); ?> </a>
						</div>

					<?php } else { ?>
						<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="<?php echo wp_create_nonce( 'apply_docs_et_uploader' ) ?>">
						<div class="input-text-remind">
							<input required type="text" required id="emp_name" name="emp_name" value="" placeholder="<?php _e("Your name", ET_DOMAIN); ?>" >
						</div>
						<div class="input-text-remind">
							<input required type="email" required="email" id="emp_email" name="emp_email" value="" placeholder="<?php _e("Your email", ET_DOMAIN); ?>">
						</div>
					<?php } ?>
						<div class="input-text-remind">
							<div class="label">
								<?php _e("Notes",ET_DOMAIN);?>
							</div>
							<textarea  name="apply_note" id="apply_note" placeholder="" ></textarea>
						</div>

						<?php do_action( 'je_mobile_captcha' ); ?>

						<input type="submit" href="#" id="<?php if( $user_ID && $role == 'jobseeker'  )	 echo 'jobseeker_apply'; else echo 'normal_apply'; ?>" class="" value="<?php _e('Apply',ET_DOMAIN); ?>" />
						<?php if(!$user_ID && function_exists('et_is_resume_menu') ) { ?>
							 <?php _e("Apply by an online resume.", ET_DOMAIN); ?>
							<a data-ajax="false" href="<?php echo et_get_page_link( 'login' , array('redirect_url' => get_permalink( $job->ID ) ) ); ?>" ><?php _e("Login", ET_DOMAIN); ?></a> or
							<a data-ajax="false" href="<?php echo et_get_page_link('jobseeker-signup'); ?>" ><?php _e("Register", ET_DOMAIN); ?></a>
						<?php } ?>
					</form>

			<?php } else {
				echo '<h3>'.__("HOW TO APPLY FOR THIS JOB", ET_DOMAIN).'</h3>';
				echo et_get_post_field($job->ID, 'applicant_detail');
			} ?>

		</div>

	</div><!-- /content -->

	<div class="share-social">
		<h1><?php _e('Share',ET_DOMAIN); ?></h1>
		<ul>
			<li>
				<a href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" class="ui-link">
					<span class="icon-tw"></span><?php _e('Tweet this job',ET_DOMAIN); ?>
				</a>
			</li>
			<li>
				<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" class="ui-link">
				<span class="icon-fb"></span><?php _e('Share on Facebook',ET_DOMAIN); ?>
				</a>
			</li>
			<li>
				<a href="mailto:type email address here?subject=share this post from <?php echo bloginfo('name'); ?>&body=<?php the_title(); ?>&#32;&#32;<?php the_permalink(); ?>" class="ui-link">
					<span class="icon-mail"></span><?php _e('Send via Email',ET_DOMAIN); ?>
				</a>
			</li>
		</ul>
	</div>
<?php } ?>
<?php et_get_mobile_footer('mobile'); ?>
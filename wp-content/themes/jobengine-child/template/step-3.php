<?php
?>
<div class="step" id="step_package">
			<?php _e('Choose the pricing plan that fits your needs', ET_DOMAIN);?>
	</div>
							<?php
		$plans = et_get_payment_plans();

			<ul>
				/**
				*/
					$temp	=	$plans;
					if( $p['price'] == 0 )  $only_free = true;

								</div>
							</div>
							<!-- /*add class mark-step will be auto select*/ -->
								data-package="<?php echo $plan['ID'];?>"
								<?php if( $plan['price'] > 0 ) { ?>
				<?php endforeach; ?>

				<?php }?>
		<?php do_action ('je_after_job_package_list');	 ?>
		<script id="package_plans" type="text/data">
		</script>
	</div> <!-- end toggle content !-->
</div> <!-- end step_package !-->
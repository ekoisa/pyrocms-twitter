<p>
	<h2>
		<?php echo lang('user_register_header') ?>
	</h2>

	<?php if ( !empty( $user_data['error'] )):?>
		<div class="error-box">
			<?php echo $user_data['error']; ?>
		</div>
	<?php endif; ?> 
	
	<p>
		<span id="active_step"><?php echo lang('user_register_step1') ?></span> -&gt; 
		<span>
			<?php echo lang('user_register_step2') ?>
		</span>
	</p>

	<p>
		<?php echo lang('user_register_reasons') ?>
	</p> 

	<?php echo form_open('twitter/register'); ?>
		<ul>	
			<li>
				<label for="email"><?php echo lang('user_email') ?> - <em><?php echo lang('user_email_use') ?></em></label>
				<input type="text" name="email" maxlength="100" value="<?php echo $user_data['email']; ?>" />
			</li>	
			<li>
				<label for="confirm_email"><?php echo lang('user_confirm_email') ?></label>
				<input type="text" name="confirm_email" maxlength="100" value="<?php echo $user_data['confirm_email']; ?>" />
			</li>
			<li>
				<?php echo form_submit('btnSubmit', lang('user_register_btn')) ?>
			</li>
		</ul>
	<?php echo form_close(); ?>
</p>

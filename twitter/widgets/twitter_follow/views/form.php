<ol>
   	<li class="even">
   		<label>Twitter Account</label>
   		<?php echo form_input('data-name', $options['data-name']); ?>
   	</li>
   	<li class="even">
	   	<label>Button color</label>
   		<?php echo form_dropdown('data-button', array('white'=>'White', 'grey' => 'Grey'), $options['data-button']); ?>
   	</li>
   	<li class="even">
   		<label>Text color</label>
   		<?php echo form_input('data-text-color', $options['data-text-color']); ?>
   	</li>
   	<li class="even">
   		<label>Link color</label>
   		<?php echo form_input('data-link-color', $options['data-link-color']); ?>
   	</li>
   	<li class="even">
   		<label>Width</label>
   		<?php echo form_input('data-width', $options['data-width']); ?>
   	</li>
   	<li class="even">
	   	<label>Align</label>
   		<?php echo form_dropdown('data-align', array('right'=>'Right', 'center' => 'Center', 'left'=>'Left'), $options['data-align']); ?>
   	</li>
   	<li class="even">
	   	<label>Show numbers of followers?</label>
   		<?php echo form_dropdown('data-show-count', array('true'=>'true', 'false' => 'false'), $options['data-show-count']); ?>
   	</li>
</ol>

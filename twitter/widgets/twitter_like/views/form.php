<ol>
   	<li class="even">
   		<label>Twitter Account</label>
   		<?php echo form_input('data-via', $options['data-via']); ?>
   	</li>
   	<li class="even">
   		<label>Langue</label>
   		<?php echo form_dropdown('data-lang', array('default' => 'Site language', 'en' => 'English', 'fr'=>'French'), $options['data-lang']); ?>
   	</li>
   	<li class="even">
   		<label>URL</label>
   		<?php echo form_dropdown('data-url', array('default' => 'Site url', 'current' => 'Current url'), $options['data-url']); ?>
   	</li>
   	<li class="even">
   		<label>Description</label>
   		<?php echo form_textarea('data-text', $options['data-text']); ?>
   	</li>
   	<li class="even">
   		<label>Wich counter:</label>
   		<?php echo form_dropdown('data-count', array('none' => 'None', 'vertical'=>'Vertical', 'horizontal' => 'Horizontal'), $options['data-count']); ?>
   	</li>
   	<li class="even">
   		<label>Related Account</label>
   		<?php echo form_input('data-related', $options['data-related']); ?>
   	</li>
   	<li class="even">
   		<label>Related Account description</label>
   		<?php echo form_textarea('data-related-desc', $options['data-related-desc']); ?>
   	</li>
</ol>

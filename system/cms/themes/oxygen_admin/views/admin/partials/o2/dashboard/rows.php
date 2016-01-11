
<?php if(isset($row1)):?>
	<div class="row">
		<?php
			foreach($row1 as $item):
				echo $this->load->view($item->partial,$item);
			endforeach;
		?>
	</div>
<?php endif;?>
<?php if(isset($row2)):?>
	<div class="row">
		<?php
			foreach($row2 as $item):
				echo $this->load->view($item->partial,$item);
			endforeach;
		?>
	</div>
<?php endif;?>
<?php if(isset($row3)):?>
	<div class="row">
		<?php
			foreach($row3 as $item):
				echo $this->load->view($item->partial,$item);
			endforeach;
		?>
	</div>
<?php endif;?>

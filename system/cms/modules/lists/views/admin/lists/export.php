<style>
textarea.styled {
	width: 600px;
	height: 600px;
	border: 3px solid #cccccc;
	padding: 5px;
	font-family: 'consolas','courier';
	background-image: url(bg.gif);
	background-position: bottom right;
	background-repeat: no-repeat;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">

                <div class="box-header">
                  <h3 class="box-title">

						JSON Export of Stream data

                  </h3>
                </div>

				<div class="box-body">
					<textarea class='styled' readonly><?php echo $List->export;?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>

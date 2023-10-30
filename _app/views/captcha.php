<!-- captcha -->
	<div class="m-t-10 m-b-10 container" >	
		<div class="row">
			<div class="col">
				<input type="text" class="round form-control form-control-sm" name="captcha_input" placeholder="Ketik captcha" required/>
			</div>
			<div class="col">
				<?php echo $captha_image['image']; ?>
			</div>
		</div>		
		<input type="hidden" value="<?php echo $captha_image['word'] ?>" name="code_cap" />
	</div>    
    <button class="btn btn-block btn-info mt-2">Login</button>
<!-- end-captcha -->
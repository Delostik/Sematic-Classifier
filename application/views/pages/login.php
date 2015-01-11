<div class="container marketing">
<hr class="featurette-divider">
    <div class="row featurette">
	   <div class="col-md-7">
			<h2 class="featurette-heading">Online Sematic Classifier</h2>
			<p class="lead">　　Manual semantic classifier system.</p>
		</div>
		<div class="col-md-5">
            <form action="<?=base_url()?>do_login" method="post">
                <style>
                    .form-control {
                        max-width: 280px;
                    }
                    .btn-group-justified {
                    	max-width: 320px;
                    }
		        </style>
                <br />
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="text" class="form-control" placeholder="Username" name="userName">
                </div>
                <br />
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="password" class="form-control" placeholder="password" name="password">
                </div>
                <br />
                <?php 
                    if ($errMsg)
                    {
                        echo "<div class='alert alert-danger btn-group-justified' role='alert'>". $errMsg. "</div>";
                    }
                ?>
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button type="button submit" class="btn btn-default">Login</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">Forget</button>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>
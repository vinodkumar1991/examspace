<nav id="myNavbar"
	class="navbar navbar-default navbar-inverse navbar-fixed-top"
	role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target="#navbarCollapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand"
				href="<?php echo Yii::getAlias('@fweb').'/home'; ?>"><img
				src="<?php echo Yii::getAlias('@fasset').'/img/logo.png';?>"></a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbarCollapse">

			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a
					href="<?php echo Yii::getAlias('@fweb').'/home'; ?>">Home</a></li>
				<li><a href="<?php echo Yii::getAlias('@fweb').'/about-us'; ?>">About
						Us</a></li>
				<li><a href="<?php echo Yii::getAlias('@fweb').'/event-home'; ?>">Evets</a></li>
				<!-- 					<li><a href="">Blog</a></li> -->
					<?php
    if (Yii::$app->session['player_data']['player_id']) {
        ?>
        <li><a class=""
					href="<?php echo Yii::getAlias('@fweb').'/account'; ?>">My Account</a></li>
						
    <?php }else{ ?>
    <li><div class="main-nav">
						<a class="cd-signin" href="#">My Account</a>
					</div></li>
    <?php }?>
					<?php
    if (Yii::$app->session['player_data']['player_id']) {
        ?>		
					<li><?php echo 'Welcome '.Yii::$app->session['player_data']['fullname']; ?><a
					href="<?php echo Yii::getAlias('@fweb').'/logout'; ?>">logout</a></li>
						<?php } ?>
				</ul>

		</div>
	</div>
</nav>
<?php echo $this->render('login.php');?>

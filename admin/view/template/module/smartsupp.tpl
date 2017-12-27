<?php echo $header; ?><?php echo $leftMenu; ?>
<div id="content">
	<div class="wrap" id="content">

	<?php if ($enabled) { ?>
		<main role="main">
			<div id="third">
				<section class="top-bar">
					<div class="text-center">
						<img src="<?= $base ?>/view/image/smartsupp/logo.png" alt="smartsupp logo" />
					</div>
				</section>
				<section class="deactivate">
					<div class="row">
						<p class="bold">
							<span class="left"><?= isset($email) ? $email : '' ?></span>
							<span class="right"><a class="js-action-disable" href="javascript: void(0);"><?= $_('Deactivate Chat') ?></a></span>
						</p>
						<div class="clear"></div>
						<section class="intro">
							<h4><?= $_('goToSmartsuppText') ?></h4>
							<div class="intro--btn">
								<a href="https://dashboard.smartsupp.com?utm_source=OpenCart&utm_medium=integration&utm_campaign=link" target="_blank" class="js-register btn btn-primary btn-xl"><?= $_('goToSmartsupp') ?></a>
							</div>
							<p class="tiny text-center bigger-m"><?= $_('openInNewTab') ?></p>
						</section>
					</div>
				</section>
				<section>
					<div class="settings-container">
						<div class="section--header">
							<h3 class="no-margin"><?= $_('advancedSettings') ?></h3>
							<p><?= $_('optionalCode') ?></p>
						</div>
						<div class="section--body">
							<form action="" method="post" id="settingsForm" class="js-code-form form-horizontal" autocomplete="off">
								<div class="alerts">
									<?php if ($message) { ?>
										<div class="alert alert-success">
											<?= $_($message) ?>
										</div>
									<?php } ?>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<textarea name="code" id="textAreaSettings" cols="30" rows="10"><?= isset($customCode) ? $customCode : '' ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="loader"></div>
										<button type="submit" class="btn btn-primary btn-lg" name="_submit">
											<?= $_('saveChanges') ?>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</main>
	<?php } else { ?>
		<main role="main" class="sections" id="home"<?php if ($formAction) { ?> style="display: none;"<?php } ?>>
			<div id="first">
				<section class="top-bar">
					<div class="">
						<img src="<?= $base ?>/view/image/smartsupp/logo.png" alt="smartsupp logo" />
						<a href="javascript: void(0);" class="js-login btn btn-default"><?= $_('connectAccount') ?></a>
					</div>
				</section>
				<section class="intro">
					<div>
						<h1 class="lead"><?= $_('freeChat') ?></h1>
						<h3><?= $_('customersOnWebsite') ?><br/><?= $_('chatWithThem') ?></h3>
						<div class="intro--btn">
							<a href="javascript: void(0);" class="js-register btn btn-primary btn-xl"><?= $_('createAccount') ?></a>
						</div>
						<div class="intro--image">
							<img src="<?= $base ?>/view/image/smartsupp/intro-img.png" alt="intro" />
						</div>
					</div>
				</section>
				<section>
					<div class="text-center">
						<div class="section--header">
							<h2><?= $_('freeOrPremium') ?></h2>
							<p><?= $_('allFeatures') ?></a></p>
						</div>
						<div class="section--body boxies">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 box box-bubble">
									<p class="bold"><?= $_('chatInRealTime') ?></p>
									<p class="tiny"><?= $_('loyalty') ?></p>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 box box-graph">
									<p class="bold"><?= $_('increaseSales') ?></p>
									<p class="tiny"><?= $_('visitorsToCustomers') ?></p>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 box box-mouse">
									<p class="bold"><?= $_('screenRecording') ?></p>
									<p class="tiny"><?= $_('visitorBehavior') ?></p>
								</div>
							</div>
						</div>
						<div class="section--header">
							<h2><?= $_('trusted') ?></h2>
						</div>
						<div class="section--body">
							<div class="customers">
								<img src="<?= $base ?>/view/image/smartsupp/skoda.png" alt="ŠKODA AUTO a.s." />
								<img src="<?= $base ?>/view/image/smartsupp/gekko.jpeg" width="200" height="200" alt="GEKKO Computer" />
								<img src="<?= $base ?>/view/image/smartsupp/lememo.png" alt="Lememo" />
								<img src="<?= $base ?>/view/image/smartsupp/conrad.png" alt="Conrad" />
							</div>
						</div>
					</div>
				</section>
			</div>
		</main>
		<main role="main" class="sections" id="connect"<?php if (!$formAction) { ?> style="display: none;"<?php } ?>>
			<div id="second">
				<section class="top-bar">
					<div>
						<a href="javascript: void(0);" class="js-close-form">
							<img src="<?= $base ?>/view/image/smartsupp/logo.png" alt="smartsupp logo" />
							<a href="javascript: void(0);" class="btn btn-default" data-toggle-form data-multitext data-register="<?= $_('connectAccount') ?>" data-login="<?= $_('createAccount') ?>">
								<?= $_($formAction === 'register' ? 'connectAccount' : 'createAccount') ?>
							</a>
						</a>
					</div>
				</section>
				<section id="signUp">
					<div class="text-center">
						<div class="form-container">
							<div class="section--header">
								<h1 class="lead" data-multitext data-login="<?= $_('connectAccount') ?>" data-register="<?= $_('createAccount') ?>">
									<?= $_($formAction === 'login' ? 'connectAccount' : 'createAccount') ?>
								</h1>
							</div>
							<div class="section--body">
								<div class="form--inner">
									<form action="" method="post" id="signUpForm" class="form-horizontal<?= $formAction ? (' js-' . $formAction . '-form') : '' ?>" data-toggle-class autocomplete="off">
										<div class="alerts">
											<?php if ($message) { ?>
												<div class="alert alert-danger js-clear">
													<?= $_($message) ?>
												</div>
											<?php } ?>
										</div>
										<div class="form-group">
											<label class="visible-xs control-label col-xs-12" for="frm-signUp-form-email"><?= $_('email') ?></label>
											<div class="col-xs-12">
												<div class="input-group">
													<span class="input-group-addon hidden-xs" style="min-width: 150px;"><?= $_('email') ?></span>
													<input type="email" class="form-control input-lg" name="email" id="frm-signUp-form-email" required="" value="<?php isset($email) ? $email : '' ?>">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="visible-xs control-label col-xs-12" for="frm-signUp-form-password"><?= $_('password') ?></label>
											<div class="col-xs-12">
												<div class="input-group">
													<span class="input-group-addon hidden-xs" style="min-width: 150px;"><?= $_('password') ?></span>
													<input type="password" class="form-control input-lg" name="password" autocomplete="off" id="frm-signUp-form-password" required="">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-xs-12 form-button">
												<div class="loader"></div>
												<button type="submit" class="btn btn-primary btn-lg btn-block" name="_submit" data-multitext data-login="<?= $_('connectAccount') ?>" data-register="<?= $_('signUp') ?>">
													<?= $_($formAction === 'login' ? 'connectAccount' : 'signUp') ?>
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="section--header">
							<h2><?= $_('trusted') ?></h2>
						</div>
						<div class="section--body">
							<div class="customers">
								<img src="<?= $base ?>/view/image/smartsupp/skoda.png" alt="ŠKODA AUTO a.s." />
								<img src="<?= $base ?>/view/image/smartsupp/gekko.jpeg" width="200" height="200" alt="GEKKO Computer" />
								<img src="<?= $base ?>/view/image/smartsupp/lememo.png" alt="Lememo" />
								<img src="<?= $base ?>/view/image/smartsupp/conrad.png" alt="Conrad" />
							</div>
						</div>
					</div>
				</section>
			</div>
		</main>
	<?php } ?>

		<div class="text-center">
			<a href="javascript: void(0);" class="js-remove-plugin">Remove Smartsupp plugin (and it's data)</a>
		</div>

	</div>

</div>

<?php echo $footer; ?>

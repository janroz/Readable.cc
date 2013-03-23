<?php require 'header.html.php' ?>

<div class="page-header">
	<h1><?php echo $this->get('pageTitle') ?></h1>
</div>

<?php if ( $this->get('success') ): ?>
<div class="alert alert-success">
	<?php echo $this->get('success'); ?>
</div>
<?php endif ?>

<?php if ( $this->get('error') ): ?>
<div class="alert alert-error">
	<?php echo $this->get('error', false); ?>
</div>
<?php endif ?>

<form method="post" action="/account" class="form-signin form-horizontal well">
	<input type="hidden" name="sessionId" value="<?php echo $this->app->getSingleton('session')->getId() ?>">

	<fieldset>
		<div class="control-group <?php echo $this->get('error-email') ? 'error' : '' ?>">
			<label class="control-label" for="email">Email address</label>

			<div class="controls">
				<input id="email" name="email" class="input-xlarge" type="email" value="<?php echo $this->get('email') ?>">
			</div>
		</div>

		<div class="control-group <?php echo $this->get('error-password') ? 'error' : '' ?>">
			<label class="control-label" for="password">New password</label>

			<div class="controls">
				<input id="password" name="password" class="input-xlarge" type="password" autocomplete="off">
			</div>
		</div>

		<div class="control-group <?php echo $this->get('error-password-repeat') ? 'error' : '' ?>">
			<label class="control-label" for="password-repeat">Repeat password</label>

			<div class="controls">
				<input id="password" name="password-repeat" class="input-xlarge" type="password" autocomplete="off">
			</div>
		</div>
	</fieldset>

	<fieldset>
		<div class="control-group <?php echo $this->get('error-password-repeat') ? 'error' : '' ?>">
			<label class="control-label" for="timezone">Time zone</label>

			<div class="controls">
				<select name="timezone" id="timezone" class="input-block-level">
					<?php foreach ( $this->get('timeZones') as $offset => $timeZone ): ?>
					<option value="<?php echo $offset ?>" <?php echo $this->get('timezone') == $offset ? 'selected="selected"' : '' ?>><?php echo $timeZone ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<div class="control-group <?php echo $this->get('error-current-password') ? 'error' : '' ?>">
			<label class="control-label" for="current-password">Current password</label>

			<div class="controls">
				<input id="current-password" name="current-password" class="input-xlarge" type="password" autocomplete="off">
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button class="btn btn-primary" type="submit"><i class="entypo user"></i> Update account</button>
			</div>
		</div>
	</fieldset>
</form>

<?php if ( $words = $this->get('words') ): ?>
<h2>Word cloud</h2>

<p>
	Based on articles you have voted on these are words we believe you find interesting (black) or boring (grey).
</p>

<div id="account-words" class="well">
	<?php foreach ( $words as $word ): ?>
	<span class="<?php echo $word->score > 0 ? 'interesting' : 'boring' ?>" style="font-size: <?php echo abs($word->score * .5) + 10 ?>px;" title="<?php echo $word->word ?> (<?php echo $word->score > 0 ? 'interesting' : 'boring' ?>)">
		<?php echo $word->word ?>
	</span>
	<?php endforeach ?>
</div>
<?php endif ?>

<h2>Reset</h2>

<p>
	Start over. Delete your subscriptions, votes, saved articles and records of read articles. You will still be able to sign in.
	You can <a href="/subscriptions/export">export your subscriptions</a>.
</p>

<form method="post" action="/account/reset" class="form-signin form-horizontal well">
	<input type="hidden" name="sessionId" value="<?php echo $this->app->getSingleton('session')->getId() ?>">

	<fieldset>
		<div class="control-group <?php echo $this->get('error-password-reset') ? 'error' : '' ?>">
			<label class="control-label" for="password">Password</label>

			<div class="controls">
				<input id="password" name="password" class="input-xlarge" type="password" autocomplete="off">
			</div>
		</div>

		<div class="control-group <?php echo $this->get('error-email') ? 'error' : '' ?>">
			<div class="controls">
				<button class="btn btn-danger" type="submit"><i class="entypo user"></i> Reset account</button>
			</div>
		</div>
	</fieldset>
</form>

<h2>Delete</h2>

<p>
	Delete your account forever. Every record associated with your account will be deleted and unrecoverable.
	You can <a href="/subscriptions/export">export your subscriptions</a>.
</p>

<form method="post" action="/account/delete" class="form-signin form-horizontal well">
	<input type="hidden" name="sessionId" value="<?php echo $this->app->getSingleton('session')->getId() ?>">

	<fieldset>
		<div class="control-group <?php echo $this->get('error-password-delete') ? 'error' : '' ?>">
			<label class="control-label" for="password">Password</label>

			<div class="controls">
				<input id="password" name="password" class="input-xlarge" type="password" autocomplete="off">
			</div>
		</div>

		<div class="control-group <?php echo $this->get('error-email') ? 'error' : '' ?>">
			<div class="controls">
				<button class="btn btn-danger" type="submit"><i class="entypo user"></i> Delete account</button>
			</div>
		</div>
	</fieldset>
</form>
<?php require 'footer.html.php' ?>

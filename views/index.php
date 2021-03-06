<?php require 'header.php' ?>

<div id="page-head-wrap">
	<div id="page-head">
		<h1>Popular Reading</h1>

		<p>
			<span>Navigate to next and previous articles with <code>j</code> and <code>k</code> (<a href="<?= $this->app->getRootPath() ?>help#shortcuts">more</a>).</span>
			<?php if ( !$this->app->getSingleton('session')->get('id') ): ?>
			<span><a href="<?= $this->app->getRootPath() ?>signup">Sign up</a> to subscribe to RSS feeds for personalised reading.</span>
			<?php endif ?>
		</p>
	</div>
</div>

<?php if ( $this->app->getAction() == 'index' && !$this->get('items', false) ): ?>
<div id="items-footer">
	<p>
		<i class="entypo chevron-small-left"></i> No unread articles, please come back later <i class="entypo chevron-small-right"></i>
	</p>
</div>
<?php else: ?>
<div id="items-read-line"></div>

<div id="items">
	<?php require 'read.php' ?>
</div>
<?php endif ?>

<?php require 'footer.php' ?>

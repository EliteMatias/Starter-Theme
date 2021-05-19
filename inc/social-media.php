<?php $socialMedia = get_theme_mod( 'global_social_media' ); ?>

<?php if ( $socialMedia ): ?>
	<div class="social-media">
		<ul class="social-media-wrapper">
			<?php foreach ($socialMedia as $key => $social): ?>
				<li class="social-media-list">
					<a href="<?php echo $social['account_url'] ?>" target="_blank"><i class="fab <?php echo $social['account']; ?>"></i></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
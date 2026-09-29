<?php
/**
 * What's your colour? — 맛 타일 (네온관이 하나씩 켜지듯 등장, 마우스 따라 스포트라이트)
 */
$flavors = oneam_get_flavors();
?>
<section class="nx-colors" id="flavors">
	<div class="nx-head">
		<h2 class="nx-h3">What&rsquo;s your colour?</h2>
		<p class="nx-meta"><?php echo (int) count( $flavors ); ?> flavours &middot; Slim HYBRID 2ml</p>
	</div>
	<ul class="nx-tiles">
		<?php foreach ( $flavors as $f ) : ?>
			<li class="nx-tile" style="<?php echo oneam_flavor_style( $f ); // phpcs:ignore ?>">
				<a href="<?php echo esc_url( $f['url'] ); ?>" data-cursor="View">
					<span class="nx-tile__glow" aria-hidden="true"></span>
					<span class="nx-tile__img"><img src="<?php echo esc_url( $f['img'] ); ?>" alt="" width="246" height="1400" loading="lazy"></span>
					<span class="nx-tile__foot">
						<span class="nx-tile__name"><?php echo esc_html( $f['name'] ); ?></span>
						<span class="nx-tile__go">Discover</span>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>

<?php
/**
 * 03 — 상품 3종 (유리 카드, 네온 테두리가 회전)
 */
$products = oneam_get_products();
?>
<section class="nx-lines" id="products">
	<span class="nx-num" aria-hidden="true">03</span>
	<div class="nx-head">
		<h2 class="nx-h3">Product lines</h2>
		<p class="nx-meta"><?php echo (int) count( $products ); ?> lines &middot; wholesale only</p>
	</div>
	<div class="nx-cards">
		<?php foreach ( $products as $p ) : ?>
			<article class="nx-card<?php echo 'soon' === $p['status'] ? ' is-soon' : ''; ?>" style="<?php echo oneam_flavor_style( $p ); // phpcs:ignore ?>">
				<div class="nx-card__in">
					<p class="nx-pill"><span class="dot"></span><?php echo 'soon' === $p['status'] ? 'Coming soon' : 'Available now'; ?></p>
					<div class="nx-card__visual"><?php oneam_product_visual( $p, 'nx-card__img' ); ?></div>
					<h3 class="nx-card__name"><?php echo esc_html( $p['name'] ); ?></h3>
					<p class="nx-card__tag"><?php echo esc_html( $p['tag'] ); ?></p>
					<?php if ( ! empty( $p['specs'] ) ) : ?>
						<dl class="nx-card__specs">
							<?php foreach ( $p['specs'] as $k => $v ) : ?>
								<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>
					<?php if ( 'soon' === $p['status'] ) : ?>
						<a class="nx-link nx-link--sm" href="<?php echo esc_url( oneam_signup_url() ); ?>"><span>Get notified</span><i class="nx-circle" aria-hidden="true">&rarr;</i></a>
					<?php else : ?>
						<a class="nx-link nx-link--sm" href="<?php echo esc_url( $p['url'] ); ?>"><span>View product</span><i class="nx-circle" aria-hidden="true">&rarr;</i></a>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

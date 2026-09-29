<?php
/**
 * 04 — Why stock 1AM: 번호 붙은 유리 카드 4개 + 오른쪽 네온 이미지 + 연기
 */
$items = apply_filters(
	'oneam_benefits',
	array(
		array( 'Wholesale pricing', 'Trade pricing for approved accounts, visible as soon as you log in.', '#FF2E4D', '#FFB321' ),
		array( 'Approved retailers only', 'We only work with stores whose business documents we have verified.', '#8A3FFC', '#1E5BFF' ),
		array( 'Ships where it\'s allowed', 'Orders ship only to provinces where our products can be sold.', '#00C2A8', '#16C75A' ),
		array( 'Clear product info', 'Specs, flavours and product details in one place.', '#FFD60A', '#FF8A4D' ),
	)
);
?>
<section class="nx-features" id="why">
	<div class="nx-features__art" aria-hidden="true">
		<img src="<?php echo esc_url( oneam_asset( 'img/neon-scene.webp' ) ); ?>" alt="" width="1672" height="940" loading="lazy">
		<canvas class="nx-smoke" data-smoke="10"></canvas>
	</div>
	<span class="nx-num nx-num--right" aria-hidden="true">04</span>
	<div class="nx-features__body">
		<h2 class="nx-h3">Why stock 1AM</h2>
		<ol class="nx-feats">
			<?php foreach ( $items as $i => $b ) : ?>
				<li class="nx-glass nx-feat" style="--c1:<?php echo esc_attr( $b[2] ); ?>;--c2:<?php echo esc_attr( $b[3] ); ?>">
					<span class="nx-feat__n"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3><?php echo esc_html( $b[0] ); ?></h3>
					<p><?php echo esc_html( $b[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<?php
/**
 * 05 — Our vision / Our promise + 네온관 배경 앞에 떠 있는 제품 두 개
 */
$flavors = oneam_get_flavors();
$pair    = array( $flavors[ min( 1, count( $flavors ) - 1 ) ], $flavors[ min( 11, count( $flavors ) - 1 ) ] );
?>
<section class="nx-vision" id="vision">
	<span class="nx-num nx-num--left" aria-hidden="true">05</span>
	<div class="nx-vision__text">
		<h2 class="nx-h3">The 1AM standard</h2>
		<div class="nx-vision__cols">
			<div>
				<h3 class="nx-sub">Our vision</h3>
				<p class="nx-p"><?php echo esc_html( oneam_opt( 'oneam_vision_text' ) ); ?></p>
			</div>
			<div>
				<h3 class="nx-sub">Our promise</h3>
				<p class="nx-p"><?php echo esc_html( oneam_opt( 'oneam_promise_text' ) ); ?></p>
			</div>
		</div>
		<a class="nx-link" href="<?php echo esc_url( oneam_opt( 'oneam_about_url' ) ); ?>"><span>About us</span><i class="nx-circle" aria-hidden="true">&rarr;</i></a>
	</div>
	<div class="nx-vision__art" aria-hidden="true">
		<span class="nx-tube nx-tube--cyan"></span>
		<span class="nx-tube nx-tube--pink"></span>
		<canvas class="nx-smoke nx-smoke--soft" data-smoke="8"></canvas>
		<?php foreach ( $pair as $i => $f ) : ?>
			<div class="nx-float-slot nx-float-slot--<?php echo (int) $i + 1; ?>"><img class="nx-float" src="<?php echo esc_url( $f['img'] ); ?>" alt="" width="246" height="1400" loading="lazy" style="<?php echo oneam_flavor_style( $f ); // phpcs:ignore ?>"></div>
		<?php endforeach; ?>
	</div>
</section>

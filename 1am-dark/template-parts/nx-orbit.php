<?php
/**
 * 02 — 1AM 제품 공통 특징 (디자인 · 다양한 맛 · 가벼움)
 * 점선 원이 그려지고, 두 디바이스가 V 자로 벌어지며, 특징 점이 하나씩 켜짐
 */
$flavors = oneam_get_flavors();
$a       = $flavors[0];
$b       = $flavors[ min( 3, count( $flavors ) - 1 ) ];
// [제목, 설명, 각도(deg, 12시 = 0), 색] — 'oneam_orbit_points' 필터로 교체 가능
$points = apply_filters(
	'oneam_orbit_points',
	array(
		array( 'Sleek design', 'Slim, clear and made to stand out on the shelf.', -52, '#1ea7ff' ),
		array( 'Many flavours', 'A wide range, from ice to fruit to sweet.', 60, '#ff2e88' ),
		array( 'Lightweight', 'Easy to carry, light in the hand.', 170, '#b6ff3b' ),
	)
);
?>
<section class="nx-orbit" id="device" style="<?php echo oneam_flavor_style( $a ); // phpcs:ignore ?>">
	<div class="nx-orbit__pin">
		<span class="nx-num nx-num--left" aria-hidden="true">02</span>
		<h2 class="nx-h3 nx-orbit__title"><?php echo oneam_rich( str_replace( "\n", ' ', oneam_opt( 'oneam_device_title' ) ) ); // phpcs:ignore ?></h2>
		<div class="nx-orbit__stage">
			<svg class="nx-orbit__ring" viewBox="0 0 200 200" aria-hidden="true"><circle cx="100" cy="100" r="96" pathLength="1"></circle></svg>
			<div class="nx-orbit__disc" aria-hidden="true"></div>
			<img class="nx-orbit__dev nx-orbit__dev--a" src="<?php echo esc_url( $a['img'] ); ?>" alt="1AM Slim HYBRID" width="246" height="1400" loading="lazy" style="<?php echo oneam_flavor_style( $a ); // phpcs:ignore ?>">
			<img class="nx-orbit__dev nx-orbit__dev--b" src="<?php echo esc_url( $b['img'] ); ?>" alt="" width="246" height="1400" loading="lazy" style="<?php echo oneam_flavor_style( $b ); // phpcs:ignore ?>">
			<ul class="nx-orbit__pts">
				<?php foreach ( $points as $p ) : ?>
					<li class="nx-pt<?php echo ( $p[2] > 0 && $p[2] < 180 ) ? '' : ' is-left'; ?>" style="--a:<?php echo (int) $p[2]; ?>deg;--pc:<?php echo esc_attr( $p[3] ); ?>">
						<i></i><span><b><?php echo esc_html( $p[0] ); ?></b><?php echo esc_html( $p[1] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<ul class="nx-orbit__list">
			<?php foreach ( $points as $p ) : ?>
				<li style="--pc:<?php echo esc_attr( $p[3] ); ?>"><i></i><b><?php echo esc_html( $p[0] ); ?></b><span><?php echo esc_html( $p[1] ); ?></span></li>
			<?php endforeach; ?>
		</ul>
		<dl class="nx-orbit__specs">
			<?php for ( $n = 1; $n <= 3; $n++ ) : ?>
				<div>
					<dt><?php echo esc_html( oneam_opt( "oneam_spec_{$n}_label" ) ); ?></dt>
					<dd data-count="<?php echo esc_attr( oneam_opt( "oneam_spec_{$n}_num" ) ); ?>"><?php echo esc_html( oneam_opt( "oneam_spec_{$n}_num" ) ); ?></dd>
				</div>
			<?php endfor; ?>
		</dl>
	</div>
</section>

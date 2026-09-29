<?php
/**
 * 02 — 궤도 다이어그램: 점선 원이 그려지고, 두 디바이스가 V 자로 벌어지며, 특징 점이 하나씩 켜짐
 */
$flavors = oneam_get_flavors();
$a       = $flavors[0];
$b       = $flavors[ min( 3, count( $flavors ) - 1 ) ];
// [라벨, 각도(deg, 12시 = 0), 색]
$points = apply_filters(
	'oneam_orbit_points',
	array(
		array( 'Crystal shell', -38, '#1ea7ff' ),
		array( 'Gradient core', 42, '#ff8a1f' ),
		array( 'Soft mouthpiece', 100, '#b6ff3b' ),
		array( '2ml e-liquid', 150, '#8b8b9a' ),
		array( 'Slim HYBRID body', -118, '#d23cff' ),
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
					<li class="nx-pt<?php echo ( $p[1] > 0 && $p[1] < 180 ) ? '' : ' is-left'; ?>" style="--a:<?php echo (int) $p[1]; ?>deg;--pc:<?php echo esc_attr( $p[2] ); ?>">
						<i></i><span><?php echo esc_html( $p[0] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
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

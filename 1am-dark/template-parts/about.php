<?php
/**
 * Flavour line-up + short About.
 * The devices drop in as one neat, tightly packed row, spread apart on scroll,
 * then keep gliding left like a ticker (hover pauses it and shows the flavour).
 * Neon glows pop open behind them like flowers, then the About text appears.
 */
$flavors = oneam_get_flavors();
// 꽃처럼 퍼지는 네온 원 (다크 배경 위 글로우): [left %, top %, size vmin, colour]
$blooms = array(
	array( 8, 22, 26, '#ff2e88' ),
	array( 22, 62, 18, '#ff8a1f' ),
	array( 34, 18, 14, '#9b3cff' ),
	array( 47, 48, 34, '#ff1f6b' ),
	array( 60, 20, 20, '#39ff88' ),
	array( 70, 64, 24, '#9b3cff' ),
	array( 84, 28, 28, '#ff8a1f' ),
	array( 93, 60, 16, '#1ea7ff' ),
	array( 14, 84, 14, '#39ff88' ),
	array( 78, 86, 12, '#ff2e88' ),
);
?>
<section class="about" id="about">
	<div class="row" id="row">
		<div class="row__glow" aria-hidden="true">
			<?php foreach ( $blooms as $b ) : ?>
				<span class="bloom" style="left:<?php echo (int) $b[0]; ?>%;top:<?php echo (int) $b[1]; ?>%;--s:<?php echo (int) $b[2]; ?>vmin;--c:<?php echo esc_attr( $b[3] ); ?>"></span>
			<?php endforeach; ?>
		</div>

		<div class="row__viewport">
			<ul class="row__track" aria-label="<?php echo esc_attr( count( $flavors ) . ' Slim HYBRID flavours' ); ?>">
				<?php for ( $set = 0; $set < 3; $set++ ) : ?>
					<?php foreach ( $flavors as $f ) : ?>
						<li class="row__item<?php echo 1 === $set ? ' is-main' : ' is-clone'; ?>" <?php echo 1 === $set ? '' : 'aria-hidden="true"'; ?> style="<?php echo oneam_flavor_style( $f ); // phpcs:ignore ?>">
							<img src="<?php echo esc_url( $f['img'] ); ?>" alt="<?php echo 1 === $set ? esc_attr( $f['name'] ) : ''; ?>" width="246" height="1400" loading="lazy">
							<span class="row__name"><?php echo esc_html( $f['name'] ); ?></span>
						</li>
					<?php endforeach; ?>
				<?php endfor; ?>
			</ul>
		</div>

		<div class="about__intro">
			<p class="eyebrow">About 1AM</p>
			<h2 class="about__title"><?php echo oneam_rich( oneam_opt( 'oneam_about_title' ) ); // phpcs:ignore ?></h2>
			<p class="about__text"><?php echo esc_html( oneam_opt( 'oneam_about_text' ) ); ?></p>
			<a class="btn btn--round" href="<?php echo esc_url( oneam_opt( 'oneam_about_url' ) ); ?>"><span>About</span><span class="btn__arrow" aria-hidden="true">&rarr;</span></a>
		</div>
	</div>
</section>

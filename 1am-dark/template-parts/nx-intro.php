<?php
/**
 * 첫 화면 — 네온 이미지(나중에 영상) 전체 배경 + 큰 제목 + 오른쪽 유리 카드 맛 슬라이더.
 * 배경 우선순위: 사용자 정의하기 > 1AM Settings > Home video(MP4) → 테마 assets/video/brand.mp4 → assets/img/neon-scene.webp
 */
$mp4    = oneam_opt( 'oneam_video_mp4' );
$poster = oneam_opt( 'oneam_video_poster' );
if ( ! $mp4 && file_exists( get_template_directory() . '/assets/video/brand.mp4' ) ) {
	$mp4 = oneam_asset( 'video/brand.mp4' );
}
$scene   = $poster ? $poster : oneam_asset( 'img/neon-scene.webp' );
$flavors = oneam_get_flavors();
$first   = $flavors[0];
$words   = preg_split( '/\s+/u', trim( str_replace( "\n", ' ', oneam_opt( 'oneam_intro_title' ) ) ) );
?>
<section class="nx-intro" id="intro" style="<?php echo oneam_flavor_style( $first ); // phpcs:ignore ?>">
	<div class="nx-intro__media" aria-hidden="true">
		<?php if ( $mp4 ) : ?>
			<video class="nx-intro__bg" poster="<?php echo esc_url( $scene ); ?>" autoplay muted loop playsinline preload="auto">
				<source src="<?php echo esc_url( $mp4 ); ?>" type="video/mp4">
			</video>
		<?php else : ?>
			<img class="nx-intro__bg" src="<?php echo esc_url( $scene ); ?>" alt="" width="1672" height="940" fetchpriority="high">
		<?php endif; ?>
		<canvas class="nx-smoke" data-smoke="14"></canvas>
		<div class="nx-intro__shade"></div>
	</div>

	<div class="nx-intro__copy">
		<p class="nx-kicker"><span class="dot"></span><?php echo esc_html( oneam_opt( 'oneam_intro_text' ) ); ?></p>
		<h1 class="nx-intro__title">
			<?php
			$in_em = false;
			foreach ( $words as $w ) :
				$starts = 0 === strpos( $w, '*' );
				$em     = $in_em || $starts;
				$in_em  = $em && ! preg_match( '/\*$/u', $starts ? substr( $w, 1 ) : $w );
				?>
				<span class="nx-word<?php echo $em ? ' is-em' : ''; ?>"><?php echo oneam_split( trim( $w, '*' ) ); // phpcs:ignore ?></span>
			<?php endforeach; ?>
		</h1>
		<div class="nx-intro__btns">
			<?php oneam_member_cta(); ?>
		</div>
	</div>

	<aside class="nx-glass nx-slider" id="nx-slider" aria-label="Flavours" aria-roledescription="carousel">
		<p class="nx-slider__idx"><b id="nx-idx">01</b> / <?php echo esc_html( str_pad( (string) count( $flavors ), 2, '0', STR_PAD_LEFT ) ); ?></p>
		<div class="nx-slider__stage">
			<?php foreach ( $flavors as $i => $f ) : ?>
				<a class="nx-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" href="<?php echo esc_url( $f['url'] ); ?>" data-c1="<?php echo esc_attr( $f['c1'] ); ?>" data-c2="<?php echo esc_attr( $f['c2'] ); ?>" data-name="<?php echo esc_attr( $f['name'] ); ?>" data-desc="<?php echo esc_attr( $f['desc'] ); ?>" <?php echo 0 === $i ? '' : 'tabindex="-1" aria-hidden="true"'; ?>>
					<img src="<?php echo esc_url( $f['img'] ); ?>" alt="<?php echo esc_attr( $f['name'] ); ?>" width="246" height="1400" <?php echo $i > 1 ? 'loading="lazy"' : ''; ?>>
				</a>
			<?php endforeach; ?>
			<button type="button" class="nx-arrow nx-arrow--prev" data-nx="prev" aria-label="Previous flavour">&larr;</button>
			<button type="button" class="nx-arrow nx-arrow--next" data-nx="next" aria-label="Next flavour">&rarr;</button>
		</div>
		<h2 class="nx-slider__name" id="nx-name"><?php echo esc_html( $first['name'] ); ?></h2>
		<p class="nx-slider__desc" id="nx-desc"><?php echo esc_html( $first['desc'] ); ?></p>
		<a class="nx-link nx-link--sm" id="nx-go" href="<?php echo esc_url( $first['url'] ); ?>"><i class="nx-circle" aria-hidden="true">&rarr;</i><span>Discover</span></a>
		<div class="nx-slider__bar"><span></span></div>
	</aside>

	<div class="nx-intro__foot">
		<a class="nx-scroll" href="#hello"><i aria-hidden="true"></i><span>Scroll to explore</span></a>
	</div>
</section>

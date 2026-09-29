<?php
/**
 * 맛 배너 — 15가지 맛을 한 장의 네온 이미지로 (맛 목록은 상품 페이지에서)
 */
$flavors = oneam_get_flavors();
$line    = oneam_get_products()[0];
?>
<section class="nx-banner" id="flavors">
	<div class="nx-banner__media" aria-hidden="true">
		<img src="<?php echo esc_url( oneam_asset( 'img/scene-flatlay.webp' ) ); ?>" alt="" width="1938" height="812" loading="lazy">
	</div>
	<div class="nx-banner__copy">
		<p class="nx-meta"><?php echo esc_html( $line['name'] ); ?></p>
		<h2 class="nx-banner__title"><span data-count="<?php echo (int) count( $flavors ); ?>"><?php echo (int) count( $flavors ); ?></span> <em>flavours.</em></h2>
		<a class="nx-link" href="<?php echo esc_url( $line['url'] ); ?>"><span>See all flavours</span><i class="nx-circle" aria-hidden="true">&rarr;</i></a>
	</div>
</section>

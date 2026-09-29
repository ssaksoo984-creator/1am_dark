/* ==========================================================================
   1AM Dark — home.js (메인 페이지 전용 인터랙션)
   네온 깜빡임 등장 · 유리 카드 슬라이더 · 연기 캔버스 · 궤도 다이어그램 · 스크롤 연출
   ========================================================================== */
(function () {
	'use strict';

	var gsap = window.gsap;
	var ST = window.ScrollTrigger;
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	if (!gsap || !ST) return;

	function onReady(fn) {
		if (window.ONEAM_READY) fn();
		else document.addEventListener('oneam:ready', fn, { once: true });
	}

	/* ------------------------------------------------------------ 연기 캔버스 */
	function smoke(canvas) {
		var ctx = canvas.getContext('2d');
		if (!ctx) return;
		var host = canvas.parentElement;
		var n = +canvas.dataset.smoke || 10;
		var strength = +canvas.dataset.strength || 1;
		var dpr = Math.min(window.devicePixelRatio || 1, 1.5);
		var w = 0, h = 0, parts = [], running = false, color = '#9b3cff';

		// 부드러운 원형 스프라이트 (한 번만 그림)
		var sprite = document.createElement('canvas');
		sprite.width = sprite.height = 256;
		var sctx = sprite.getContext('2d');
		var g = sctx.createRadialGradient(128, 128, 0, 128, 128, 128);
		g.addColorStop(0, 'rgba(255,255,255,.55)');
		g.addColorStop(.4, 'rgba(255,255,255,.18)');
		g.addColorStop(1, 'rgba(255,255,255,0)');
		sctx.fillStyle = g;
		sctx.fillRect(0, 0, 256, 256);

		function resize() {
			w = host.clientWidth; h = host.clientHeight;
			canvas.width = w * dpr; canvas.height = h * dpr;
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
		}
		function spawn(p, init) {
			p.x = Math.random() * w;
			p.y = init ? Math.random() * h : h + 100;
			p.r = (.25 + Math.random() * .45) * Math.max(w, h) * .5;
			p.vx = (Math.random() - .5) * 12;
			p.vy = -(6 + Math.random() * 14);
			p.a = Math.min(.5, (.05 + Math.random() * .09) * strength);
			p.rot = Math.random() * Math.PI;
			p.vr = (Math.random() - .5) * .08;
			p.tint = Math.random() < .5;
			return p;
		}
		for (var i = 0; i < n; i++) parts.push(spawn({}, true));

		var last = 0;
		function frame(t) {
			if (!running) return;
			var dt = Math.min(.05, (t - last) / 1000 || 0);
			last = t;
			ctx.clearRect(0, 0, w, h);
			color = getComputedStyle(host).getPropertyValue('--c1').trim() || color;
			parts.forEach(function (p) {
				p.x += p.vx * dt; p.y += p.vy * dt; p.rot += p.vr * dt;
				if (p.y < -p.r) spawn(p, false);
				ctx.save();
				ctx.globalAlpha = p.a;
				ctx.translate(p.x, p.y);
				ctx.rotate(p.rot);
				ctx.scale(1.6, 1);
				ctx.drawImage(sprite, -p.r / 2, -p.r / 2, p.r, p.r);
				ctx.restore();
			});
			// 맛 컬러로 물들이기
			ctx.globalCompositeOperation = 'source-atop';
			ctx.globalAlpha = .55;
			ctx.fillStyle = color;
			ctx.fillRect(0, 0, w, h);
			ctx.globalCompositeOperation = 'source-over';
			ctx.globalAlpha = 1;
			requestAnimationFrame(frame);
		}
		resize();
		window.addEventListener('resize', resize);
		if (reduce) { running = true; frame(0); running = false; return; }
		new IntersectionObserver(function (es) {
			var on = es[0].isIntersecting;
			if (on && !running) { running = true; last = performance.now(); requestAnimationFrame(frame); }
			running = on;
		}).observe(host);
	}
	$$('.nx-smoke').forEach(smoke);

	/* ---------------------------------------------------------- 네온 깜빡임 */
	// 네온관이 켜지듯: 몇 번 깜빡이다가 켜짐
	function flickerIn(els, opts) {
		opts = opts || {};
		var tl = gsap.timeline({ delay: opts.delay || 0 });
		els.forEach(function (el) {
			var at = Math.random() * (opts.spread || .8);
			tl.set(el, { opacity: 0 }, 0)
				.to(el, { opacity: 1, duration: .04 }, at)
				.to(el, { opacity: .15, duration: .05 }, at + .07)
				.to(el, { opacity: 1, duration: .04 }, at + .16)
				.to(el, { opacity: .4, duration: .04 }, at + .24)
				.to(el, { opacity: 1, duration: .1 }, at + .3);
		});
		return tl;
	}

	/* ----------------------------------------------------------------- Intro */
	var slider = (function () {
		var root = $('#intro');
		if (!root) return { start: function () {} };
		var card = $('#nx-slider');
		var slides = $$('.nx-slide', card);
		var dots = $$('.nx-dots button', root);
		var idx = $('#nx-idx'), name = $('#nx-name'), desc = $('#nx-desc'), go = $('#nx-go');
		var bar = $('.nx-slider__bar span', card);
		var cur = 0, busy = false, timer;
		var DUR = 4.5;

		function paint(el, d, dur) {
			gsap.to(el, { '--c1': d.c1, '--c2': d.c2, duration: dur, ease: 'power2.out', overwrite: 'auto' });
		}
		function show(next, dir) {
			if (busy || next === cur) return;
			busy = true;
			dir = dir || (next > cur ? 1 : -1);
			var from = slides[cur], to = slides[next], d = to.dataset;
			paint(root, d, .9);
			paint(document.body, d, .9);
			// 3D 로 뒤집히며 교체
			gsap.to($('img', from), { rotationY: 90 * dir, opacity: 0, duration: .45, ease: 'power3.in', onComplete: function () {
				from.classList.remove('is-active');
				from.setAttribute('aria-hidden', 'true'); from.tabIndex = -1;
			} });
			to.classList.add('is-active');
			to.removeAttribute('aria-hidden'); to.removeAttribute('tabindex');
			gsap.fromTo($('img', to), { rotationY: -90 * dir, opacity: 0, scale: .9 }, { rotationY: 0, opacity: 1, scale: 1, duration: .9, delay: .35, ease: 'expo.out', onComplete: function () { busy = false; } });
			gsap.to([name, desc], { opacity: 0, y: -8, duration: .2, onComplete: function () {
				name.textContent = d.name;
				desc.textContent = d.desc;
				go.href = to.href;
				idx.textContent = String(next + 1).padStart(2, '0');
				gsap.to([name, desc], { opacity: 1, y: 0, duration: .5, stagger: .05, ease: 'power3.out' });
			} });
			dots.forEach(function (b, i) { b.classList.toggle('is-active', i === next); });
			cur = next;
			restart();
		}
		function next() { show((cur + 1) % slides.length, 1); }
		function prev() { show((cur - 1 + slides.length) % slides.length, -1); }
		function restart() {
			if (timer) timer.kill();
			timer = gsap.fromTo(bar, { scaleX: 0 }, { scaleX: 1, duration: DUR, ease: 'none', onComplete: next });
		}
		$$('[data-nx]', card).forEach(function (b) { b.addEventListener('click', function () { b.dataset.nx === 'next' ? next() : prev(); }); });
		dots.forEach(function (b) { b.addEventListener('click', function () { show(+b.dataset.idx); }); });
		card.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') next();
			if (e.key === 'ArrowLeft') prev();
		});
		card.addEventListener('pointerenter', function () { timer && timer.pause(); });
		card.addEventListener('pointerleave', function () { timer && timer.resume(); });
		ST.create({ trigger: root, start: 'top bottom', end: 'bottom top', onToggle: function (s) { timer && (s.isActive ? timer.resume() : timer.pause()); } });

		// 배경: 천천히 줌인(켄 번즈) + 마우스 패럴랙스
		var bg = $('.nx-intro__bg', root);
		if (!reduce) {
			gsap.fromTo(bg, { scale: 1.12 }, { scale: 1, duration: 14, ease: 'sine.out' });
			if (finePointer) {
				var bx = gsap.quickTo(bg, 'x', { duration: 1.4, ease: 'power3' });
				var by = gsap.quickTo(bg, 'y', { duration: 1.4, ease: 'power3' });
				var cx = gsap.quickTo(card, 'x', { duration: 1, ease: 'power3' });
				var cy = gsap.quickTo(card, 'y', { duration: 1, ease: 'power3' });
				root.addEventListener('pointermove', function (e) {
					var px = e.clientX / window.innerWidth - .5, py = e.clientY / window.innerHeight - .5;
					bx(px * -30); by(py * -20); cx(px * 18); cy(py * 14);
				});
			}
			// 스크롤하면 배경은 느리게, 글자는 빠르게 올라감
			gsap.timeline({ scrollTrigger: { trigger: root, start: 'top top', end: 'bottom top', scrub: true } })
				.to('.nx-intro__media', { yPercent: 18 }, 0)
				.to('.nx-intro__copy', { yPercent: -30, opacity: 0 }, 0)
				.to(card, { yPercent: -18, opacity: 0 }, 0);
		}

		return {
			start: function () {
				if (reduce) { restart(); return; }
				var chars = $$('.nx-intro__title .ch', root);
				var tl = gsap.timeline({ onComplete: restart });
				tl.from('.nx-kicker', { opacity: 0, y: 10, duration: .6 }, 0)
					.add(flickerIn(chars, { spread: .7 }), .1)
					.from('.nx-intro__btns > *', { opacity: 0, y: 20, stagger: .08, duration: .7, ease: 'expo.out' }, .7)
					.from(card, { opacity: 0, x: 60, rotationY: -25, transformPerspective: 900, duration: 1.2, ease: 'expo.out' }, .3)
					.from($('.nx-slide.is-active img', card), { y: 120, rotation: 40, opacity: 0, duration: 1.3, ease: 'expo.out' }, .55)
					.from('.nx-intro__foot > *', { opacity: 0, y: 16, stagger: .1, duration: .6 }, .9);
			}
		};
	})();

	if (reduce) {
		onReady(slider.start);
		return;
	}

	/* ------------------------------------------------------------ 01 Hello */
	(function () {
		var root = $('#hello');
		if (!root) return;
		var dev = $('.nx-hello__device', root);
		gsap.timeline({ scrollTrigger: { trigger: root, start: 'top 85%', end: 'bottom 30%', scrub: 1 } })
			.fromTo(dev, { yPercent: 60, xPercent: 10, rotation: -70, opacity: 0 }, { yPercent: 0, rotation: -26, opacity: 1, ease: 'power2.out', duration: .6 }, 0)
			.to(dev, { yPercent: -10, rotation: -16, ease: 'none', duration: .4 }, .6);
		gsap.from($$('.nx-hello__words span', root), { xPercent: -12, opacity: 0, stagger: .08, duration: 1.2, ease: 'expo.out', scrollTrigger: { trigger: root, start: 'top 75%' } });
		gsap.from($$('.nx-hello__copy > :not(.nx-h2)', root), { y: 30, opacity: 0, stagger: .1, duration: 1, ease: 'expo.out', scrollTrigger: { trigger: '.nx-hello__copy', start: 'top 80%' } });
		gsap.fromTo($('.nx-num', root), { yPercent: 40 }, { yPercent: -40, ease: 'none', scrollTrigger: { trigger: root, start: 'top bottom', end: 'bottom top', scrub: true } });
	})();

	/* ------------------------------------------------------------ 맛 배너 */
	(function () {
		var root = $('#flavors');
		if (!root) return;
		gsap.fromTo($('.nx-banner__media img', root), { yPercent: -12, scale: 1.08 }, { yPercent: 0, scale: 1, ease: 'none', scrollTrigger: { trigger: root, start: 'top bottom', end: 'bottom top', scrub: true } });
		gsap.from($$('.nx-banner__copy > *', root), { y: 30, opacity: 0, stagger: .1, duration: 1, ease: 'expo.out', scrollTrigger: { trigger: root, start: 'top 60%' } });
	})();

	/* ------------------------------------------------------------ 02 Orbit */
	(function () {
		var root = $('#device');
		if (!root) return;
		var ring = $('.nx-orbit__ring', root);
		var a = $('.nx-orbit__dev--a', root), b = $('.nx-orbit__dev--b', root);
		var pts = $$('.nx-pt', root);
		var tl = gsap.timeline({ scrollTrigger: { trigger: root, start: 'top top', end: '+=180%', pin: '.nx-orbit__pin', scrub: 1 } });
		tl.from('.nx-orbit__title', { opacity: 0, y: 30, duration: .3 }, 0)
			.fromTo(ring, { '--p': '0%' }, { '--p': '100%', duration: 1, ease: 'none' }, 0)
			.from('.nx-orbit__disc', { scale: 0, duration: .6, ease: 'back.out(1.6)' }, .1)
			.fromTo([a, b], { rotate: 0, y: 120, opacity: 0 }, { y: 0, opacity: 1, duration: .5 }, .2)
			.to(a, { rotate: -24, xPercent: -40, duration: .6, ease: 'power2.inOut' }, .7)
			.to(b, { rotate: 24, xPercent: 40, duration: .6, ease: 'power2.inOut' }, .7);
		pts.forEach(function (p, i) {
			tl.from($('i', p), { scale: 0, duration: .2, ease: 'back.out(3)' }, .8 + i * .14)
				.from($('span', p), { opacity: 0, x: p.classList.contains('is-left') ? 20 : -20, duration: .2 }, .85 + i * .14);
		});
		tl.from('.nx-orbit__specs > div', { opacity: 0, y: 20, stagger: .08, duration: .3 }, 1.4)
			.to(root, { '--c1': b.style.getPropertyValue('--c1') || '#1ea7ff', duration: .6 }, 1.2)
			.to({}, { duration: .3 });
	})();

	/* ----------------------------------------------------- 03 Product lines */
	(function () {
		var cards = $$('.nx-card');
		if (!cards.length) return;
		gsap.from(cards, { y: 120, rotationX: -35, opacity: 0, transformOrigin: '50% 100%', stagger: .12, duration: 1.3, ease: 'expo.out', scrollTrigger: { trigger: '.nx-cards', start: 'top 80%' } });
		if (finePointer) {
			cards.forEach(function (c) {
				c.addEventListener('pointermove', function (e) {
					var r = c.getBoundingClientRect();
					gsap.to(c, { rotationY: ((e.clientX - r.left) / r.width - .5) * 10, rotationX: -((e.clientY - r.top) / r.height - .5) * 10, duration: .5, ease: 'power3' });
				});
				c.addEventListener('pointerleave', function () { gsap.to(c, { rotationX: 0, rotationY: 0, duration: .8, ease: 'elastic.out(1, .5)' }); });
			});
		}
		gsap.fromTo('.nx-lines .nx-num', { xPercent: 30 }, { xPercent: -10, ease: 'none', scrollTrigger: { trigger: '.nx-lines', start: 'top bottom', end: 'bottom top', scrub: true } });
	})();

	/* -------------------------------------------------------- 04 Features */
	(function () {
		var root = $('#why');
		if (!root) return;
		gsap.fromTo($('.nx-features__art img', root), { scale: 1.1 }, { scale: 1, ease: 'none', scrollTrigger: { trigger: root, start: 'top bottom', end: 'bottom top', scrub: true } });
		gsap.from($$('.nx-feat', root), { y: 50, opacity: 0, stagger: .08, duration: .9, ease: 'expo.out', clearProps: 'transform,opacity', scrollTrigger: { trigger: '.nx-feats', start: 'top 85%' } });
	})();

	/* ---------------------------------------------------------- 05 Vision */
	(function () {
		var root = $('#vision');
		if (!root) return;
		var f = $$('.nx-float', root);
		gsap.set(f, { rotation: function (i) { return i ? 12 : -14; } });
		f.forEach(function (el, i) {
			gsap.to(el, { y: i ? -14 : 14, rotation: i ? 9 : -11, duration: 3 + i, repeat: -1, yoyo: true, ease: 'sine.inOut' });
		});
		gsap.fromTo($$('.nx-float-slot', root), { xPercent: function (i) { return i ? 60 : -60; }, opacity: 0 }, { xPercent: 0, opacity: 1, ease: 'power2.out', scrollTrigger: { trigger: root, start: 'top 80%', end: 'center center', scrub: 1 } });
		var finale = $('#finale') || root;
		ST.create({ trigger: root, start: 'top 60%', once: true, onEnter: function () { finale.classList.add('is-lit'); } });
		gsap.from($$('.nx-vision__text > *', root), { y: 30, opacity: 0, stagger: .1, duration: 1, ease: 'expo.out', scrollTrigger: { trigger: root, start: 'top 70%' } });
	})();

	/* ----------------------------------------------------------------- CTA */
	(function () {
		var root = $('#wholesale');
		if (!root) return;
		var title = $('[data-neon]', root);
		gsap.fromTo('.nx-cta__line', { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: root, start: 'top 80%', end: 'center center', scrub: true } });
		ST.create({ trigger: title, start: 'top 80%', once: true, onEnter: function () { flickerIn([title], { spread: 0 }); } });
		gsap.set(title, { opacity: 0 });
	})();

	onReady(function () {
		slider.start();
		ST.refresh();
	});
})();

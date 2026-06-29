/**
 * JEDDA Product Page V2 — Gallery Component
 *
 * Milestone: Gallery V2
 * Scope: product pages with body.jedda-pdp-v2 only.
 *
 * Responsibilities:
 * - Honour the browser kill switch.
 * - Inject a minimal mobile image counter below the gallery.
 * - Update the counter on Slick slide change.
 *
 * Rules:
 * - No MutationObserver.
 * - No cart, checkout, payment, shipping, stock, or order logic.
 * - Event-based only: DOMContentLoaded, pageshow, Slick afterChange.
 */

(function () {
	'use strict';

	/* ----------------------------------------------------------
	   Kill switch
	   ---------------------------------------------------------- */

	var config = window.JEDDA_PDP_V2 || {};
	var killSwitchKey = config.killSwitchKey || 'jedda:disable-pdp-v2';

	try {
		if (window.localStorage && window.localStorage.getItem(killSwitchKey) === '1') {
			return;
		}
	} catch (e) {
		// localStorage blocked — continue
	}

	/* ----------------------------------------------------------
	   Guard: only run on V2-enabled product pages
	   ---------------------------------------------------------- */

	if (!document.body.classList.contains('jedda-pdp-v2')) {
		return;
	}

	/* ----------------------------------------------------------
	   Mobile gallery counter
	   Injected below .de-product-single__images-left-philo.
	   Listens to Slick afterChange on the main image slider.
	   Shows "1 / 6" format. Visible only at ≤768px via CSS.
	   ---------------------------------------------------------- */

	function initGalleryCounter() {
		var $ = window.jQuery;
		if (!$) {
			return;
		}

		var $mainSlider = $('.de-product-single__images--philo-inner');
		if (!$mainSlider.length) {
			return;
		}

		var galleryCol = document.querySelector('.de-product-single__images-left-philo');
		if (!galleryCol) {
			return;
		}

		// Prevent double-init on pageshow re-fires
		if (galleryCol.querySelector('.jedda-gallery-counter')) {
			return;
		}

		function buildCounter(slideCount) {
			if (!slideCount || slideCount < 2) {
				return;
			}

			var counter = document.createElement('div');
			counter.className = 'jedda-gallery-counter';
			counter.setAttribute('aria-hidden', 'true');
			counter.textContent = '1 / ' + slideCount;
			galleryCol.appendChild(counter);

			$mainSlider.on('afterChange.jeddaGalleryCounter', function (event, slick, currentSlide) {
				counter.textContent = (currentSlide + 1) + ' / ' + slideCount;
			});
		}

		// Slick may already be initialised when this deferred script runs
		if ($mainSlider.hasClass('slick-initialized')) {
			var instance = $mainSlider[0] && $mainSlider[0].slick;
			var count = instance
				? instance.slideCount
				: $mainSlider.find('.slick-slide:not(.slick-cloned)').length;
			buildCounter(count);
		} else {
			// Hook init event before Slick fires it
			$mainSlider.on('init.jeddaGalleryCounter', function (event, slick) {
				buildCounter(slick.slideCount);
			});
		}
	}

	/* ----------------------------------------------------------
	   Lifecycle hooks
	   ---------------------------------------------------------- */

	function onReady() {
		initGalleryCounter();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', onReady);
	} else {
		onReady();
	}

	// Back-forward cache restore
	window.addEventListener('pageshow', function (e) {
		if (e.persisted) {
			onReady();
		}
	});

}());

(function () {
	'use strict';

	var config = window.JEDDA_PDP_V2 || {};
	var killSwitchKey = config.killSwitchKey || 'jedda:disable-pdp-v2';

	try {
		if (window.localStorage && window.localStorage.getItem(killSwitchKey) === '1') {
			document.documentElement.classList.add('jedda-pdp-v2-disabled');
			if (document.body) {
				document.body.classList.remove('jedda-pdp-v2');
			}
			return;
		}
	} catch (error) {
		// Continue if storage is unavailable.
	}

	function closestForm(target) {
		if (!target || !target.closest) {
			return null;
		}

		return target.closest('form.cart');
	}

	function updateSelectionState(form) {
		if (!form) {
			return;
		}

		var selects = Array.prototype.slice.call(form.querySelectorAll('select[name^="attribute_"]'));
		var hasSelection = selects.some(function (select) {
			return !!select.value;
		});
		var isComplete = selects.length > 0 && selects.every(function (select) {
			return !!select.value;
		});

		form.classList.toggle('jedda-pdp-v2-has-selection', hasSelection);
		form.classList.toggle('jedda-pdp-v2-complete-selection', isComplete);
	}

	function initForm(form) {
		if (!form || form.dataset.jeddaPdpV2Ready === '1') {
			return;
		}

		form.dataset.jeddaPdpV2Ready = '1';
		updateSelectionState(form);
	}

	function init() {
		if (!document.body || !document.body.classList.contains('jedda-pdp-v2')) {
			return;
		}

		document.body.dataset.jeddaPdpV2 = 'active';

		Array.prototype.forEach.call(document.querySelectorAll('form.cart'), initForm);
	}

	document.addEventListener('change', function (event) {
		var target = event.target;

		if (target && target.matches && target.matches('select[name^="attribute_"]')) {
			updateSelectionState(closestForm(target));
		}
	}, true);

	document.addEventListener('click', function (event) {
		var option = event.target && event.target.closest
			? event.target.closest('.variable-item, .button-variable-item, .color-variable-item')
			: null;

		if (option) {
			window.setTimeout(function () {
				updateSelectionState(closestForm(option));
			}, 0);
		}
	}, true);

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, { once: true });
	} else {
		init();
	}

	window.addEventListener('pageshow', init);
}());

/**
 * Affix breakpoint
 * @name NAVBAR_HIDE
 * @memberOf moduleScroll
 * @constant
 * @type {number}
 */
const NAVBAR_HIDE = 20;

/**
 * Affix class name
 * @name AFFIX_CLASS
 * @memberOf moduleScroll
 * @constant
 * @type {string}
 */
const AFFIX_CLASS = 'affix';

/**
 * Affix navbar
 * @constructor moduleScroll
 * @param  {HTMLElement} navbar [description]
 */
function Affix(navbar, options) {
	'use strict';

	if (!navbar) {
		return console.warn('Affix: navbar element not found.')
	}

	options = options || {};

	this.threshold = options.threshold ? options.threshold : NAVBAR_HIDE;
	this.affixClass = options.affixClass ? options.affixClass : AFFIX_CLASS;

	this.navbarAffix = false;
	this.affix = affix.bind(this);

	affix.call(this);

	function _setAffix(bool) {
		let action = bool ? 'add' : 'remove';
		this.navbarAffix = bool;
		navbar.classList[action](this.affixClass);
	}

	function affix() {
		if (window.scrollY > this.threshold && !this.navbarAffix)
			_setAffix.call(this, true);
		if (window.scrollY <= this.threshold && this.navbarAffix)
			_setAffix.call(this, false);
	}

	return this;
}

/** Affix */
export default function (navbar, options) {
	const module = new Affix(navbar, options);

	window.addEventListener('scroll', module.affix);
	return function () {
		window.removeEventListener('scroll', module.affix);
	}
}
/**
 * Add a function to fire when DOM is loaded
 * @function
 * @name onDomContentLoaded
 * @memberof FunctionsIndex
 * @param {function} cb Callback function to execute when DOM is ready
 */
export function onDomContentLoaded(cb) {
	/**
	 * Set DOMLoaded variable when DOM has loaded
	 */
	let loop = setInterval(() => {
		if (document.readyState === 'complete' || document.readyState === 'interactive') {
			cb();
			clearInterval(loop);
		}
	}, 10);
}
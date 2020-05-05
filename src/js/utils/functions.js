/**
 * Add a function to fire when DOM is loaded
 * @function
 * @name onDomContentLoaded
 * @memberof FunctionsIndex
 * @return {function} 
 */
export function onDomContentLoaded() {

	/**
	 * Set DOMLoaded variable when DOM has loaded
	 */
	document.addEventListener('DOMContentLoaded', ( ) => {
		window.DOMLoaded = true;
	});

	/**
	 * Add a function to fire when DOM is loaded
	 * @name FunctionsIndex~onDomContentLoadedFn
	 * @param {DomLoadedCallback} cb - Callback function
	 */
	return (cb) => {
		if (window.DOMLoaded) cb()
		else document.addEventListener('DOMContentLoaded', cb);
	}
	/**
	 * Function to call on DOMContentLoaded
	 * @callback DomLoadedCallback
	 */
}
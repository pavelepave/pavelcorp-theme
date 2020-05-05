import { onDomContentLoaded } from './functions';
import(/*webpackChunkName: "aos-css"*/"aos/dist/aos.css");

const DOMLoader = onDomContentLoaded();

/**
 * Animate on scroll
 */
DOMLoader(() => {
	import(/*webpackChunkName: "aos-js"*/'aos').then(({default: AOS}) => {
		AOS.init({});
	});
});

// Style
import './scss/header.scss'

import affixElement from './js/utils/affixElement';
import { onDomContentLoaded } from './js/utils/functions';

/**
 * Navbar DOM id
 * @type {String}
 */
const NAVBAR_ID = 'SiteHeader';


onDomContentLoaded(() => {
	const navbar = document.getElementById(NAVBAR_ID);
	const destroyAffixNavbar = affixElement(navbar, {threshold: 20, affixClass: 'AffixNavbar'});
});
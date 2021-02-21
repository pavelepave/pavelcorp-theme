// Style
import './scss/header.scss'

import affixElement from './js/utils/affixElement';
import { onDomContentLoaded } from './js/utils/functions';

/**
 * Navbar DOM id
 * @type {String}
 */
// const NAVBAR_ID = 'SiteHeader';


onDomContentLoaded(() => {
  for (let i = 0; i < document.images.length; i++) {
    const img = document.images[i];

    if( img.dataset.srcset ) {
      img.srcset = img.dataset.srcset;
      delete img.dataset.srcset;
    }
    
  }
});
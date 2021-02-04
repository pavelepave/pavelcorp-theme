/**
 * Add class to navbar on scroll down / scroll up
 * @function
 * @name smartNav
 * @memberof FunctionsComponent
 * @param {Object} options
 * @param {number} options.delta - Scroll threshold 
 * @param {number} options.navbarHeight - Navigation height 
 * @param {HTMLElement} options.header - Navbar Element 
 * @return {SmartNav} Start with init(), kill with destroy() 
 */
export default function AutoHideNav(options) {
  options = options || {};

  const opts = {
    lastScrollTop: 0,
    delta: options.delta || 50,
    navbarHeight: options.height || 80,
    header: options.header || null,
    style: options.style || {
      onTop: 'onTop',
      navDown: 'navDown',
      navUp: 'navUp',
    }
  };

  return {
    interval: null,
    didScroll: false,
    scrollOpt: opts,
    /**
     * Get document height
     * @function
     * @name SmartNav#docHeight
     * @return {number} Document height
     */
    docHeight: () => {
      var body = document.body,
        html = document.documentElement;

      var height = Math.max(
        body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight,
        html.offsetHeight
      );

      return height;
    },
    /**
     * Watch scroll
     * @function
     * @name SmartNav#setInterval
     */
    setInterval: function () {
      return setInterval(() => {
        if (this.didScroll) {
          this.hasScrolled();
          this.didScroll = false;
        }
      });
    },
    /**
     * Toggle navbar based on scroll
     * @function
     * @name SmartNav#hasScrolled
     */
    hasScrolled: function () {
      const st = window.scrollY;

      const scrollOpt = this.scrollOpt;

      // did not scroll enough
      if (Math.abs(scrollOpt.lastScrollTop - st) <= scrollOpt.delta) return;

      // bellow navbar
      if (st <= scrollOpt.navbarHeight) {
        scrollOpt.header.classList.add(opts.style.onTop);
      } else {
        scrollOpt.header.classList.remove(opts.style.onTop);
      }

      // If current position > last position AND scrolled past navbar...
      if (st > scrollOpt.lastScrollTop && st > scrollOpt.navbarHeight) {
        // Scroll Down
        scrollOpt.header.classList.remove(opts.style.navDown);
        scrollOpt.header.classList.add(opts.style.navUp);
      } else {
        // Scroll Up
        // If did not scroll past the document (possible on mac)...
        if (st + window.innerHeight < this.docHeight()) {
          scrollOpt.header.classList.remove(opts.style.navUp);
          scrollOpt.header.classList.add(opts.style.navDown);
        }
      }

      this.scrollOpt.lastScrollTop = st;
    },
    /**
     * Enable `hasScrolled`
     * @function
     * @name SmartNav#reset
     */
    reset: function () {
      this.didScroll = true;
    },
    /**
     * Initialize module 
     * @function
     * @name SmartNav#init
     */
    init: function () {
      this.interval = this.setInterval();
      window.addEventListener('scroll', this.reset.bind(this))
    },
    /**
     * Reset/destroy module 
     * @function
     * @name SmartNav#destroy
     */
    destroy: function () {
      window.removeEventListener('scroll', this.reset.bind(this))
      clearInterval(this.interval);
      this.interval = null;
    }
  }
}
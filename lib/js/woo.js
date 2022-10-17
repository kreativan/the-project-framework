/**
 *  woo JS
 */
 var woo = (function () {

  'use strict';

	// Create the methods object
	var methods = {};

  /* =========================================================== 
    Add to Cart
  =========================================================== */

  methods.addToCart = async function(id) {
    event.preventDefault();
    let _this = event.target;

    // console.log(_this);

    _this = document.querySelector(`.add-to-cart-button[data-product_id='${id}']`);
    let button = _this;
    let spinner = button.querySelector('.uk-spinner');
    let span = button.querySelector('span');
    
    span.classList.add('uk-hidden');
    spinner.classList.remove('uk-hidden');

    setTimeout(async () => {
      
      let url = `${cms.ajaxUrl}woo/add-to-cart/?add-to-cart=${id}`;
      let request = await fetch(url);
      let response = await request.json();

      // console.log(response);

      spinner.classList.add('uk-hidden');
      span.classList.remove('uk-hidden');

      if (response.status == 'success') {

        UIkit.notification({
          message: response.message,
          status: 'primary',
          pos: 'top-center',
          timeout: 2000
        });

        // Update cart counter
        this.updateCartCounter(response.cart_count);

      }

    }, 200);

  }

  /* =========================================================== 
    Remove from Cart
  =========================================================== */

  methods.removeFromCart = async function(id, key) {
    event.preventDefault();

    let url = `${cms.ajaxUrl}woo/remove-from-cart/?id=${id}&remove_item=${key}`;
    let request = await fetch(url);
    let response = await request.json();

    //console.log(response);

    if (response.status == 'success') {

      UIkit.notification({
        message: response.message,
        status: 'warning',
        pos: 'top-center',
        timeout: 2000
      });

      // Update cart counter
      this.updateCartCounter(response.cart_count);

      this.htmxResponse(response);

    }

  }

  /* =========================================================== 
    Cart Utility
  =========================================================== */

  /** Update Cart Counter */
  methods.updateCartCounter = function(count) {
    let elements = document.querySelectorAll('.cart-count');
    elements.forEach( e => {
      e.innerText = count;
    });
  }

  /* =========================================================== 
    Ajax
  =========================================================== */

  /**
    * Run htmx Req if there is ajax response
    * @param {string} url
    * @param {string} type - GET / POST
    * @param {string} target - #target-element
    * @param {string} swap = innerHTML
    * @param {string} indicator - #htmx-indicator
    * @param {string} push_url - url
   */
  methods.htmxResponse = function(response) {
     if(response.htmx) {
      let htmxOpt = {};
      let htmxUrl = response.htmx.url ? response.htmx.url : "";
      let htmxType = response.htmx.type ? response.htmx.type : "GET";
      if(response.htmx.target) htmxOpt.target = response.htmx.target;
      if(response.htmx.swap) htmxOpt.swap = response.htmx.swap;
      if(response.htmx.indicator) htmxOpt.indicator = response.htmx.indicator;
      htmx.ajax(htmxType, htmxUrl, htmxOpt);
      if(response.htmx.push_url) {
        window.history.pushState({}, '', response.htmx.push_url);
      }
    }
  }

  // Expose the public methods
	return methods;


})();
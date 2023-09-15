/**
 *  woo JS
 */
var woo = (function () {
  "use strict";

  // Create the methods object
  var methods = {};

  /* =========================================================== 
    Add to Cart
  =========================================================== */

  methods.addToCart = async function (id) {
    event.preventDefault();
    let _this = event.target;

    // console.log(_this);

    _this = document.querySelector(
      `.add-to-cart-button[data-product_id='${id}']`
    );

    let button = _this;

    // ajax indicator
    let ajaxIndicator = button.querySelector(".ajax-indicator");
    if (ajaxIndicator) ajaxIndicator.classList.remove("uk-hidden");

    // toggle icon spinner ON
    this.toggleSpinner(button, true);

    setTimeout(async () => {
      let url = `${cms.ajaxUrl}woo/add-to-cart/?add-to-cart=${id}`;
      let request = await fetch(url);
      let response = await request.json();

      // console.log(response);

      if (ajaxIndicator) ajaxIndicator.classList.add("uk-hidden");

      if (response.status == "success") {
        UIkit.notification({
          message: response.message,
          status: "primary",
          pos: response.notification_pos
            ? response.notification_pos
            : "top-center",
          timeout: 2000,
        });

        // Update cart counter
        this.updateCartCounter(response.cart_count);

        // toggle icon spinner OFF
        this.toggleSpinner(button, false);
      }
    }, 200);
  };

  /* =========================================================== 
    Remove from Cart
  =========================================================== */

  methods.removeFromCart = async function (id, key, notification = true) {
    event.preventDefault();

    let _this = event.target.closest(".remove-from-cart");

    // toggle icon spinner ON
    this.toggleSpinner(_this, true);

    setTimeout(async () => {
      let url = `${cms.ajaxUrl}woo/remove-from-cart/?product_id=${id}&key=${key}`;
      let request = await fetch(url);
      let response = await request.json();

      //console.log(response);

      if (response.status == "success") {
        if (notification) {
          UIkit.notification({
            message: response.message,
            status: "warning",
            pos: response.notification_pos
              ? response.notification_pos
              : "top-center",
            timeout: 2000,
          });
        }

        // Update cart counter
        this.updateCartCounter(response.cart_count);

        // run htmx
        this.htmxResponse(response);

        // toggle icon spinner OFF
        this.toggleSpinner(_this, false);
      }
    }, 200);
  };

  /* =========================================================== 
    Cart Utility
  =========================================================== */

  /** Update Cart Counter */
  methods.updateCartCounter = function (count) {
    let elements = document.querySelectorAll(".woo-cart-count");
    if (elements.length == 0) return;
    elements.forEach((e) => {
      e.innerText = count;
    });
  };

  /** Toggle Spinner icon */
  methods.toggleSpinner = function (el, on = false) {
    let icon = el.querySelector(".toggle-icon");
    let spinner = el.querySelector(".toggle-spinner");
    if (on) {
      if (icon) icon.classList.add("uk-hidden");
      if (spinner) spinner.classList.remove("uk-hidden");
    } else {
      if (icon) icon.classList.remove("uk-hidden");
      if (spinner) spinner.classList.add("uk-hidden");
    }
  };
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
  methods.htmxResponse = function (response) {
    if (!response.htmx) return;

    let htmxOpt = {};
    let htmxUrl = response.htmx.url ? response.htmx.url : "";
    let htmxType = response.htmx.type ? response.htmx.type : "GET";
    if (response.htmx.target) htmxOpt.target = response.htmx.target;
    if (response.htmx.swap) htmxOpt.swap = response.htmx.swap;
    if (response.htmx.indicator) htmxOpt.indicator = response.htmx.indicator;
    htmx.ajax(htmxType, htmxUrl, htmxOpt);
    if (response.htmx.push_url) {
      window.history.pushState({}, "", response.htmx.push_url);
    }
  };

  // Expose the public methods
  return methods;
})();

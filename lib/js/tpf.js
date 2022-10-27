/**
 *  Project JS
 */
 var tpf = (function () {

	'use strict';

	// Create the methods object
	var methods = {};

  /* =========================================================== 
    Ajax Request
  =========================================================== */

  /**
   * Ajax Request on given URl
   * @param {string} url 
   * @param {object} data
   */
  methods.ajaxReq = async function(url, data = null) {

    event.preventDefault();

    let indicator;

    /** 
     * Get the indicator
     * from the data argument data.indicator
     */
    if (data != null && data.indicator) {
      indicator = document.querySelector(data.indicator);
      if (indicator) indicator.classList.remove("uk-hidden");
    }

    // fetch options
    let fetchOptions = {}

    /**
     * Create a formData from data argument object
     * Set fetch options
     */
    if (data) {
      let formData = new FormData();
      for (const item in data) formData.append(item, data[item]);
      fetchOptions = {
        method: data.method ? data.method : 'POST',
        cache: 'no-cache',
        body: formData
      }
    }

    /**
     * Send the fetch request
     */
    let request = await fetch(url, fetchOptions);
    let response = await request.json();

    /** Run response method */
    this.ajaxResponse(response);

    // hide indicator
    if (indicator) {
      indicator.classList.add("uk-hidden");
    }

  }

  /* =========================================================== 
    Ajax Response
    Used in  this.ajaxReq() and this.formSubmit()
    - errors
    - modal
    - notification
    - redirect
    - open_new_tab
    - dialog
    - modal_width
    - htmx
    - close_modal_id
    If you want to trigger anything else, do it here!
  =========================================================== */

  methods.ajaxResponse = function(response) {

    // Log the response
    if(cms.debug) console.log(response);

    // Error notification, for each item in response errors
    if(response.errors && response.errors.length > 0) {
      response.errors.forEach(error => {
        UIkit.notification({
          message: error,
          status: 'danger',
          pos: response.notification_pos ? response.notification_pos : 'top-center',
          timeout: 3000
        });
      }); 
    }

    // Modal or Alert
    // If redirect or open_new_tab, do it after modal confirm
    else if (response.modal || response.alert) {
      UIkit.modal.alert(response.modal).then(function () {
        if(response.open_new_tab) {
          window.open(response.open_new_tab, '_blank');
        } else if (response.redirect) {
          window.location.href = response.redirect;
        }
      });
    } 

    // Just a notification
    // based on a response status
    else if (response.notification) {
      UIkit.notification({
        message: response.notification,
        status: response.status ? response.status : 'primary',
        pos: 'top-center',
        timeout: 3000
      });
    }

    // Redirect to the specified URL
    else if (response.redirect) {
      window.location.href = response.redirect;
    } 

    // Open new tab has to be an url
    else if (response.open_new_tab) {
      window.open(response.open_new_tab, '_blank');
    } 
    
    // Trigger uikit dialog
    else if (response.dialog) {
      UIkit.modal.dialog(response.dialog);
    }

    // Set custom modal width
    if(response.modal_width) {
      document.querySelector(".uk-modal:last-child > .uk-modal-dialog").style.width = response.modal_width;
    }

    /**
     * Run htmx Req If any
     * @param {string} url
     * @param {string} type - GET / POST
     * @param {string} target - #target-element
     * @param {string} swap = innerHTML
     * @param {string} indicator - #htmx-indicator
     * @param {string} push_url - url
     */
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
    
    /**
     * Close modal based on specified ID
     * if exists...
     */
    if(response.close_modal_id) {
      let modal = window.document.getElementById(response.close_modal_id);
      if(modal) {
        UIkit.modal(modal).hide();
        if(response.htmx) {
          UIkit.util.on('#htmx-modal', 'hidden', function () {
            modal.remove();
          });
        }
      }
    }

    /**
     * Set cookie
     */
    if(response.cookie) {
      let cookieName = response.cookie.name ? response.cookie.name : false;
      let cookieValue = response.cookie.value ? response.cookie.value : false;
      let cookieDays = response.cookie.days ? response.cookie.days : 1;
      if(cookieName && cookieValue && !this.getCookie(cookieName)) {
        this.setCookie(cookieName,cookieValue,cookieDays);
      }
    }

  }

  /* =========================================================== 
    Form - Ajax
  =========================================================== */

  /**
   * Submit Form Data to the form action url
   * This should be like: /ajax/example/
   * @param {string} form_id 
   */
   methods.formSubmit = async function(form_id) {

    event.preventDefault();

    /**
     * Get the form.
     * If does not exist, try to find a element with data-form attr instead
     */
    let form = document.getElementById(form_id);
    if(!form) form = document.querySelector("[data-form='"+form_id+"']");

    /**
     * Use this.formFields() method
     * to get the fields, so we can manupulate them,
     * clear values, add error indicators etc...
     */
    const fields = this.formFields(form_id);

    /**
     * Find .ajax-indicator
     * or #ajax-indicator
     */
    const indicator = form.querySelector(".ajax-indicator");
    const indicatorGlobal = document.getElementById("ajax-indicator");
    
    if (indicator) {
      indicator.classList.remove("uk-hidden");
    } else if (indicatorGlobal) {
      indicatorGlobal.classList.remove("uk-hidden");
    }

    /**
     * Fetch Options
     * url - based on form action or data-action attribute
     * method -  based on form method or data-method attribute
     */
    let ajaxUrl = form.getAttribute("action");
    if(!ajaxUrl) ajaxUrl = form.getAttribute("data-action");
    let formMethod = form.getAttribute("method");
    if(!formMethod) formMethod = form.getAttribute("data-method");

    /**
     * Use this.formData() method
     * to collect all form data
     */
    let formData = this.formData(form_id);

    /**
     * Send fetch request
     */
    let request = await fetch(ajaxUrl, {
      method: formMethod,
      cache: 'no-cache',
      body: formData
    });

    // Get the response
    let response = await request.json();

    // if reset-form clear form fields
    if(response.reset_form) this.formClear(form_id);

    // Clear error marks
    fields.forEach(e => {
      e.classList.remove("error");
    });

    // Form: mark error fields
    if(response.error_fields && response.error_fields.length > 0) {
      response.error_fields.forEach(e => {
        let field = form.querySelector(`[name='${e}']`);
        if(field) field.classList.add("error");
      });
    }

    // Run the response
    this.ajaxResponse(response);

    // hide indicator
    if (indicator) {
      indicator.classList.add("uk-hidden");
    } else if (indicatorGlobal) {
      indicatorGlobal.classList.add("uk-hidden");
    }

  }

  /* =========================================================== 
    Form Utilities
  =========================================================== */

  /**
   * Get fields from specified form
   * @param {string} form_id 
   */
  methods.formFields = function(form_id) {
    const form = document.getElementById(form_id);
    const fields = form.querySelectorAll("input, select, textarea");
    return fields;
  }

  /**
   * Create FormData for use in fetch requests 
   * @param {string} form_id 
   * @param {object} data - {"name": "My Name", "email": "My Email"}
   * @returns {object}
   */
  methods.formData = function(form_id, data = null) {
    let fields = this.formFields(form_id);
    let formData = new FormData();
    if (data) {
      for (const item in data) formData.append(item, data[item]);
    }
    fields.forEach((e) => {
      let type = e.getAttribute('type');
      let name = e.getAttribute("name");
      if(type === 'file') {
        formData.append(name, e.files[0]);
      } else {
        formData.append(name, e.value);
      }
    });
    return formData;
  }

  /**
   * Reset/clear all form fields values
   * @param {string} form_id css id 
   */
  methods.formClear = function(form_id) {
    let fields = this.formFields(form_id);
    fields.forEach((e) => {
      let type = e.getAttribute("type");
      if(type !== "submit" && type !== "hidden" && type !== "button") e.value = "";
    });
  }

  /**
   * Set form field values
   * @param {string} form_id 
   * @param {object} obj {id: '123', title: 'My Title'...} 
   */
  methods.formSetVals = function(form_id, obj) {
    const form = document.getElementById(form_id);
    for (const property in obj) {
      let name = property;
      let value = obj[property]
      let input = form.querySelector(`[name='${name}']`);
      input.value = value;
    }
  }

  /* =========================================================== 
    UI
  =========================================================== */

  /**
   * Toggle class on a target elements
   * Add class on the clicked element, remove from all other 
   * @param {string} target 
   * @param {string} cls 
   * @example <a href="#" onclick='toggleNav('.menu-item')'></a>
   */
  methods.toggleNav = function(target, cls = "uk-active") {
    let _this = event.target.closest(target);
    _this.classList.add(cls);
    let items = document.querySelectorAll(target);
    if(items) {
      items.forEach(e => {
        if (e != _this) e.classList.remove(cls);
      });
    }
  }

  methods.mobile_menu = function(actual_link = '') {
    event.preventDefault();
    let mobileMenu = document.querySelector("#mobile-menu");
    let isLoaded = mobileMenu.querySelector("#mobile-menu-nav");
    UIkit.offcanvas(mobileMenu).show();
    if(!isLoaded) {
      fetch(`${cms.mobile_menu_path}&actual_link=${actual_link}`)
        .then(response => response.text())
        .then(data => {
          let mobileMenuBar = mobileMenu.querySelector(".uk-offcanvas-bar");
          mobileMenuBar.innerHTML = data;
        }); 
    }
  }

  /* =========================================================== 
    Cookies
  =========================================================== */

  methods.setCookie = function(name,value,days){
    if(days){
      var d=new Date();
      d.setTime(d.getTime()+(days*24*60*60*1000));
      var expires = "; expires="+d.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
    // console.log("cookie is set to" + d);
  }

  methods.getCookie = function(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  /* =========================================================== 
    HTMX
  =========================================================== */

  methods.htmxModal = function(modalID = "htmx-modal") {
    let isHtmxElement = event.target.hasAttribute("hx-target") ? true : false;
    let htmxEl = isHtmxElement ? event.target : event.target.closest("[hx-target]");
    htmxEl.addEventListener("htmx:afterOnLoad", function() {
      let modal = window.document.getElementById(modalID);
      UIkit.modal(modal).show();
      UIkit.util.on(`#${modalID}`, 'hidden', function () {
        modal.remove();
      });
    });
  }

  methods.htmxOffcanvas = function(offcanvasID = "htmx-offcanvas") {
    let isHtmxElement = event.target.hasAttribute("hx-target") ? true : false;
    let htmxEl = isHtmxElement ? event.target : event.target.closest("[hx-target]");
    htmxEl.addEventListener("htmx:afterOnLoad", function() {
      let offcanvas = window.document.getElementById(offcanvasID);
      UIkit.offcanvas(offcanvas).show();
      UIkit.util.on(`#${offcanvasID}`, 'hidden', function () {
        offcanvas.remove();
      });
    })
  }

	// Expose the public methods
	return methods;


})();

const TPF = tpf;
/**
 *  Admin JS
 */
 var tpf_admin = (function () {

  'use strict';

	// Create the methods object
	var methods = {};

  //  Test
  // ===========================================================

  methods.testREST = async function(url, data = null) {

    event.preventDefault();

    let formData;

    if(data) {
      formData = new FormData();
      for (const item in data) formData.append(item, data[item]);
    }

    // let url = '/wp-json/wp/v2/settings/';

    let request = await fetch(url, {
      method: data ? 'POST' : 'GET',
      body: formData ? formData : null,
      cache: 'no-cache',
      headers: {
        'X-WP-Nonce': wpApiSettings.nonce
      }
    });

    let response = await request.json();

    console.log(response);

  }

  // Expose the public methods
	return methods;


})();
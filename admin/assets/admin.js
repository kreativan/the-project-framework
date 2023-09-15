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

/**
 * Collapse flexible content field
 */
function collapseFlexibleContent() {
  let items = document.querySelectorAll(".acf-field-flexible-content.tpf-collapse .layout");
  console.log(items);
  items.forEach(e => {
    e.classList.add('-collapsed');
  });
}

/**
 * Init Macy Grid on .tpf-grid elements
 */
function tpf_admin_grid_init() {

  let grid = document.querySelectorAll('.tpf-grid');
  
  grid.forEach(e => {

    let items_per_row = e.getAttribute('data-grid');
    let l = e.getAttribute('data-grid-l');
    let m = e.getAttribute('data-grid-m');
    let s = e.getAttribute('data-grid-s');

    l = l ? l : 2;
    m = m ? m : 1;
    s = s ? s : 1;

    var macyInstance = Macy({
      container: e,
      margin: 20,
      columns: items_per_row,
      breakAt: {
        1281: l,
        1025: m,
        769: s
      }
    });

  });

}

window.addEventListener("DOMContentLoaded", function() {
  collapseFlexibleContent();
  tpf_admin_grid_init();
});

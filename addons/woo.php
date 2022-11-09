<?php namespace TPF;

class WOO {

  public function __construct() {

    if(!tpf_settings("woo_styles")) {
      add_theme_support('woocommerce');
    }

  }

  /**
   * Is woocommerce page
   *
   * @param   string $page        ( 'cart' | 'checkout' | 'account' | 'endpoint' )
   * @param   string $endpoint    If $page == 'endpoint' and you want to check for specific endpoint
   * @return  boolean
   */
  
  public function is_woocommerce_page($page = '', $endpoint = ''){
      if(!$page){
        return ( is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url() );
      }

      switch ( $page ) {
        case 'cart':
        return is_cart();
        break;

        case 'checkout':
        return is_checkout();
        break;

        case 'account':
        return is_account_page();
        break;

        case 'endpoint':
        if( $endpoint ) {
          return is_wc_endpoint_url( $endpoint );
        }
        return is_wc_endpoint_url();
        break;
      }

      return false;
  }

}
<?php

/**
 * Password Protect access to the certain pages in admin
 * Passwords are saved in website root psw.txt file, one password per line
 * Init class with the options:
 * @param $options['method'] => 'post_type'
 * @param $options['post_types'] => ['product', 'vendors']
 * 
 * @example
 * add_action('plugins_loaded', function () {
 *  new \TPF\PasswordProtect(['post_types' => ['project-forms']]);
 * });
 */

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class PasswordProtect {

  public $method;
  public $post_types;
  public $cookie_duration;

  public function __construct($options = []) {

    // Save password when submitted
    add_action('init', function () {
      if (isset($_POST['tpf_password_protect'])) {
        $this->savePassword($_POST['tpf_password_protect']);
        wp_redirect($_SERVER['REQUEST_URI']);
        exit();
      }
    });

    // What are you trying to protect? 
    $this->method = !empty($options['method']) ? $options['method'] : "post_type";
    // If method is 'post_type' then define post types in an array
    $this->post_types = !empty($options['post_types']) ? $options['post_types'] : [];
    // Cookie duration - default 1 day
    $this->cookie_duration = !empty($options['cookie_duration']) ? $options['cookie_duration'] : 60 * 60 * 24;

    // Run Protect
    if (is_admin() && !$this->has_access()) {
      // Protect Post Types Access
      if ($this->method == "post_type") {
        add_action('init', [$this, 'protect_post_types']);
      }
    }
  }

  // --------------------------------------------------------- 
  // Methods 
  // --------------------------------------------------------- 

  /**
   * Protect post types based on a $_GET['post_type'] parameter
   */
  public function protect_post_types() {
    if (isset($_GET['post_type']) && in_array($_GET['post_type'], $this->post_types)) {
      add_action('admin_head', [$this, 'htmx_script']);
    }
  }

  // --------------------------------------------------------- 
  // Helpers 
  // --------------------------------------------------------- 

  /**
   * Check if has access or to show password form
   */
  public function has_access() {
    $tpf_protected_access = isset($_COOKIE['tpf_protected_access']) ? $_COOKIE['tpf_protected_access'] : "";
    return $tpf_protected_access == 1 ? true : false;
  }

  /**
   * Validate password
   * @param $psw string
   * @return bool
   */
  public function validatePassword($psw) {
    $passwords = $this->get_passwords();
    if ($psw == "") return false;
    if (in_array($psw, $passwords)) return true;
    return false;
  }

  /**
   * Save password to session
   * @param $psw string
   * @return string
   */
  public function savePassword($psw) {
    if (!$this->validatePassword($psw)) return;
    $expiration = time() + $this->cookie_duration;
    setcookie("tpf_protected_access", 1, $expiration, COOKIEPATH, COOKIE_DOMAIN);
  }

  /**
   * Get passwords from file
   * @return array
   */
  public function get_passwords() {
    $root_dir = ABSPATH;
    $psw_file = $root_dir . 'psw.txt';
    if (!file_exists($psw_file)) return [];
    $passwords = file_get_contents($psw_file);
    $passwords = explode("\n", $passwords);
    $passwords = array_map('trim', $passwords);
    return $passwords;
  }

  /**
   * Default htmx script used to replace the content of the page with the password form
   */
  public function htmx_script() {
    $i = 0;
    $GET = "";
    foreach ($_GET as $key => $value) {
      $GET .= ($i++ > 0) ? "&{$key}={$value}" : "?{$key}={$value}";
    }
    echo "<script>
        window.addEventListener('DOMContentLoaded', function() {
          htmx.ajax('GET', '/ajax/password-protect-admin/{$GET}', {target:'#wpbody', swap:'innerHTML'})
        });
      </script>
    ";
  }
}

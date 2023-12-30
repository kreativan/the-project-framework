<?php

namespace TPF;

if (!defined('ABSPATH')) {
  exit;
}

class SMTP {

  public function __construct() {

    if (tpf_settings('smtp_enable')) {
      add_action('phpmailer_init', [$this, 'enable_smtp']);
    }
  }

  public function enable_smtp($phpmailer) {

    $from_email = tpf_settings('smtp_from_email');
    $from_name = tpf_settings('smtp_from_name');

    $phpmailer->IsSMTP();
    $phpmailer->SetFrom($from_email, $from_name);
    $phpmailer->Host = tpf_settings('smtp_host');
    $phpmailer->Port = tpf_settings('smtp_port');
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = tpf_settings('smtp_secure');
    $phpmailer->Username = tpf_settings('smtp_username');
    $phpmailer->Password = tpf_settings('smtp_password');
  }
}

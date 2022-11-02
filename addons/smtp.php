<?php namespace TPF;

class SMTP {

  public function __construct() {

    $this->tpf = new \TPF();

    if($this->tpf->settings('smtp_enable')) {
      add_action( 'phpmailer_init', 'enable_smtp' );
    }

  }

  public function enable_smtp($phpmailer) {

    $from_email = $this->tpf->settings('smtp_from_email');
    $from_name = $this->tpf->settings('smtp_from_name');

    $phpmailer->IsSMTP();
    $phpmailer->SetFrom($from_email, $from_name);
    $phpmailer->Host = $this->tpf->settings('smtp_host');
    $phpmailer->Port = $this->tpf->settings('smtp_port');
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = $this->tpf->settings('smtp_secure');
    $phpmailer->Username = $this->tpf->settings('smtp_username');
    $phpmailer->Password = $this->tpf->settings('smtp_password');

  }


}
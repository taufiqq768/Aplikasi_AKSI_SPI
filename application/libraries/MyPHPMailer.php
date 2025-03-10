<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class MyPHPMailer {
    public function __construct() {
        require('PHPMailer/PHPMailerAutoload.php');
        require('PHPMailer/class.phpmailer.php');
    }
}
?>	
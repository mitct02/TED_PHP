<?
require 'TED_PHP.config.php';
require 'TED_PHP.class.php';

$ted = new TED_PHP($ted_hostname, $ted_port, $ted_username, $ted_password, $ted_ssl, $ted_api, $ted_mtu, $ted_type);
print_r($ted);
echo $ted->fetch();
?>

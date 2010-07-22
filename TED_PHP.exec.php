<?
/* Require required stuff */
require 'TED_PHP.config.php';
require 'TED_PHP.class.php';

/* Instantiate the object */
$ted = new TED_PHP(TED_HOSTNAME, TED_PORT, TED_USERNAME, TED_PASSWORD, TED_SSL, TED_API, TED_MTU, TED_TYPE);


/* Print stuff */
print_r($ted);
echo $ted->fetch();
?>

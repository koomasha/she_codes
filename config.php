<?php
$config=array();
$config['env']='local';
$config['debug']='true';

/*
#1 - error
#2 - warning
#3 - info
#4 - optimization
#5 - debug
*/
$config['sevirity'] = array(1,2,3);

$config['my_domain'] = 'DOMAIN';
$config['dsn'] = 'mysql:dbname=DB_NAME;host=HOST_NAME';
$config['user'] = 'USER';
$config['password'] = 'PASSWORD';

$config['fbappid'] = 'APP_ID';
$config['fbappsecret'] = 'APP_SECRET';
?>
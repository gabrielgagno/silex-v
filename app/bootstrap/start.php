<?php

/**
*  Development Servers
*/
$development = [
    "SP-JMacariola-HP14V015TX",
    "gjpgagno@HP14V016TX"
];
/**
*  Production Servers
*/
$production = [
        "VMGRMAPD"
];

if (in_array(gethostname(),$development)) return 'development';

return 'production';

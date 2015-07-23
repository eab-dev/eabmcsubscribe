<?php

$Module = array( 'name' => 'EAB Mailchimp Subscribe' );

$ViewList = array(
    'subscribe' => array(
        'script'    => 'subscribe.php',
        'functions' => array( 'subscribe' )
    ),
    'thanks' => array(
        'script'    => 'thanks.php',
        'functions' => array( 'subscribe' )
    )
);

$FunctionList = array(
    'subscribe' => array() // Assign this policy to the Anonymous role
);

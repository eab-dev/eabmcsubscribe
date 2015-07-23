<?php

/*
 * Copyright (C) 2015 Enterprise AB Ltd http://eab.uk
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

$http = eZHTTPTool::instance();

if ( $http->hasPostVariable( 'submit' ) ) {
    $errors = processDetails( $http );
    if ( $errors ) {
        $Result = displayForm( $Result, $errors );
    } else {
        $module = $Params[ 'Module' ];
        $module->redirectToView( 'thanks' );
    }
} else {
    $Result = displayForm( $Result );
}

function processDetails( eZHTTPTool $http )
{
    $ini = eZINI::instance( 'mailchimp.ini' );
    $errors = array();

    $email = trim( $http->postVariable( 'email' ) );
    if ( $email == "" ) {
        $errors[] = "Please supply your email address";
    }

    $firstName = trim( $http->postVariable( 'fname' ) );
    if ( $firstName == "" ) {
        $errors[] = "Please supply your first name";
    }

    $lastName = trim( $http->postVariable( 'lname' ) );
    if ( $lastName == "" ) {
        $errors[] = "Please supply your last name";
    }

    $consent = trim( $http->postVariable( 'consent' ) );
    if ( $consent != "1" ) {
        $errors[] = "Please tick the consent box";
    }

    if ( in_array( $ini->variable( 'RecaptchaSettings', 'Use' ), array( "enabled", "true" ))
         && !isHuman( $http , $ini->variable( 'RecaptchaSettings', 'SecretKey' ))) {
        $errors[] = "Complete the reCAPTCHA challenge to prove you're human";
    }

    if ( count( $errors ) ) {
        return $errors;
    }


    $apiKey = $ini->variable( 'MailchimpSettings', 'APIKey' );
    $listId = $ini->variable( 'MailchimpSettings', 'SubscribeListID' );
    $doubleOptIn = in_array( $ini->variable( 'MailchimpSettings', 'DoubleOptIn' ), array( "enabled", "true" ));

    if ( $listId == "" ) {
        // fall back to the members sync mailing list
        $listId = $ini->variable( 'MailchimpSettings', 'ListID' );
    }

    $mailchimp = new Mailchimp( $apiKey );

    try {
        $subscriber = $mailchimp->lists->subscribe( $listId,
                                                    array(
                                                           'email' => $email
                                                         ),
                                                    array(
                                                           'FNAME' => $firstName,
                                                           'LNAME' => trim( $http->postVariable( 'lname' ) )
                                                         ),
                                                    'html',
                                                    $doubleOptIn,
                                                    false, // update existing
                                                    true, // replace interests
                                                    true // send welcome
                                                );
        if ( ! empty( $subscriber[ 'leid'] ) ) {
            return null;
        } else {
            // Failure
            return array( "Sorry, something went wrong" );
        }
    } catch ( Mailchimp_Error $e ) {
        $error = $e->getMessage();
        return array( $error );
    }
}

function displayForm( $Result, $errors = null )
{
    $tpl = eZTemplate::factory();
    $tpl->setVariable( 'errors', $errors );
    $Result[ 'path' ] = array(
        array( 'url' => '/', 'text'  => ezpI18n::tr( 'mailchimp/subscribe', 'Home' ) ),
        array( 'url' => false, 'text'  => ezpI18n::tr( 'mailchimp/subscribe', 'Subscribe' ) )
    );
    $Result[ 'title' ] = 'Subscribe';
    $Result[ 'content' ] = $tpl->fetch( "design:mailchimp/subscribe.tpl" );
    return $Result;
}

function isHuman( eZHTTPTool $http, $secretKey )
{
    if ( ! $http->hasPostVariable( 'g-recaptcha-response' ) ) {
        return false;
    }
    $response = json_decode( file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey
                                                . "&response=" . $http->postVariable( 'g-recaptcha-response' )
                                              ), true );
    return ( $response[ "success" ] );
}

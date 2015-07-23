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

$ini = eZINI::instance( 'mailchimp.ini' );

$Result[ 'path' ] = array(
    array( 'url' => '/',   'text' => ezpI18n::tr( 'mailchimp/subscribe', 'Home' ) ),
    array( 'url' => false, 'text' => ezpI18n::tr( 'mailchimp/subscribe', 'Subscribe' ) ),
    array( 'url' => false, 'text' => ezpI18n::tr( 'mailchimp/subscribe', 'Thanks' ) )
);
$Result[ 'title' ] = 'Thanks';

$tpl = eZTemplate::factory();
$tpl->setVariable( 'double_opt_in', in_array( $ini->variable( 'MailchimpSettings', 'DoubleOptIn' ), array( "enabled", "true" )) );

$Result[ 'content' ] = $tpl->fetch( "design:mailchimp/thanks.tpl" );

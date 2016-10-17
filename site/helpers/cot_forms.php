<?php
/**
 * @version     2.0.3
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

defined('_JEXEC') or die;

abstract class Cot_formsHelper
{
	public static function sendMail($data,$email_admin)
	{
		// Get JMail helper
		$mailer = JFactory::getMailer();		

		// Set the sender (from joomla configuration)	
		$config = JFactory::getConfig();
		$sender = array( 
		$config->get( 'mailfrom' ),
		$config->get( 'fromname' ) );
		$mailer->setSender($sender);

		// Set the recipient
		$mailer->addRecipient($email_admin);				

		$valid = "<a href='".JURI::base()."index.php/administration-reports/cot-administration/".$data['id']."?view=cot_admin'>Visit site to validate</a>";

		$body   = "<h4>A new COT observation has been reported:</h4>"
				."<div>Observer name: ".$data['observer_name']."</div>"
				.($data['observer_tel']!== ''?"<div>Observer phone: ".$data['observer_tel']."</div>":"")
				.($data['observer_email']!== ''?"<div>Observer email: ".$data['observer_email']."</div>":"")
				."<div>Date de l'observation: ".($data['observation_day']!== ''?$data['observation_day']."/":"")
 												.($data['observation_month']!== ''?$data['observation_month']."/":"")
 												.($data['observation_year']!== ''?$data['observation_year']."/":"")."</div>"
				."<div>Observation_location: ".$data['observation_location']."</div>"
				."<div>Observation localisation: ".$data['observation_localisation']."</div>"
				.($data['location_region']!== ''?"<div>Region: ".$data['location_region']."</div>":"")
				.($data['location_country']!== ''?"<div>Country: ".$data['location_country']."</div>":"")
				.($data['observation_number']!== ''?"<div>Observation number: ".$data['observation_number']."</div>":"")
				.($data['observation_culled']!== ''?"<div>Number of COTS culled: ".$data['observation_culled']."</div>":"")
				."<div>Observation method: ".implode( ',', $data['observation_method'])."</div>"
				.($data['depth_range']!== ''?"<div>Depth range: ".implode(", ",$data['depth_range'])."</div>":"")
				.($data['counting_method_timed_swim']!== ''&&$data['counting_method_distance_swim']!== ''&&$data['counting_method_other']!== ''?"<div>Counting method(s): </div>":"")
				.($data['counting_method_timed_swim']!== ''?"<div>Counting method timed swim: ".$data['counting_method_timed_swim']."</div>":"")
				.($data['counting_method_distance_swim']!== ''?"<div>Counting method distance swim: ".$data['counting_method_distance_swim']."</div>":"")
				.($data['counting_method_other']!== ''?"<div>Counting method other: ".$data['counting_method_other']."</div>":"")
				.($data['remarks']!== ''?"<div>Remarks: ".$data['remarks']."</div>":"")
				."<div>Observation validation: ".$valid." </div>";

		

		$mailer->setSubject('New Vanuatu COT observation report');
		$mailer->setBody($body);
		$mailer->AltBody =JMailHelper::cleanText( strip_tags( $body));

		$mailer->isHTML(true);

		// Send email
		$send = $mailer->Send();
		if ( $send !== true ) {
		    return 'Error sending email: ' . $send->__toString();
		} else {
		    return 'Mail sent';
		}
	}

	

}


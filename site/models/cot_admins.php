<?php

/**
 * @version     2.0.7
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of Cot_forms records.
 */
class Cot_formsModelCot_admins extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);



        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select( $this->getState( 'list.select', 'a.*' ) );
        $query->from('`#__cot_admin` AS a');

        // Join over the created by field 'created_by'
        $query->select('created_by.name AS created_by');
        $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.observer_name LIKE '.$search.' )');
            }
        }
        return $query;
    }

    public function getItems() {
        return parent::getItems();
    }


    // Fonction de conversion latitude_dmd
    public function convert_Lat_DMD($lat) {
      if($lat >= 0) $lat_dir = 'N';
      else $lat_dir = 'S';
      // Garde la partie entière
      $lat_deg = ( abs( ( int ) $lat ) );
      $lat_min = ( abs( ( abs( $lat ) - $lat_deg ) * 60 ) );
                              // Ne garde que 3 décimales
      return $lat_deg . "°" . number_format($lat_min, 3) . "'" . $lat_dir;
    }

    // Fonction de conversion longitude_dmd
    public function convert_Long_DMD($long){
      if ($long >= 0) $long_dir = 'E';
      else $long_dir = 'W';
      // Garde la partie entière
      $long_deg = ( abs( ( int ) $long ) );
      $long_min = ( abs( ( abs( $long ) - $long_deg ) * 60 ) );
                              // Ne garde que 3 décimales
      return $long_deg . "°" . number_format($long_min, 3). "'" . $long_dir;
    }

	// Fonction de changement d'index
	public function change_key( $array, $old_key, $new_key ) {

    if( ! array_key_exists( $old_key, $array ) )
        return $array;
    // Retourne les indexes du tableau
    $keys = array_keys( $array );

    // Recherche l'ancien index dans le tableau et la remplace para
    // le nouveau index
    $keys[ array_search( $old_key, $keys ) ] = $new_key;

    return array_combine( $keys, $array );
	}

    public function getCsv()
    {
      $this->populateState();
      $db = $this->getDbo();

      // variables de données vide
      $data = "" ;
      // Tabulation pour Windows
      $sep = "\t";

      $cols = (array_keys($db->getTableColumns('#__cot_admin')));

      // Enlève les headers des 4 derniers champs de la BD : state, localisation, created_by
      // et admin_validation
      for($cptr=1; $cptr<5; $cptr++){ array_pop($cols); }

      // Plceles les deux champs lat_dmd et long_dmd à la fin
      array_push($cols, 'observation_latitude_dmd', 'observation_longitude_dmd');

      // Gardé dans un variable les indexes des champs spécifié
      $lat_dmd = array_search('observation_latitude_dmd', $cols);
      $long_dmd = array_search('observation_longitude_dmd', $cols);
      $number = array_search('observation_number', $cols);
      $culled = array_search('observation_culled', $cols);

      // Changement d'index
      $cols = $this->change_key( $cols, $number, $lat_dmd );
      $cols = $this->change_key( $cols, $culled, $long_dmd );

      // Pour être propre on supprime les variables à la fin de
      // leur utilisation
      unset($lat_dmd, $long_dmd, $number, $culled);

      // Enlève le header du champ remarks
      unset($cols[array_search('remarks', $cols)]);

      // Place les champs en dernier
      array_push($cols, 'observation_number', 'observation_culled','remarks' );

      // Retourne le tableau des valeurs indexé
      $values = array_values($cols);

      // Compte les valeurs
      $columns = count($values);

      // Ajout des retour chariot Windows
      for ($i = 0; $i < $columns; $i++) {
             $data .= $values[$i].$sep;
          }
      // Dernier retour chariot
      $data .= "\n";

      // Ouvre le ficheir CSV
      $csv = fopen('php://output', 'w');

	    $items = $db->setQuery($this->getListQuery())->loadObjectList();
      foreach ($items as $line)
      {
        // La ligne de données sous forme de tableau
			   $in = (array) $line;

        // Enlève les données des 4 derniers champs de la BD : state, localistaion, created_by
        // et admin_validation
		    for($cptr=1; $cptr<5; $cptr++){ array_pop($in); }

        // Convertion des lat et long
		    $in['observation_latitude_dmd'] = $this->convert_Lat_DMD($in['observation_latitude']);
			  $in['observation_longitude_dmd'] = $this->convert_Long_DMD($in['observation_longitude']);

        // Gardé dans unbe variables les données a échangé
		  	$num = $in['observation_number'];
		  	$culled = $in['observation_culled'];
		  	$lat_dmd = 	$in['observation_latitude_dmd'];
		  	$long_dmd = $in['observation_longitude_dmd'];
        $remarks = $in['remarks'];
        // Fin:

        // Echange des données des champs spécifier
		  	$in['observation_number'] = $lat_dmd;
		  	$in['observation_culled'] = $long_dmd;
        $in['remarks'] = $num;
		  	$in['observation_latitude_dmd'] = $culled;
		  	$in['observation_longitude_dmd'] = $remarks;
        // Fin: Echange des données

        // Pour être propre on supprime les variables à la fin de
        // leur utilisation
        unset($num, $culled, $lat_dmd, $long_dmd, $remarks);

        // Réglage du format de la date
        $datetime = $in['observation_datetime'];
			  $date = date_create($datetime);
			  $in['observation_datetime'] =  date_format($date, "'d/m/Y'");

        // Ligne de données vide
			  $l = '';

  			foreach ($in as $value)
  			{
          // Supprime les espaces
  				$value = str_replace('"', '""', $value);
  				$l .= '"' . utf8_decode($value) . '"' . "\t"; //ICI NOUS DEVONS DECODER SI LES DONNÉES
                                                        // EN MySQL SONT EN FORMAT UTF- *
  			}
        // Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
  			$data .= trim($l)."\n";
      }
      // Supprime le dernier retour chariot qui ne sert à rien
      $data = str_replace("\r","",$data);
      fputcsv($csv, print $data);
      return fclose($csv);
    }
}

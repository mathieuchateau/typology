<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 typology plugin for GLPI
 Copyright (C) 2009-2016 by the typology Development Team.

 https://github.com/InfotelGLPI/typology
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of typology.

 typology is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 typology is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with typology. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
 
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
* Rule class store all informations about a GLPI rule :
*   - description
*   - criterias
*   - actions
*
**/
class PluginTypologyRuleTypology extends Rule {

   // From Rule
   public static $right='plugin_typology';
   public $can_sort=true;

   function getTitle() {

      return PluginTypologyTypology::getTypeName(1);
   }

   function maybeRecursive() {
      return true;
   }

   function isEntityAssign() {
      return true;
   }

   function canUnrecurs() {
      return true;
   }
   
   /*function maxCriteriasCount() {
      return 2;
   }*/
   
   function maxActionsCount() {
      return count($this->getActions());
   }
   
   function addSpecificParamsForPreview($params) {

      if (!isset($params["entities_id"])) {
         $params["entities_id"] = $_SESSION["glpiactive_entity"];
      }
      return $params;
   }

   /**
    * Function used to display type specific criterias during rule's preview
    *
    * @param $fields fields values
   **/
   function showSpecificCriteriasForPreview($fields) {

      $entity_as_criteria = false;
      foreach ($this->criterias as $criteria) {
         if ($criteria->fields['criteria'] == 'entities_id') {
            $entity_as_criteria = true;
            break;
         }
      }
      if (!$entity_as_criteria) {
         echo "<input type='hidden' name='entities_id' value='".$_SESSION["glpiactive_entity"]."'>";
      }
   }
   
   function getCriterias() {

      $criterias = array();
      
      $criterias['name']['table']     = 'glpi_computers';
      $criterias['name']['field']     = 'name';
      $criterias['name']['name']      = __('Computer\'s name');
      
      $criterias['states_id']['table']     = 'glpi_states';
      $criterias['states_id']['field']     = 'name';
      $criterias['states_id']['name']      = __('Status');
      $criterias['states_id']['linkfield'] = 'states_id';
      $criterias['states_id']['type']      = 'dropdown';
      
      $criterias['computertypes_id']['table']     = 'glpi_computertypes';
      $criterias['computertypes_id']['field']     = 'name';
      $criterias['computertypes_id']['name']      = __('Type');
      $criterias['computertypes_id']['linkfield'] = 'computertypes_id';
      $criterias['computertypes_id']['type']      = 'dropdown';

      $criterias['operatingsystems_id']['table']     = 'glpi_operatingsystems';
      $criterias['operatingsystems_id']['field']     = 'name';
      $criterias['operatingsystems_id']['name']      = __('Operating system');
      $criterias['operatingsystems_id']['linkfield'] = 'operatingsystems_id';
      $criterias['operatingsystems_id']['type']      = 'dropdown';


      return $criterias;
   }
   

   function getActions() {
      $actions = array();
      
      $actions['plugin_typology_typologies_id']['name']  = PluginTypologyTypology::getTypeName(1);
      $actions['plugin_typology_typologies_id']['table']  = "glpi_plugin_typology_typologies";
      $actions['plugin_typology_typologies_id']['type']  = "dropdown";
      $actions['plugin_typology_typologies_id']['force_actions'] = array('assign');

      return $actions;
   }
}
?>
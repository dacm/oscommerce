<?php
/*
  osCommerce Online Merchant $osCommerce-SIG$
  Copyright (c) 2010 osCommerce (http://www.oscommerce.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License v2 (1991)
  as published by the Free Software Foundation.
*/

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Site\Shop\Address;
?>

<ol>

<?php
  if ( ACCOUNT_GENDER > -1 ) {
    $gender_array = array(array('id' => 'm', 'text' => OSCOM::getDef('gender_male')),
                          array('id' => 'f', 'text' => OSCOM::getDef('gender_female')));
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_gender'), null, 'fake', (ACCOUNT_GENDER > 0)) . osc_draw_radio_field('gender', $gender_array, (isset($osC_oiAddress) ? $osC_oiAddress->get('gender') : (!$OSCOM_Customer->hasDefaultAddress() ? $OSCOM_Customer->getGender() : null))); ?></li>

<?php
  }
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_first_name'), null, 'firstname', true) . osc_draw_input_field('firstname', (isset($osC_oiAddress) ? $osC_oiAddress->get('firstname') : (!$OSCOM_Customer->hasDefaultAddress() ? $OSCOM_Customer->getFirstName() : null))); ?></tli>
  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_last_name'), null, 'lastname', true) . osc_draw_input_field('lastname', (isset($osC_oiAddress) ? $osC_oiAddress->get('lastname') : (!$OSCOM_Customer->hasDefaultAddress() ? $OSCOM_Customer->getLastName() : null))); ?></li>

<?php
  if ( ACCOUNT_COMPANY > -1 ) {
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_company'), null, 'company', (ACCOUNT_COMPANY > 0)) . osc_draw_input_field('company', (isset($osC_oiAddress) ? $osC_oiAddress->get('company') : null)); ?></li>

<?php
  }
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_street_address'), null, 'street_address', true) . osc_draw_input_field('street_address', (isset($osC_oiAddress) ? $osC_oiAddress->get('street_address') : null)); ?></li>

<?php
  if ( ACCOUNT_SUBURB > -1 ) {
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_suburb'), null, 'suburb', (ACCOUNT_SUBURB > 0)) . osc_draw_input_field('suburb', (isset($osC_oiAddress) ? $osC_oiAddress->get('suburb') : null)); ?></li>

<?php
  }

  if ( ACCOUNT_POST_CODE > -1 ) {
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_post_code'), null, 'postcode', (ACCOUNT_POST_CODE > 0)) . osc_draw_input_field('postcode', (isset($osC_oiAddress) ? $osC_oiAddress->get('postcode') : null)); ?></li>

<?php
  }
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_city'), null, 'city', true) . osc_draw_input_field('city', (isset($osC_oiAddress) ? $osC_oiAddress->get('city') : null)); ?></li>

<?php
  if ( ACCOUNT_STATE > -1 ) {
?>

  <li>

<?php
    echo osc_draw_label(OSCOM::getDef('field_customer_state'), null, 'state', (ACCOUNT_STATE > 0));

    if ( isset($entry_state_has_zones) ) { // HPDL
      if ( $entry_state_has_zones === true ) {
        $Qzones = $OSCOM_Database->query('select zone_name from :table_zones where zone_country_id = :zone_country_id order by zone_name');
        $Qzones->bindInt(':zone_country_id', $_POST['country']);
        $Qzones->execute();

        $zones_array = array();
        while ( $Qzones->next() ) {
          $zones_array[] = array('id' => $Qzones->value('zone_name'),
                                 'text' => $Qzones->value('zone_name'));
        }

        echo osc_draw_pull_down_menu('state', $zones_array);
      } else {
        echo osc_draw_input_field('state');
      }
    } else {
      if ( isset($osC_oiAddress) ) {
        $zone = $osC_oiAddress->get('state');

        if ( $osC_oiAddress->getInt('zone_id') > 0 ) {
          $zone = Address::getZoneName($osC_oiAddress->getInt('zone_id'));
        }
      }

      echo osc_draw_input_field('state', (isset($osC_oiAddress) ? $zone : null));
    }
?>

  </li>

<?php
  }
?>

  <li>

<?php
  echo osc_draw_label(OSCOM::getDef('field_customer_country'), null, 'country', true);

  $countries_array = array(array('id' => '',
                                 'text' => OSCOM::getDef('pull_down_default')));

  foreach ( Address::getCountries() as $country ) {
    $countries_array[] = array('id' => $country['id'],
                               'text' => $country['name']);
  }

  echo osc_draw_pull_down_menu('country', $countries_array, (isset($osC_oiAddress) ? $osC_oiAddress->getInt('country_id') : STORE_COUNTRY));
?>

  </li>

<?php
  if ( ACCOUNT_TELEPHONE > -1 ) {
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_telephone_number'), null, 'telephone', (ACCOUNT_TELEPHONE > 0)) . osc_draw_input_field('telephone', (isset($osC_oiAddress) ? $osC_oiAddress->get('telephone') : null)); ?></li>

<?php
  }

  if ( ACCOUNT_FAX > -1 ) {
?>

  <li><?php echo osc_draw_label(OSCOM::getDef('field_customer_fax_number'), null, 'fax', (ACCOUNT_FAX > 0)) . osc_draw_input_field('fax', (isset($osC_oiAddress) ? $osC_oiAddress->get('fax') : null)); ?></li>

<?php
  }

  if ( $OSCOM_Customer->hasDefaultAddress() && ((isset($_GET['Edit']) && ($OSCOM_Customer->getDefaultAddressID() != $_GET['AddressBook'])) || isset($_GET['New'])) ) {
?>

  <li><?php echo osc_draw_checkbox_field('primary', array(array('id' => 'on', 'text' => OSCOM::getDef('set_as_primary'))), false); ?></li>

<?php
  }
?>

</ol>

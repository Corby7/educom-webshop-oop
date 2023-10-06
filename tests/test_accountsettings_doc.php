<?php

  include_once "../views/accountsettings_doc.php";

  $data = array ( 'page' => 'accountsettings', /* other fields */ );

  $view = new AccountSettingsDoc($data);
  $view  -> show();

?>
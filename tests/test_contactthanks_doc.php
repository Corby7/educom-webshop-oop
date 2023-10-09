<?php

  include_once "../views/contactthanks_doc.php";

  $data = array ( 'page' => 'contactthanks', /* other fields */ );

  $view = new ContactThanksDoc($data);
  $view  -> show();

?>
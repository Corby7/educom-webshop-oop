<?php

  include_once "../views/contact_doc.php";

  $data = array ( 'page' => 'contact', /* other fields */ );

  $view = new ContactDoc($data);
  $view  -> show();

?>
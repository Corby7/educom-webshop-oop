<?php

  include_once "../views/productpage_doc.php";

  $data = array ( 'page' => 'productpage', /* other fields */ );

  $view = new ProductPageDoc($data);
  $view  -> show();

?>
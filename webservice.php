<?php
require('lib/mcfrontend.php');
$config = new frontend_model_config();
$create = new frontend_model_template;
$config->load_data_setting($create);
$webservice = new frontend_controller_webservice();
$webservice->run();
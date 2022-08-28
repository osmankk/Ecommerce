<?php
      function lang($phrase){
       static $lang = array(
            'HOME_ADMIN' => 'HOME',
       	'osman' =>'OSMAN',
       	'Categories' => 'CATEGORIES',
            'items'      => 'ITEMS',
            'members'    => 'MEMBERS',
            'statistics' => 'STATISTICS',
            'logs'       => 'LOGS',
            'comments'   => 'COMMENTS'
       );
       return $lang[$phrase];
      }
  

<?php

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? 
                                  getenv('APPLICATION_ENV') : 
                                  'production'));

echo APPLICATION_ENV;
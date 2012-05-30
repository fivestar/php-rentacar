<?php

require_once 'bootstrap.php.cache';

exec(__DIR__.'/console doctrine:database:drop --env=test --force');
exec(__DIR__.'/console doctrine:database:create --env=test');
exec(__DIR__.'/console doctrine:schema:create --env=test');

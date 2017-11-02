<?php
assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();

/**
 * Enable local development services.
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/development.services.yml';
$config['system.logging']['error_level'] = 'verbose';
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
# $settings['cache']['bins']['render'] = 'cache.backend.null'; // UNCOMMENT FOR FULL DATA CACHING OFF
# $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null'; // UNCOMMENT FOR FULL DATA CACHING OFF
$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
$settings['extension_discovery_scan_tests'] = TRUE;
$settings['rebuild_access'] = TRUE;

$settings['skip_permissions_hardening'] = TRUE;

$databases['default']['default'] = array (
  'database' => 'creative_dev',
  'username' => 'root',
  'password' => 'password',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
$settings['hash_salt'] = 'uDagt63rhPeYgufbAW90I7cu3HV9qlNyElctkgPkySvYvGL81hmWgzS0RW7RQu1NMtU7fH70Lg';
$settings['install_profile'] = 'standard';

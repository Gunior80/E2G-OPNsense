<?php



function e2guardian_services()
{
    global $config;

    $services = array();

    if (isset($config['OPNsense']['e2guardian']['general']['enabled']) && $config['OPNsense']['e2guardian']['general']['enabled'] == 1) {
        $services[] = array(
            'description' => gettext('Content filter e2guardian daemon'),
            'configd' => array(
                'restart' => array('e2guardian restart'),
                'start' => array('e2guardian start'),
                'stop' => array('e2guardian stop'),
            ),
            'name' => 'e2guardian',
            'pidfile' => '/var/run/e2guardian.pid'
        );
    }

    return $services;
}

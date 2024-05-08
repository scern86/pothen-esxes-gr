<?php

namespace PothenEsxes;

use PothenEsxes\Authorization\Authorization;
class Security
{
    const KED_IP_LIST = [
        '84.205.223.156',/*Public IP*/
        '84.205.231.33',
        '84.205.231.34',
        '84.205.231.35',
        '84.205.231.36',
        '84.205.231.37',
        '84.205.231.38',
        '84.205.231.39',
        '84.205.231.40',
        '84.205.231.41',
        '84.205.231.42',
        '84.205.231.43',
        '84.205.231.44',
        '84.205.231.45',
        '84.205.231.46',
        '84.205.244.129',
        '84.205.244.130',
        '84.205.244.131',
        '84.205.244.132',
        '84.205.244.133',
        '84.205.244.134',
        '84.205.244.135',
        '84.205.244.136',
        '84.205.244.137',
        '84.205.244.138',
        '84.205.244.139',
        '84.205.244.140',
        '84.205.244.141',
        '84.205.244.142',
        '10.16.172.131',
        '10.16.172.132',/*ESB_Server_IP*/
        '10.16.172.162',
        '10.16.171.44',
        '10.16.171.45',
        '10.16.171.46',
        '10.16.171.124',
        '10.16.171.125',
        '10.16.171.49',
        '10.30.11.176',
        '10.30.239.242',/*Old Proxy Server*/
        '10.30.239.204',/*New Proxy Server*/
        '10.30.239.200',/*interface of new Balancer*/
        '10.30.239.201',/*interface of new Balancer*/
        '10.30.239.202',/*interface of new Balancer*/
        '10.30.239.203',/*interface of new Balancer*/
        '10.30.239.204',/*interface of new Balancer*/
        '10.30.239.205',/*interface of new Balancer*/
        '10.30.239.206',/*interface of new Balancer*/
        '10.30.239.207',/*interface of new Balancer*/
    ];

    public function __construct(public Authorization $authorization)
    {
    }

    public static function isAllowedSender(string $ip): bool
    {
        return in_array($ip, self::KED_IP_LIST);
    }
}
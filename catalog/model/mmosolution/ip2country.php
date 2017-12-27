<?php

// Library country detect IP ver 4 only
// Www.MMOSolution.com 

class ModelMMOSolutionip2country extends Model {
    public function info($ip = false) {
        include_once(DIR_APPLICATION."model/mmosolution/lib/geoip.inc");

        if (!$ip) {
            if (isset($this->request->server['REMOTE_ADDR'])) {
                $ip = $this->request->server['REMOTE_ADDR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = '';
            }
        } else {
            $ip = $ip;
        }
        $checkIP = $this->isIPv6($ip);
		
        $info = array();
        if ($checkIP > 0) {

            if ($checkIP == 4) {
                $lib = geoip_open(DIR_APPLICATION."model/mmosolution/lib/GeoIP.dat", GEOIP_STANDARD);
			
                $info['country'] = geoip_country_name_by_addr($lib, $ip);
                $info['iso_code_2'] = geoip_country_code_by_addr($lib, $ip);

                return $info;
            } elseif ($checkIP == 6) {
                $lib = geoip_open(DIR_APPLICATION."model/mmosolution/lib/GeoIPv6.dat", GEOIP_STANDARD);
				//var_dump($lib);
                $info['country'] = geoip_country_name_by_addr_v6($lib, $ip);
                $info['iso_code_2'] = geoip_country_code_by_addr_v6($lib, $ip);
            }
            return $info;
        }
        return $info;
    }

    private function isIPv6($ip) {

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                return 6;
            } else {
                return 4;
            }
        } else {
            return false;
        }
    }

}

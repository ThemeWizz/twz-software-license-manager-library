<?php

namespace themewizz\license;

class TWZ_License
{
    protected $details;
    protected $server_url;
    protected $verification_key;
    protected $license_key;
    /**
     * Constructor.
     */
    public function __construct()
    {
    }
    public function setLicenseServerURL($server_url)
    {
        $this->server_url = $server_url;
    }
    public function setVerificationKey($verification_key)
    {
        $this->verification_key = $verification_key;
    }

    public function setLicenseKey($license_key)
    {
        $this->license_key = $license_key;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function load()
    {
        $parms = array(
            'twz_license_action' => 'information',
            'twz_license_verification_key' => urlencode($this->verification_key),
            'twz_license_key' => urlencode($this->license_key)
        );
        $this->details = (object) $this->callAPI($parms);
    }

    public function domainRegistered()
    {
        if ($this->details && isset($this->details->twz_license_registered_domains)) {
            if (!empty($this->details->twz_license_registered_domains)) {
                foreach ($this->details->twz_license_registered_domains as $domain) {
                    $current_domain = trim(wp_unslash(sanitize_text_field($_SERVER['SERVER_NAME'])));
                    $registered_domain = $domain['domain'];
                    if ($registered_domain == $current_domain) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function activate()
    {
        $parms = array(
            'twz_license_action' => 'activation',
            'twz_license_verification_key' => urlencode($this->verification_key),
            'twz_license_key' => urlencode($this->license_key),
            'twz_new_domain' => $_SERVER['SERVER_NAME']
        );

        $response = $this->callAPI($parms);
        
        return $response;
    }

    function deactivate()
    {
        $parms = array(
            'twz_license_action' => 'deactivation',
            'twz_license_verification_key' => urlencode($this->verification_key),
            'twz_license_key' => urlencode($this->license_key),
            'twz_domain' => $_SERVER['SERVER_NAME']
        );

        $response = $this->callAPI($parms);
 
        return $response;
    }

    function callAPI($data = false)
    {
        $data = array_merge(['action' => 'twz_domain_registration_service'], $data);
        $url = $this->server_url . '/wp-admin/admin-ajax.php' . '?XDEBUG_SESSION_START=PHPSTORM';
        $response = wp_remote_post(
            $url,
            array(
                'method'      => 'POST',
                'redirection' => 5,
                'timeout' => 5000,
                'body' => $data
            )
        );

        if (!is_wp_error($response) && 200 == $response['response']['code']) {
            return json_decode($response['body'], true);
        } 
        return [];
    }
}

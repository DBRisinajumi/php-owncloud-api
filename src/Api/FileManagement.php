<?php

namespace Owncloud\Api;

use League\Flysystem\Adapter\WebDav;
use League\Flysystem\Filesystem;
use Owncloud\OwnCloudWebDav;
use Sabre\DAV\Client;

/**
 * @author Gustavo Pilla <pilla.gustavo@gmail.com>
 */
class FileManagement extends Filesystem
{

    /**
     * @param $host string
     * @param $username string
     * @param $password string
     * @param $settings array ['curlSettings' => [],'pathRemoteWebDav' => 'wweebb']
     */
    public function __construct(
        $host,
        $username,
        $password,
        $settings = array()
    )
    {
        $settings['baseUri'] = $host;
        $settings['userName'] = $username;
        $settings['password'] = $password;

        $client = new Client($settings);

        /** load curl settings */
        if (isset($settings['curlSettings'])) {
            foreach ($settings['curlSettings'] as $curlSettingName => $curlSettingValue) {
                $client->addCurlSetting($curlSettingName, $curlSettingValue);
            }
        }

        /** set from setting WebDav path */

        $adapter = new OwnCloudWebDav($host,$username, $password);


        parent::__construct($adapter);
    }
}

<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;

class AkApi
{
    const VERSION = '1.0.0';

    /**
     * Akbilisim API URI.
     *
     * @todo change the api url
     *
     * @var stringvom
     */
    private $apiUrl = 'https://support.akbilisim.com/api/buzzy/%action%';

    /**
     * Handle API Remove Request.
     *
     * @param string $action Api action. EX: register_product, check_update,....
     * @param array  $args   array of data
     * @param bool   $assoc  json_decode second parameter
     *
     * @throws Exception
     *
     * @return array|false|object array or object on success, false|Exception on failure
     */
    public function handle($action, $args, $assoc = true)
    {
        if (!isset($args['item_id'])) {
            return ['status' => 'error', 'message' => 'Invalid request!'];
        }

        $response = $this->handleRequest($action, $args, $assoc);

        if ($response) {
            if ('error' == $response['status']) {
                 $this->deleteAccessCode($args['item_id']);
            }

            return $response;
        } else {
            return array('status' => 'error', 'message' => 'Cannot connect to api server. Please contact with support');
        }
    }

    /**
     * Handle API Remove Request.
     *
     * @param string $action Api action. EX: register_product, check_update,....
     * @param array  $args   array of data
     * @param bool   $assoc  json_decode second parameter
     *
     * @throws Exception
     *
     * @return array|false|object array or object on success, false|Exception on failure
     */
    private function handleRequest($action, $args, $assoc = true)
    {
        $response = false;

        try {
            $received = $this->fetchData($this->getApiUrl($action, $args));

            if ($received) {
                $response = json_decode($received, $assoc);
            }
        } catch (\Exception $e) {
            //
        }

        return $response;
    }

    /**
     * Fetch a remove url.
     *
     * @param string $endpoint
     *
     * @throws Exception
     *
     * @return string|false string on success or false|Exception on failure.
     */
    private function fetchData($endpoint)
    {
        try {
            $client = new Client;
            $response = $client->get(
                $endpoint,
                [
                    'headers' => [
                        "Accept-Encoding" => "application/json",
                        "Content-Type"    => "application/json",
                        "cache-control"   => "no-cache",
                    ],
                    'timeout' => 30,
                ]
            );

            return (200 == $response->getStatusCode()) ? (string) $response->getBody()->getContents() : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retrieve product registration information.
     *
     * @return string
     */
    public function getApiUrl($action, $args)
    {
        $args = array_merge(
            array(
                'url'        => $this->getSiteUrl(),
                'key'        => rawurlencode($this->getSiteUrl()),
                'activation_url' => $this->getActivationUrl(),
                'item_version' => config('buzzy.version')
            ),
            $args
        );

        $url = str_replace('%action%', $action, $this->apiUrl);

        $output = implode(
            '&',
            array_map(
                function ($v, $k) {
                    return sprintf("%s=%s", $k, $v);
                },
                $args,
                array_keys($args)
            )
        );

        $url = $url . '?' . $output;

        return $url;
    }

    /**
     * Retrieve product registration information.
     *
     * @param string $item_id
     *
     * @return string|bool
     */
    public function getAccessCode($item_id)
    {
        return true;
    }

    /**
     * Retrieve product registration information.
     *
     * @param string $item_id item ıd
     * @param string $code    Purchase Code
     *
     * @return string|bool
     */
    public function registerAccessCode($item_id, $code)
    {
        try {
            file_put_contents(storage_path('.' . $item_id), $code);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Check Access Code.
     *
     * @param string $item_id item ıd
     *
     * @throws Exception
     *
     * @return array|false|object array or object on success, false|Exception on failure
     */
    public function checkAccessCode($item_id = '')
    {
        if ($item_id === '') {
            $item_id = config('buzzy.item_id');
        }

        return is_file(storage_path('.' . $item_id));
    }

    /**
     * Delete Access Code.
     *
     * @param string $item_id item ıd
     *
     * @return bool
     */
    public function deleteAccessCode($item_id)
    {
        if (file_exists(storage_path('.' . $item_id))) {
            @unlink(storage_path('.' . $item_id));
            return true;
        }

        return false;
    }

    /**
     * Retrieve url.
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Retrieve activation url.
     *
     * @return string
     */
    public function getActivationUrl()
    {
        return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}

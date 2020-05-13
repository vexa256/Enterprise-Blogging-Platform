<?php

namespace App\Http\Controllers\Api;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AkProductApi
{
    /**
     * Akbilisim API.
     *
     * @var AkApi
     */
    private $api;

    private $updates = [];

    private $updates_file = 'updates.json';

    public function __construct()
    {
        $this->api = new AkApi;

        if (!$this->api->checkAccessCode()) {
            return false;
        }

        $this->initUpdates();
    }


    /**
     * Register a product.
     *
     * @param int $item_id
     * @param string $code
     *
     * @return array|bool
     */
    public function registerPurchase($item_id, $code)
    {
        // validate the code
        $response = false;

        $args = array(
            'item_id'       => trim($item_id),
            'purchase_code' => trim($code),
        );

        //if (empty($args['purchase_code']) || !$this->validatePurchaseCodeFormat($args['purchase_code'])) {
        if (empty($args['purchase_code'])) {
            return ['status' => 'error', 'message' => 'Please add valid purchase code!'];
        }

        if (empty($args['item_id'])) {
            return ['status' => 'error', 'message' => 'Item id required!'];
        }

        $response = $this->api->handle('register-purchase', $args);

        if ('success' == $response['status'] && isset($response['data']['access_code'])) {
            $this->api->registerAccessCode($args['item_id'], $response['data']['access_code']);
        }

        if (isset($response['data']['package'])) {
            $this->fetchFiles($response['data']['package']);
        }

        return $response;
    }

    /**
     * Register a product.
     *
     * @param int $item_id
     * @param string $code
     *
     * @return array|bool
     */
    public function checkPurchase($code, $item_id)
    {
        // validate the code
        $response = false;

        if (!empty($item_id)) {
            $args = array(
                'item_id'     => trim($item_id),
                'access_code' => trim($code),
            );

            $response = $this->api->handle('check-purchase', $args);
        }

        return $response;
    }

    /**
     * Check a product.
     *
     * @param int $item_id
     *
     * @return array|bool
     */
    public function checkItemPurchase($item_id)
    {
        $response = false;

        if (!empty($item_id)) {
            $args = array(
                'item_id'     => $item_id,
                'access_code' => $this->api->getAccessCode($item_id),
            );

            $response = $this->api->handle('check-purchase', $args);
        }

        return $response;
    }

    /**
     * Check updates.
     *
     * @return array|bool
     */
    public function checkUpdates()
    {
        $item_id = config('buzzy.item_id');

        $args = array(
            'item_id'     => $item_id,
            'access_code' => $this->api->getAccessCode($item_id),
        );

        $response = $this->api->handle('check-update', $args);

        if (!$response || $response['status'] === 'error') {
            return false;
        }

        return $response['data'];
    }

    /**
     * Init updates.
     *
     * @return void|bool
     */
    private function initUpdates()
    {
        if (!empty($this->updates)) {
            return true;
        }

        try {
            if (file_exists(storage_path($this->updates_file))) {
                $update = file_get_contents(storage_path($this->updates_file), true);
                $this->updates = json_decode($update, true);
            }

            $next_check = isset($this->updates['next_check']) ? $this->updates['next_check'] : 0;

            if (!$next_check || $next_check <= Carbon::now()->getTimestamp()) {
                $response = $this->checkUpdates();

                if ($response) {
                    $this->updates = $response;
                    $this->updates['next_check'] = Carbon::now()->addDays(1)->getTimestamp();
                    @file_put_contents(storage_path($this->updates_file), json_encode($this->updates));
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get updates.
     *
     * @return array|bool
     */
    public function getUpdates()
    {
        if (empty($this->updates) || !is_array($this->updates)) {
            return false;
        }

        $current_version = config('buzzy.version');
        $this->updates['current_version'] = $current_version;
        $this->updates['update_required'] = version_compare($this->updates['version'], $current_version, '>');

        // TODO Clean this up
        if ($this->updates['update_required'] && env('APP_ENV') === 'production') {
            set_buzzy_config('APP_ENV', 'local', false);
        }
        return $this->updates;
    }

    /**
     * Retrieve product theme updates.
     *
     * @return array
     */
    public function getThemes()
    {
        if (!isset($this->updates['themes'])) {
            return false;
        }

        $themes = collect($this->updates['themes'])->map(
            function ($theme) {
                $code = $theme['code'];
                $item_id = $theme['item_id'] = isset($theme['item_id']) ? $theme['item_id'] : null;
                $version = isset($theme['version']) ? $theme['version'] : false;

                if (isset($theme['price']) && $theme['price'] !== 'FREE' && $item_id) {
                    $current_version = config($code . '.version');
                    $theme['activation_requied'] = !$this->api->checkAccessCode($item_id);
                    $theme['instaled'] = env($code . '_INSTALLED');
                    $theme['update_required'] = $version && version_compare($version, $current_version, '>');
                } else {
                    $current_version = config('buzzy.themes.' . $code . '.version');
                    $theme['instaled'] = true;
                    $theme['activation_requied'] = false;
                    $theme['update_required'] = false;
                }

                $theme['current_version'] = $current_version;

                $theme['active'] = get_buzzy_config('CurrentTheme') == $theme['code'];

                return $theme;
            }
        )->all();

        return $themes;
    }

    /**
     * Retrieve product plugin updates.
     *
     * @return array
     */
    public function getPlugins()
    {
        if (!isset($this->updates['plugins'])) {
            return false;
        }

        $plugins = collect($this->updates['plugins'])->map(
            function ($plugin) {
                $code = $plugin['code'];
                $item_id = $plugin['item_id'] = isset($plugin['item_id']) ? $plugin['item_id'] : null;
                $version = isset($plugin['version']) ? $plugin['version'] : false;

                if (isset($plugin['price']) && $plugin['price'] !== 'FREE' && $item_id) {
                    $current_version = config($code . '.version');
                    $plugin['activation_requied'] = !$this->api->checkAccessCode($item_id);
                    $plugin['instaled'] = env($code . '_INSTALLED');
                    $plugin['update_required'] = $version && version_compare($version, $current_version, '>');
                } else {
                    $current_version = config('buzzy.plugins.' . $code . '.version');
                    $plugin['instaled'] = true;
                    $plugin['activation_requied'] = false;
                    $plugin['update_required'] = false;
                }

                $plugin['current_version'] = $current_version;
                $plugin['active'] = get_buzzy_config('p_' . $code) == 'on';

                return $plugin;
            }
        )->all();

        return $plugins;
    }

    /**
     * Download a product.
     *
     * @param int $item_id
     * @param string $item_version
     *
     * @return bool
     */
    public function downloadUpdates($item_id, $item_version)
    {
        $args = array(
            'item_id'   => $item_id,
            'item_version' => $item_version,
            'access_code' => $this->api->getAccessCode($item_id),
        );

        try {
            return $this->fetchFiles($this->api->getApiUrl('get-update-download-url', $args));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Fetch download.
     *
     * @param string $zurl
     *
     * @return bool
     */
    public function fetchFiles($zurl)
    {
        try {
            $zip_path = base_path('tmp.zip');
            file_put_contents($zip_path, fopen($zurl, 'r'));
            if (!file_exists($zip_path)) {
                return false;
            }
            $zip = new ZipArchive;
            if (!$zip) {
                return false;
            }
            $zip->open("$zip_path");
            $zip->extractTo(base_path());
            $zip->close();
            @unlink($zip_path);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Check if license key format is valid.
     *
     * license key is version 4 UUID, that have form xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
     * where x is any hexadecimal digit and y is one of 8, 9, A, or B.
     *
     * @param string $purchase_code
     *
     * @return boolean
     */
    public function validatePurchaseCodeFormat($purchase_code)
    {
        $purchase_code = trim($purchase_code);
        $pattern       = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        return (bool) preg_match($pattern, $purchase_code);
    }
}

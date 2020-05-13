<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Api\AkProductApi;

class ActivationController extends Controller
{
    /**
     * Akbilisim Product API.
     *
     * @var AkProductApi
     */
    private $product_api;

    public function __construct()
    {
        $this->product_api = new AkProductApi;
    }

    public function handle(Request $request)
    {
        $item_id = $request->input('item_id');
        $purchase_code = $request->input('code');

        return $this->product_api->registerPurchase($item_id, $purchase_code);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MockingMagician\CoinbaseProSdk\CoinbaseFacade;
use MockingMagician\CoinbaseProSdk\Contracts\Api\ApiInterface;
class BotController extends Controller
{

      public function index(){
        $arr=[];
      $api = CoinbaseFacade::createDefaultCoinbaseApi(
        'https://api.pro.coinbase.com',
        'secret',
        'API_Key',
        'PassWor'
);
        $order = $api->accounts()->list();
        foreach ($order as $o) {
          array_push($arr,(array)$o);
        }
        return $arr;
        }
}

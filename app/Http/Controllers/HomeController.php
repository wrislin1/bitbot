<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MockingMagician\CoinbaseProSdk\CoinbaseFacade;

class HomeController extends Controller
{
    public function index(){
      $btc = $this->getCurrency('BTC');
      $eth = $this->getCurrency('ETH');
      $ltc = $this->getCurrency('LTC');;
      $xlm = $this->getCurrency('XLM');
      $nu = $this->getCurrency('NU');
      $ren = $this->getCurrency('REN');
      $grt = $this->getCurrency('GRT');
      $atom = $this->getCurrency('ATOM');
      $fil = $this->getCurrency('FIL');
      $algo = $this->getCurrency('ALGO');
      $cgld = $this->getCurrency('CGLD');
      $ada = $this->getCurrency('ADA');

      $currencies = ['btc'=>$btc,'eth'=>$eth,'ltc'=>$ltc,'xlm'=>$xlm,'nu'=>$nu,'ren'=>$ren,'grt'=>$grt,'atom'=>$atom,'fil'=>$fil,'algo'=>$algo,'cgld'=>$cgld,'ada'=>$ada];
      return json_encode($currencies);
    //  return $curl;
      return view('home');
    }

    public function getCurrency($coin){
      $m= date("m");
      $de= date("d");
      $y= date("Y");
      $today = date('o-m-d');
      $past = date('o-m-d', mktime(0,0,0,$m,($de-100),$y));
      $url = 'https://api.pro.coinbase.com/products/'.$coin.'-USD/candles?start='.$past.'&end='.$today.'&granularity=86400';
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, $url);
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; Win64; x64; rv:47.0; en-US; rv:1.9.1.2) Gecko/20100101 Firefox/47.0');
      $data = curl_exec($curl_handle);
      curl_close($curl_handle);
      $data = $this->format(json_decode($data));
      return $data;
    }

    public function format($data){
      $formated_data = [];
      foreach ($data as $day) {
        $entry = ['time'=>date('o-m-d',$day[0]),'low'=>$day[1],'high'=>$day[2],'open'=>$day[3],'close'=>$day[4],'volume'=>$day[5]];
        array_push($formated_data,$entry);
      }
      return $formated_data;
    }
}

<?php
date_default_timezone_set('Asia/Tokyo');

#################################################
# API URL
#################################################
$tickers= array(
    "mona_jpy" => array(
        "title"=> "Mona",
        "url" => "https://api.zaif.jp/api/1/ticker/mona_jpy",
        "depth" => "https://api.zaif.jp/api/1/depth/mona_jpy",
    )
);

#################################################
# OPTIONS
#################################################

/* @todo 未実装
 * Alerts
 *
 * "array(
 *    "send_to" => {EMAIL},
 *    "ticker" => {TICKER NAME},
 *    "ticker_key" => {TICKER KEY NAME},
 *    "alert_jpy" => {JPY}
 *    "condition" =>  {"over" or "under"}
 * )"
 */
#$alerts = array(
#    array(
#    "send_to"     => "kotake@moonfactory.co.jp",
#     "ticker"     => "mona_jpy",
#     "ticker_key" => "last",
#     "alert_jpy"  => "89.8",
#     "condition"  => "over"
#    ),
#
#);


#################################################
# EXECUTE
#################################################
foreach($tickers AS $money_name => $array){
    /*
     * 日付
     */
    echo "\n\n\n";
    echo "* ".date("Y-m-d H:i")."\n";
    echo "======================================================\n";

    /*
     * 価格関係
     */
    $text = array();
    $json = json_decode(file_get_contents($array["url"]));
    foreach($json AS $name_key => $price){
        $next = false;
        switch($name_key){
            /* $name => name
             * $price => api value
             * $number => display order
             */
            Case "last":
                $name = "[終値]";
                $price = number_format($price,1);
                $number = 0;
                break;
            Case "bid":
                $name = "[買気]";
                $price = number_format($price,1);
                $number = 1;
                break;
            Case "ask":
                $name = "[売気]";
                $price = number_format($price,1);
                $number = 2;
                break;
            Case "high":
                $name = "過去24時間の高値";
                $price = number_format($price,1);
                $number = 3;
                break;
            Case "low":
                $name = "過去24時間の安値";
                $price = number_format($price,1);
                $number = 4;
                break;
            Case "vwap":
                $name = "過去24時間の加重平均";
                $number = 5;
                break;
            Case "volume ":
                $name = "過去24時間の出来高";
                $number = 6;
                break;
            default :
                $next = true;
                break;
        }
        if($next) continue;

        $text[$number] =  "{$name}: {$price} 円";
    }


    $title = $array["title"];
    asort($text);

    echo "{$title}の価格\n";
    foreach($text AS $l){
        echo $l."\n";
    }

    /*
     * 板
     */
    echo "\n\n板情報\n";
    echo "======================================================\n";
    $json = (array)json_decode(file_get_contents($array["depth"]));

    echo "[買気]\n";
    $asks = $json["asks"];
    for($i=0;$i<=5;$i++){
        echo number_format($asks[$i][0],1) ."     " .number_format($asks[$i][1])."\n";
    }
    echo "\n\n";
    echo "[売気]\n";
    $bids = $json["bids"];
    for($i=0;$i<=5;$i++){
        echo number_format($bids[$i][0],1) ."     " .number_format($bids[$i][1])."\n";
    }


    /*
     * 注文中
     */

    // Unimplemented!
    // @todo Need to install zaif's node.js module...

    /*
     * 取引履歴
     */

    // Unimplemented!
    // @todo Need to install zaif's node.js module...

}


echo "\n...\n";











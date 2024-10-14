<?php

function get_crypto_price(string $ticker): float {
    $url = 'https://cryptoprices.cc/' . strtoupper($ticker);
    $value = (float) file_get_contents($url);

    return $value;
}

function get_investing_price(string $ticker) {
    $url = 'https://www.investing.com/currencies/' . strtolower($ticker) . '-usd';
    $html = file_get_contents($url);
    $pattern = '/data-test="instrument-price-last">([^<]+)<\//';

    if (preg_match($pattern, $html, $matches)) {
        return (float) str_replace(',', '', $matches[1]);
    }

    return -1;
}

$prices = [
    'BTCUSD' => get_crypto_price('BTC'),
    'ETHUSD' => get_crypto_price('ETH'),
    'SOLUSD' => get_crypto_price('SOL'),
    'SUIUSD' => get_crypto_price('SUI'),
    'XRPUSD' => get_crypto_price('XRP'),
    'XAUUSD' => get_investing_price('XAU'),
    'XAGUSD' => get_investing_price('XAG'),
];

file_put_contents(__DIR__ . '/../website/public/finance.json', json_encode($prices));

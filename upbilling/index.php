<?php

error_reporting(0);

include 'config.php';
include 'lib/UnitPayModel.php';
include 'lib/UnitPay.php';

class UnitPayEvent
{
    public function check($params)
    {
        $unitPayModel = UnitPayModel::getInstance();

        if ($unitPayModel->getAccountByName($params['account']))
        {
            return true;
        }
        return 'Character not found';
    }

    public function bonus($amount = 0, $bonuses)
    {
        $total = 0;
        foreach($bonuses as $bonus){
            if($amount >= $bonus['step']){
                $total = floor($amount * $bonus['factor']);
            }
        }


        return ($total > 0) ? $total : $amount;
    }

    public function pay($params)
    {
        $config = include '../protected/config/main.php';
        if($config['unitpay']['enable']){
            $unitPayModel = UnitPayModel::getInstance();
            $countItems = floor($params['sum'] / Config::ITEM_PRICE);
            if($config['payment']['bonus']===true){
                $countItems = $this->bonus($countItems, $config['payment']['bonuses']);
            }
            $unitPayModel->donateForAccount($params['account'], $countItems);
        }
    }
}

$payment = new UnitPay(
    new UnitPayEvent()
);

echo $payment->getResult();
<?php
/**
 * PaymentController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 */

class PaymentController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        if(!CAuth::isGuest()) exit;
    }

    /**
     * Payment resultFk action handler
     */
    public function resultFkAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $amount = $request->getRequest('AMOUNT');
        $sign = $request->getRequest('SIGN');
        $orderId = $request->getRequest('MERCHANT_ORDER_ID');
        $email = $request->getRequest('P_EMAIL');
        $currencyId = $request->getRequest('CUR_ID');

        $resultSign = md5(CConfig::get('freekassa.merchant_id').':'.$amount.':'.CConfig::get('freekassa.secret_key_result').':'.$orderId);
        if($sign == $resultSign){
            $payment = Freekassa::model()->findByPk($orderId);
            if($payment !== null and $payment->status != 1){
                if(CConfig::get('payment.bonus') === true){
                    $payment->result_amount = self::calculateTotalAmount($payment->amount, CConfig::get('payment.bonuses'));
                }else{
                    $payment->result_amount = floor($payment->amount * CConfig::get('payment.value'));
                }

                if(null !== ($user = User::model()->findByPk($payment->account_id))){
                    $user->coins = $user->coins + $payment->result_amount;
                    $user->save();

                    // referral system
                    $rf = CConfig::get('referral.donation');
                    if($rf['enable']===true and $payment->amount >= $rf['amount']){
                        $referral = Referral::model()->findByAttributes(array('follower_id'=>$user->id));
                        if($referral !== null){
                            $referral->follower_total_profit = floor($referral->follower_total_profit + floor($payment->amount * $rf['percent']));
                            $referral->follower_current_profit = floor($referral->follower_current_profit + floor($payment->amount * $rf['percent']));
                            $referral->save();
                        }
                    }
                }

                $payment->email = $email;
                $payment->status = 1;
                $payment->currency_id = $currencyId;
                $payment->complete_date = time();
                $payment->save();

                $this->view->response = 'YES';
            }else{
                $this->view->response = 'ERROR: ALREADY PAID';
            }
        }else{
            $this->view->response = 'ERROR: WRONG SIGN';
        }

        $this->view->render('payment/result', true);
    }

    /**
     * Payment resultWtp action handler
     */
    public function resultWtpAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $amount = $request->getRequest('wOutSum');
        $orderId = $request->getRequest('wInvId');
        $isTest = $request->getRequest('wIsTest');
        $sign = $request->getRequest('wSignature');

        $resultSign = md5(CConfig::get('waytopay.merchant_id').':'.$amount.':'.$orderId.':'.CConfig::get('waytopay.secret_key'));
        if(strtoupper($sign) == strtoupper($resultSign)){
            $payment = Waytopay::model()->findByPk($orderId);
            if($payment !== null and $payment->status != 1){
                if(CConfig::get('payment.bonus') === true){
                    $payment->result_amount = self::calculateTotalAmount($amount, CConfig::get('payment.bonuses'));
                }else{
                    $payment->result_amount = $amount * CConfig::get('payment.value');
                }

                if($isTest !== 1){
                    if(null !== ($user = User::model()->findByPk($payment->account_id))){
                        $user->coins = floor($user->coins + $payment->result_amount);
                        $user->save();

                        // referral system
                        $rf = CConfig::get('referral.donation');
                        if($rf['enable']===true and $payment->amount >= $rf['amount']){
                            $referral = Referral::model()->findByAttributes(array('follower_id'=>$user->id));
                            if($referral !== null){
                                $referral->follower_total_profit = floor($referral->follower_total_profit + floor($payment->amount * $rf['percent']));
                                $referral->follower_current_profit = floor($referral->follower_current_profit + floor($payment->amount * $rf['percent']));
                                $referral->save();
                            }
                        }
                    }
                }else{
                    $this->view->response = 'TEST REQUEST';
                }

                $payment->status = 1;
                $payment->complete_date = time();
                $payment->save();

                $this->view->response = 'OK_'.$orderId;
            }else{
                $this->view->response = 'ERROR: ALREADY PAID';
            }
        }else{
            $this->view->response = 'ERROR: WRONG SIGN';
        }

        $this->view->render('payment/result', true);
    }

    /**
     * Payment resultPw action handler
     */
    public function resultPwAction()
    {
        require_once(APP_PATH . '/application/vendors/Paymentwall/Base.php');
        require_once(APP_PATH . '/application/vendors/Paymentwall/Pingback.php');

        Paymentwall_Base::setApiType(Paymentwall_Base::API_VC);
        Paymentwall_Base::setAppKey(CConfig::get('paymentwall.app_key'));
        Paymentwall_Base::setSecretKey(CConfig::get('paymentwall.secret_key'));

        $pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
        if($pingback->validate()){
            $userId = $pingback->getUserId();
            $virtualCurrency = $pingback->getVirtualCurrencyAmount();
            if($pingback->isDeliverable()){
                if(CConfig::get('payment.bonus') === true){
                    $result_amount = self::calculateTotalAmount($virtualCurrency, CConfig::get('payment.bonuses'));
                }else{
                    $result_amount = $virtualCurrency * CConfig::get('payment.value');
                }
                if(null !== ($user = User::model()->findByPk($userId))){
                    $user->coins = floor($user->coins + $result_amount);
                    $user->save();

                    // referral system
                    $rf = CConfig::get('referral.donation');
                    if($rf['enable']===true and $virtualCurrency >= $rf['amount']){
                        $referral = Referral::model()->findByAttributes(array('follower_id'=>$user->id));
                        if($referral !== null){
                            $referral->follower_total_profit = floor($referral->follower_total_profit + floor($virtualCurrency * $rf['percent']));
                            $referral->follower_current_profit = floor($referral->follower_current_profit + floor($virtualCurrency * $rf['percent']));
                            $referral->save();
                        }
                    }
                }
            }elseif($pingback->isCancelable()){
                //withdraw the virtual currency
            }

            $this->view->response = 'OK';
        } else {
            $this->view->response = $pingback->getErrorSummary();
        }

        $this->view->render('payment/result', true);
    }

    /**
     * @param $amount
     * @param $bonuses
     * @return float
     */
    private static function calculateTotalAmount($amount, $bonuses)
    {
        $total = 0;
        if(!empty($bonuses)){
            foreach($bonuses as $bonus){
                if($amount >= $bonus['step']){
                    $total = floor($amount * $bonus['factor']);
                }
            }
        }

        return ($total > 0) ? floor($total * CConfig::get('payment.value', 1)) : floor($amount * CConfig::get('payment.value', 1));
    }
}
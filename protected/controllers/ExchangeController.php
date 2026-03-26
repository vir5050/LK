<?php
/**
 * ExchangeController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class ExchangeController extends CController
{
    /** @var mixed */
    protected $apiUrl;

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->view->errorField = '';
        $this->view->actionMessage = '';

        CAuth::handleLogin('user/login');

        $this->apiUrl = CConfig::get('apiUrl');
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        $this->redirect('index/index');
    }

    /**
     * Exchange cubigold action handler
     */
    public function cubigoldAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $exchange = Exchange::model()->findByAttributes(array('account_id'=>CAuth::getLoggedId(), 'type'=>'gold'));
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'exchangegold'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $count = $request->getPost('count', 'integer', 0);
                    $result = CWidget::create('CFormValidation', array(
                        'fields'=>array(
                            'count'=>array('title'=>My::t('app', 'Count'), 'validation'=>array('required'=>true, 'type'=>'integer'))
                        )
                    ));

                    if($result['error']){
                        $msg = $result['errorMessage'];
                        $messageType = 'validation';
                        $this->view->errorField = $result['errorField'];
                    }elseif($count < $service->min){
                        $msg = My::t('core', 'The field {title} must be greater than or equal to {min}!', array('{title}'=>My::t('app', 'Count'), '{min}'=>$service->min));
                        $messageType = 'error';
                    }else{
                        if($exchange===null){
                            $exchange = new Exchange;
                            $exchange->account_id = CAuth::getLoggedId();
                            $exchange->date = time();
                            $exchange->count = 0;
                            $exchange->type = 'gold';
                        }

                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        $price = round($count * $service->price);
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            if(($exchange->date + 86400) > time() and $exchange->count == $service->max){
                                $msg = My::t('app', 'Per one day you can only buy {max} gold', array('{max}'=>$this->view->_max));
                                $messageType = 'error';
                            }else{
                                if($exchange->count == $service->max){
                                    $exchange->count = 0;
                                }

                                if($count > $service->max){
                                    $msg = My::t('app', 'Max. count').' - '.$this->view->_max;
                                    $messageType = 'error';
                                }elseif(($count + $exchange->count) > $service->max){
                                    $msg = My::t('app', 'Max. count').' - '.$this->view->_max;
                                    $messageType = 'error';
                                }else{
                                    /** @var CCurl $curl */
                                    $curl = My::app()->getCurl();
                                    $result = $curl->run($this->apiUrl.'user/cubigold', array(
                                        'id'=>$user->user_id,
                                        'count'=>round($count * 2.5)
                                    ))->getData(true);

                                    if($result['status']==1){
                                        $exchange->date = time();
                                        $exchange->count = $exchange->count + $count;
                                        if($exchange->save()){
                                            $log = new ServiceLog;
                                            $log->account_id = CAuth::getLoggedId();
                                            $log->service_id = My::t('app', 'Exchange of MyWeb coins for cubigold');
                                            $log->ip_address = CIp::getBinaryIp();
                                            $log->request_date = time();
                                            $log->request_data = json_encode(array('count'=>$count, 'price'=>$price));
                                            $log->save();

                                            $user->coins = $user->coins - $price;
                                            $user->save();

                                            $this->view->_current = $this->view->_max - $exchange->count;

                                            $msg = My::t('app', 'Successfully');
                                            $messageType = 'success';
                                        }else{
                                            $msg = My::t('app', 'Failed');
                                            $messageType = 'warning';
                                        }
                                    }else{
                                        $msg = My::t('app', 'Failed');
                                        $messageType = 'warning';
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->view->max = $service->max;
            $this->view->price = $service->price;
            $this->view->repeat = null;
            if(($exchange->date + 86400) > time() and $exchange->count == $service->max){
                $this->view->repeat = CTime::makePretty($exchange->date + 86400);
                $this->view->current = 0;
            }else{
                $this->view->current = $this->view->max - ($exchange->count == $service->max ? 0 : $exchange->count);
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Exchange of MyWeb coins for cubigold'));
        $this->view->render('exchange/cubigold', $request->isAjaxRequest());
    }
}
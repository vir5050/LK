<?php
/**
 * VoteratingController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class VoteratingController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        $this->redirect('index/index');
    }

    /**
     * Voterating mmotop action handler
     */
    public function mmotopAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Mmotop $model */
        $model = Mmotop::model();
        $mmotop = MmotopSettings::model()->findByPk(1);

        $key = $request->getQuery('key');
        if(!strcasecmp($key, CConfig::get('installationKey'))){
            $db = CDatabase::init();

            set_time_limit(0);

            $pointer = ($mmotop->reference_date !== '' ? strtotime($mmotop->reference_date) : 0);
            $logs = file($mmotop->logs);
            foreach($logs as $line){
                $buffer = explode("\t", $line);
                if(count($buffer) >= 4){
                    $id = $buffer[0];
                    $date = $buffer[1];
                    $ip = $buffer[2];
                    $name = $buffer[3];
                    $name = strtolower($name);
                    $type = trim($buffer[4]);

                    if(strtotime($date) > $pointer){
                        echo '['.$date.'] '.$name;
                        if(CValidator::isMixed($name)){
                            if($type == 1 and $mmotop->catch_cheaters){
                                /*$countIp = $model->countByAttributes(array('ip'=>$ip), "date like '%{$day}%'");
                                $countLogin = $model->countByAttributes(array('name'=>$name), "date like '%{$day}%'");*/

                                $countIp = $db->select('
                                    SELECT COUNT(*) as cnt
                                    FROM mw_mmotop
                                    WHERE ip = \''.$ip.'\' AND date like \'%'.substr($date, 0, 10).'%\'
                                ');
                                $countLogin = $db->select('
                                    SELECT COUNT(*) as cnt
                                    FROM mw_mmotop
                                    WHERE name = \''.$name.'\' AND date like \'%'.substr($date, 0, 10).'%\'
                                ');
                            }else{
                                /*$countLogin = $model->countByAttributes(array('name'=>$name, 'date'=>$date));*/
                                $countLogin = $db->select('
                                    SELECT COUNT(*) as cnt
                                    FROM mw_mmotop
                                    WHERE name = \''.$name.'\' AND date = \''.$date.'\'
                                ');
                            }

                            if(isset($countIp) and $countIp[0]['cnt'] > 0){
                                echo " - max votes from ip {$ip}<br />";
                            }elseif(isset($countLogin) and $countLogin[0]['cnt'] > 0){
                                echo " - max votes (1) from login<br />";
                            }else{
                                /** @var User $user */
                                $user = User::model()->findByAttributes(array('username'=>$name));
                                if($user !== null){
                                    $db->insert('mmotop', array(
                                        'top_id'=>$id,
                                        'date'=>$date,
                                        'ip'=>$ip,
                                        'name'=>$name,
                                        'type'=>$type
                                    ));

                                    /*$model = new Mmotop;
                                    $model->top_id = $id;
                                    $model->date = $date;
                                    $model->ip = $ip;
                                    $model->name = $name;
                                    $model->type = $type;
                                    $model->save();*/

                                    if($type == 1){
                                        $coins = $mmotop->coins_common;
                                    }else{
                                        $coins = $mmotop->coins_sms;
                                    }

                                    if($mmotop->encourage_item == 1){
                                        if($type == 1){
                                            $data = array(
                                                'type'=>'store',
                                                'store_id'=>$mmotop->common_item_id,
                                                'item_count'=>$mmotop->common_item_count,
                                            );
                                        }else{
                                            $data = array(
                                                'type'=>'store',
                                                'store_id'=>$mmotop->sms_item_id,
                                                'item_count'=>$mmotop->sms_item_count,
                                            );
                                        }

                                        /*$notice = new Notice;
                                        $notice->account_id = $user->id;
                                        $notice->title = My::t('app', 'New item');
                                        $notice->message = My::t('app', 'Encouraging Vote');
                                        $notice->obtain_date = time();
                                        $notice->notice_data = json_encode($data);
                                        $notice->save();*/

                                        if(!empty($data['store_id'])){
                                            $db->insert('notice', array(
                                                'account_id' => $user->id,
                                                'title' => My::t('app', 'New item'),
                                                'message' => My::t('app', 'Encouraging Vote'),
                                                'obtain_date' => time(),
                                                'notice_data' => json_encode($data)
                                            ));
                                        }
                                    }

                                    $user->coins = $user->coins + $coins;
                                    if($user->save()){
                                        echo " - received {$coins} coins<br />";
                                    }else{
                                        echo " - database error<br />";
                                    }
                                }else{
                                    echo " - not found<br />";
                                }
                            }
                        }else{
                            echo " - incorrect<br />";
                        }
                    }
                }
            }
        }
        exit;
    }
}
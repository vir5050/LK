<?php
/**
 * BattlemapController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class BattlemapController extends CController
{
    public static $colors = array(
        1  => array('R'=>255, 'G'=>0,   'B'=>0),
        2  => array('R'=>0,   'G'=>255, 'B'=>0),
        3  => array('R'=>255, 'G'=>127, 'B'=>0),
        4  => array('R'=>0,   'G'=>255, 'B'=>255),
        5  => array('R'=>255, 'G'=>255, 'B'=>0),
        6  => array('R'=>255, 'G'=>0,   'B'=>255),
        7  => array('R'=>212, 'G'=>127, 'B'=>255),
        8  => array('R'=>245, 'G'=>152, 'B'=>157),
        9  => array('R'=>253, 'G'=>198, 'B'=>137),
        10 => array('R'=>0,   'G'=>174, 'B'=>239),
        11 => array('R'=>170, 'G'=>223, 'B'=>0),
        12 => array('R'=>255, 'G'=>191, 'B'=>0),
        13 => array('R'=>42,  'G'=>255, 'B'=>170),
        14 => array('R'=>255, 'G'=>255, 'B'=>170),
        15 => array('R'=>127, 'G'=>31,  'B'=>255),
        16 => array('R'=>212, 'G'=>255, 'B'=>255),
        17 => array('R'=>42,  'G'=>127, 'B'=>255),
        18 => array('R'=>145, 'G'=>135, 'B'=>255),
        19 => array('R'=>172, 'G'=>211, 'B'=>115),
        20 => array('R'=>0,   'G'=>191, 'B'=>170),
        21 => array('R'=>255, 'G'=>204, 'B'=>255),
        22 => array('R'=>242, 'G'=>109, 'B'=>125),
        23 => array('R'=>170, 'G'=>255, 'B'=>170),
        24 => array('R'=>170, 'G'=>191, 'B'=>255),
        25 => array('R'=>212, 'G'=>223, 'B'=>255),
        26 => array('R'=>85,  'G'=>159, 'B'=>0),
        27 => array('R'=>152, 'G'=>134, 'B'=>117),
        28 => array('R'=>212, 'G'=>31,  'B'=>85),
        39 => array('R'=>170, 'G'=>127, 'B'=>0),
        40 => array('R'=>212, 'G'=>191, 'B'=>85),
        41 => array('R'=>192, 'G'=>128, 'B'=>128),
        42 => array('R'=>0,   'G'=>127, 'B'=>0),
        43 => array('R'=>255, 'G'=>191, 'B'=>170),
        44 => array('R'=>127, 'G'=>159, 'B'=>170),
        45 => array('R'=>212, 'G'=>63,  'B'=>170),
        46 => array('R'=>168, 'G'=>99,  'B'=>168),
        47 => array('R'=>212, 'G'=>191, 'B'=>170),
        48 => array('R'=>171, 'G'=>160, 'B'=>0),
        49 => array('R'=>117, 'G'=>76,  'B'=>35),
        51 => array('R'=>157, 'G'=>0,   'B'=>56),
        52 => array('R'=>102, 'G'=>44,  'B'=>145),
        53 => array('R'=>85,  'G'=>116, 'B'=>185),
        54 => array('R'=>0,   'G'=>0,   'B'=>255),
        55 => array('R'=>85,  'G'=>95,  'B'=>0),
    );
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
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $cache = CCache::getContent(md5('battlemap').'.cch', 86400);
        if(!$cache){
            $result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/battlemap')->getData(true);
            $zones = $result['data'];
            if(!empty($zones)){
                foreach ($zones as $key => $value) {
                    $zones[$key]['name'] = My::t('dungeon', 'cities.' . $value['id']);
                    $zones[$key]['challenge_time'] = CTime::makePretty($zones[$key]['challenge_time'], 'abbreviated');
                    $zones[$key]['color'] = 'rgb('.self::$colors[$value['color']]['R'].', '.self::$colors[$value['color']]['G'].', '.self::$colors[$value['color']]['B'].')';
                }
                CCache::setContent($zones);
            }
        }else{
            $zones = $cache;
        }

        $this->view->zones = $zones;
        $this->view->render('battlemap/index', $request->isAjaxRequest());
    }
}
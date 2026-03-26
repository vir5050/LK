<?php
/**
 * Promocode
 *
 * PUBLIC:                PROTECTED               PRIVATE
 * ---------------        ---------------         ---------------
 * __construct
 *
 * STATIC:
 * ------------------------------------------
 * model
 *
 */
class Promocode extends CActiveRecord
{

    /** @var string */
    protected $_table = 'promocodes';

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CActiveRecord class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function isUsed()
    {
        $check = CDatabase::init()->select('
            SELECT COUNT(*) as count
            FROM '.CConfig::get('db.prefix').'promocode_to_user
            WHERE user_id = :user AND promocode_id = :promocode
        ', [
            ':user'=>CAuth::getLoggedId(),
            ':promocode'=>$this->id
        ], PDO::FETCH_COLUMN);

        return (!empty($check[0]) ? true : false);
    }

    public function isActivated()
    {
        $check = CDatabase::init()->select('
            SELECT COUNT(*) as count
            FROM '.CConfig::get('db.prefix').'promocode_to_user
            WHERE promocode_id = :promocode
        ', [
            ':promocode'=>$this->id
        ], PDO::FETCH_COLUMN);

        return (!empty($check[0]) ? true : false);
    }

    public function activate()
    {
        $result = CDatabase::init()->insert('promocode_to_user', ['user_id'=>CAuth::getLoggedId(), 'promocode_id'=>$this->id, 'activated_at'=>time()]);

        if (!$this->reusable) {
            $this->status = 2;
            $this->save();
        }

        return $result===false ? false : true;
    }
}
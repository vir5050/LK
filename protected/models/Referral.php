<?php
/**
 * Referral
 *
 * PUBLIC:				PROTECTED			   PRIVATE
 * ---------------		---------------		 ---------------
 * __construct
 *
 * STATIC:
 * ------------------------------------------
 * model
 *
 */
class Referral extends CActiveRecord
{
    /** @var string */
    protected $_table = 'referral_system';

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
}

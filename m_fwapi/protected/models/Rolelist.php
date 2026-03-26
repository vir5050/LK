<?php
/**
 * Rolelist
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
class Rolelist extends CActiveRecord
{
    /** @var string */
    protected $_table = 'mw_roles';

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
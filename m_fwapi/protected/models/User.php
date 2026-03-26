<?php

/**
 * User model
 *
 * PUBLIC:                PROTECTED               PRIVATE
 * ---------------        ---------------         ---------------
 * __construct
 *
 * STATIC:
 * ------------------------------------------
 *
 */
class User extends CModel
{
    /** @var string */
    protected $_table = 'users';
    /** @var string*/
    protected static $adduser = "call adduser('{name}','{passwd}','0','0','0','0','{email}','0','0','0','','0','1','0','','','{passwd}');";
    /** @var string */
    protected static $usecash = "call usecash({userid},{zoneid},0,{aid},0,{count},1,@error);";
	/** @var string */
    protected static $addGM = "call addGM({userid},{zoneid});";
	/** @var string */
    protected static $delUserPriv = "call delUserPriv({userid},{zoneid},{rid},{deltype});";

    const GETUSERROLES = 0xD49;

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * User get by id
     * @param $id
     * @return array|bool
     */
    public function getUserById($id)
    {
        $result = $this->db->select('
            SELECT *
            FROM '.$this->_table.'
            WHERE ID = :ID',
            [
                ':ID' => $id
            ]
        );

        return !empty($result) ? $result[0] : null;
    }

    /**
     * User get by name
     * @param $name
     * @return array|bool
     */
    public function getUserByName($name)
    {
        $result = $this->db->select('
            SELECT *
            FROM '.$this->_table.'
            WHERE name = :name',
            [
                ':name' => $name
            ]
        );

        return !empty($result) ? $result[0] : null;
    }

    /**
     * User update
     * @param $id
     * @param $params
     * @return bool
     */
    public function updateUser($id, array $params)
    {
        return $this->db->update($this->_table, $params, 'ID = '.(int)$id);
    }

    /**
     * Call adduser
     * @param $name
     * @param $passwd
     * @param $email
     * @return array|bool
     */
    public function addUser($name, $passwd, $email)
    {
        return $this->db->customExec(strtr(self::$adduser, [
            '{name}'=>$name,
            '{passwd}'=>$passwd,
            '{email}'=>$email
        ]));
    }

    /**
     * Call usecash
     * @param $id
     * @param $count
     * @return array|bool
     */
    public function addCash($id, $count)
    {
        return $this->db->customExec(strtr(self::$usecash, [
            '{userid}'=>$id,
            '{zoneid}'=>CConfig::get('server.zoneid'),
            '{aid}'=>CConfig::get('server.aid'),
            '{count}'=>$count
        ]));
    }

    public static function roles($userId)
    {
        $version = CConfig::get('server.version');
		$protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::GETUSERROLES, [
            'retcode'=>-1,
            'userid'=>$userId
        ], [
            'retcode'=>'int',
            'userid'=>'int'
        ], true)->read([
            'max'=>'int',
            'retcode'=>'int',
            'roles_count'=>'vector',
            'roles'=>[
                'id'=>'int64',
                'name'=>'string'
            ]
        ]);

        return isset($result['roles']) ? $result['roles'] : null;
    }

    /**
     * Call addGM
     * @param $name
     * @param $passwd
     * @param $email
     * @return array|bool
     */
    public static function addGM($userId)
    {
        CDatabase::init()->customExec(strtr(self::$addGM, [
            '{userid}'=>$userId,
            '{zoneid}'=>CConfig::get('server.zoneid')
        ]));
		
		return true;
    }

    /**
     * Call addUserPriv
     * @param $name
     * @param $passwd
     * @param $email
     * @return array|bool
     */
    public static function addUserPriv($userId)
    {
        // TODO
    }

    /**
     * Call delUserPriv
     * @param $name
     * @param $passwd
     * @param $email
     * @return array|bool
     */
    public static function delUserPriv($userId, $rid, $delType)
    {
        CDatabase::init()->customExec(strtr(self::$delUserPriv, [
            '{userid}'=>$userId,
            '{zoneid}'=>CConfig::get('server.zoneid'),
            '{rid}'=>$rid,
            '{deltype}'=>$delType
        ]));

		return true;
    }
}
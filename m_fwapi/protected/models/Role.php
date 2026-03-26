<?php

/**
 * Role
 *
 * PUBLIC:				PROTECTED			   PRIVATE
 * ---------------		---------------		 ---------------
 * __construct
 * getData
 * putData
 * info
 * rid2uid
 * clearStorehousePasswd
 * roleId
 * rename
 * kickout
 * shutup
 * faction
 *
 * STATIC:
 * ------------------------------------------
 * model
 */
class Role extends CActiveRecord
{
    /** @var string */
    protected $_table = 'mw_roles';
	
	/** @var array */
    public static $_opcodesGetRole = [
        'base'       => 0xBC5,
        'status'     => 0xBC7,
        'pocket'     => 0xBC9,
        'storehouse' => 0xBD3,
        'task'       => 0xBCB,
    ];

    const PUTROLEDATA = 0x1F46;
    const GETROLEDATA = 0x1F43;
    const GETROLEINFO = 0xBEB;
    const ROLEID2UID  = 0xD54;
    const CLEARSTOREHOUSEPASSWD = 0xD4A;
    const GETROLEID = 0xBD9;
    const QUERYUSERID = 0x1F41;
    const RENAMEROLE = 0xD4C;
    const RENAMEROLE_OLD = 0xBE4;
    const GMFORBIDROLE = 0x16E;
    const GETFRIENDLIST = 0xC9;
    const GETUSERFACTION = 0x11FF;
    const DBPLAYERPOSITIONRESET = 0xC26;
    const DBDELETEROLE = 0xBC0;
    const PRIVATECHAT = 0x60;
    const GETROLE = 0xBBD;


    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CActiveRecord class
     * @param string $className
     * @return
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function GetRole($roleId)
    {
        $role = [];
        $protocol = My::app()->getProtocol();
        $version = CConfig::get('server.version');
        $structure = $protocol->loadStructure($version);
        $protocol->connect2gamedbd();
            $result = $protocol->write(self::GETROLEDATA, [
                'retcode'=>-1,
                'roleid'=>$roleId
            ], [
                'retcode'=>'int',
                'roleid'=>'int64'
            ], true)->read([
                'max'=>'int',
                'retcode'=>'int',
                'value'=>$structure['role']
            ]);

            $role = $result['value'];

        return $role;
    }

    public static function PutRole($roleId, array $role)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $version = CConfig::get('server.version');
        $structure = $protocol->loadStructure($version);
        $protocol->write(self::PUTROLEDATA, [
                'retcode'=>-1,
                'roleid'=>$roleId,
                'overwrite'=>1,
                'value'=>$role
            ], [
                'retcode'=>'int',
                'roleid'=>'int64',
                'overwrite'=>'byte',
                'value'=>$structure['role']
            ]);

        return true;
    }

    public static function Roleid2Uid($roleId)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::ROLEID2UID, [
            'retcode'=>-1,
            'roleid'=>$roleId
        ], [
            'retcode'=>'int',
            'roleid'=>'int'
        ])->read([
            'max'=>'int',
            'retcode'=>'int',
            'userid'=>'int'
        ]);

        return !empty($result['userid']) ? $result['userid'] : null;
    }

    public static function ClearStorehousePasswd($roleId, $roleName)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $protocol->write(self::CLEARSTOREHOUSEPASSWD, [
            'retcode'=>-1,
            'roleid'=>$roleId,
            'rolename'=>$roleName,
            'reserved'=>''
        ], [
            'retcode'=>'int',
            'roleid'=>'int',
            'rolename'=>'string',
            'reserved'=>'octets'
        ]);

        return true;
    }

    public static function GetRoleId($roleName)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::GETROLEID, [
            'retcode'=>-1,
            'rolename'=>$roleName,
            'reason'=>1
        ], [
            'retcode'=>'int',
            'rolename'=>'string',
            'reason'=>'byte'
        ])->read([
            'max'=>'int',
            'retcode'=>'int',
            'roleid'=>'int'
        ]);

        $version = explode('.', CConfig::get('server.version'));
        if($version[1] < 62){
            $temp = unpack('l', pack('N', $result['roleid']));
            $result['roleid'] = $temp[1];
        }

        return $result['roleid'];
    }

    public static function QueryUserId($roleName)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::QUERYUSERID, [
            'retcode'=>-1,
            'rolename'=>$roleName
        ], [
            'retcode'=>'int',
            'rolename'=>'string'
        ])->read([
            'retcode'=>'int',
            'result'=>'int',
            'userid'=>'int',
            'roleid'=>'int',
            'level'=>'int'
        ]);

        return ($result['result']===0) ? $result : 0;
    }

    public static function RenameRole($roleId, $oldName, $newName)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $protocol->write((CConfig::get('server.version') == 'pw.07' ? self::RENAMEROLE_OLD : self::RENAMEROLE), [
            'retcode'=>-1,
            'roleid'=>$roleId,
            'oldname'=>$oldName,
            'newname'=>$newName
        ], [
            'retcode'=>'int',
            'roleid'=>'int',
            'oldname'=>'string',
            'newname'=>'string'
        ]);

        return true;
    }

    public static function GMForbidRole($fbd_type, $roleId, $time, $reason, $gm)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2delivery();
        $protocol->write(self::GMFORBIDROLE, [
            'fbd_type'=>$fbd_type,
            'gmroleid'=>$gm,
            'localsid'=>rand(9999, 99999),
            'dstroleid'=>$roleId,
            'forbid_time'=>$time,
            'reason'=>$reason
        ], [
            'fbd_type'=>'byte',
            'gmroleid'=>'int',
            'localsid'=>'int',
            'dstroleid'=>'int',
            'forbid_time'=>'int',
            'reason'=>'string'
        ]);

        return true;
    }

    public static function UserFaction($roleId)
    {
        $protocol = My::app()->getProtocol();
        $structure = $protocol->loadStructure(CConfig::get('server.version'));
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::GETUSERFACTION, [
            'retcode'=>-1,
            'reason'=>1,
            'roleid'=>$roleId
        ], [
            'retcode'=>'int',
            'reason'=>'int',
            'roleid'=>'int'
        ])->read([
            'max'=>'int',
            'retcode'=>'int',
            'UserFaction'=>$structure['UserFaction']
        ]);

        return ($result['retcode']===0 ? $result['UserFaction'] : null);
    }

    public static function DBPlayerPositionReset($roleId, $worldtag, $pos_x, $pos_y, $pos_z)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::DBPLAYERPOSITIONRESET, [
            'retcode'=>-1,
            'roleid'=>$roleId,
            'worldtag'=>$worldtag,
            'pos_x'=>$pos_x,
            'pos_y'=>$pos_y,
            'pos_z'=>$pos_z
        ],[
            'retcode'=>'int',
            'roleid'=>'int',
            'worldtag'=>'int',
            'pos_x'=>'float',
            'pos_y'=>'float',
            'pos_z'=>'float',
        ])->read([
            'max'=>'int',
            'retcode'=>'int'
        ]);

        return ($result['retcode']===0) ? true : false;
    }

    public static function DBDeleteRole($roleId, $create_rollback = 0)
    {
        $protocol = My::app()->getProtocol();
        $protocol->connect2gamedbd();
        $result = $protocol->write(self::DBDELETEROLE, [
            'retcode'=>-1,
            'roleid'=>$roleId,
            'create_rollback'=>$create_rollback
        ],[
            'retcode'=>'int',
            'roleid'=>'int',
            'create_rollback'=>'byte'
        ])->read([
            'max'=>'int',
            'retcode'=>'int',
            'userid'=>'int',
            'rolelist'=>'int',
            'faction'=>'int',
            'rolename'=>'string',
        ]);

        return $result;
    }
}

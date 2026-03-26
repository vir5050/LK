-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 29 2020 г., 10:49
-- Версия сервера: 5.5.62-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `fw`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `acquireuserpasswd`(in name1 VARCHAR(64), out uid1 INTEGER, out passwd1 VARCHAR(64))
BEGIN
    SELECT id, passwd INTO uid1, passwd1 FROM users WHERE name = name1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addForbid`(in userid1 INTEGER, in type1 INTEGER, in forbid_time1 INTEGER, in reason1 BINARY(255), in gmroleid1 INTEGER)
BEGIN
 DECLARE rowcount INTEGER;
  START TRANSACTION;
    UPDATE forbid SET ctime = now(), forbid_time = forbid_time1, reason = reason1, gmroleid = gmroleid1 WHERE userid = userid1 AND type = type1;
    SET rowcount = ROW_COUNT();
    IF rowcount = 0 THEN
      INSERT INTO forbid VALUES(userid1, type1, now(), forbid_time1, reason1, gmroleid);
    END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addGM`(in userid INTEGER, in zoneid INTEGER)
BEGIN
  DECLARE x INTEGER;
  START TRANSACTION;
    SET x = 0;
    WHILE x < 12 DO
      INSERT INTO auth VALUES (userid, zoneid, x);
      SET x = x + 1;
    END WHILE;
    SET x = 100;
    WHILE x < 106 DO
      INSERT INTO auth VALUES (userid, zoneid, x);
      SET x = x + 1;
    END WHILE;
    SET x = 200;
    WHILE x < 215 DO
      INSERT INTO auth VALUES (userid, zoneid, x);
      SET x = x + 1;
    END WHILE;
    SET x = 500;
    WHILE x < 519 DO
      INSERT INTO auth VALUES (userid, zoneid, x);
      SET x = x + 1;
    END WHILE;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `adduser`(
  in name1 VARCHAR(64),
  in passwd1 VARCHAR(64),
  in prompt1 VARCHAR(32),
  in answer1 VARCHAR(32),
  in truename1 VARCHAR(32),
  in idnumber1 VARCHAR(32),
  in email1 VARCHAR(32),
  in mobilenumber1 VARCHAR(32),
  in province1 VARCHAR(32),
  in city1 VARCHAR(32),
  in phonenumber1 VARCHAR(32),
  in address1 VARCHAR(64),
  in postalcode1 VARCHAR(8),
  in gender1 INTEGER,
  in birthday1 VARCHAR(32),
  in qq1 VARCHAR(32),
  in passwd21 VARCHAR(64)
)
BEGIN
  DECLARE idtemp INTEGER;
    SELECT IFNULL(MAX(id), 1008) + 16 INTO idtemp FROM users;
    INSERT INTO users (id,name,passwd,prompt,answer,truename,idnumber,email,mobilenumber,province,city,phonenumber,address,postalcode,gender,birthday,creatime,qq,passwd2) VALUES( idtemp, name1, passwd1, prompt1, answer1, truename1, idnumber1, email1, mobilenumber1, province1, city1, phonenumber1, address1, postalcode1, gender1, birthday1, now(), qq1, passwd21 );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `adduserpoint`(in uid1 INTEGER, in aid1 INTEGER, in time1 INTEGER)
BEGIN
 DECLARE rowcount INTEGER;
 START TRANSACTION;
    UPDATE point SET time = IFNULL(time,0) + time1 WHERE uid1 = uid AND aid1 = aid;
    SET rowcount = ROW_COUNT();
    IF rowcount = 0 THEN
      INSERT INTO point (uid,aid,time) VALUES (uid1,aid1,time1);
    END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addUserPriv`(in userid INTEGER, in zoneid INTEGER, in rid INTEGER)
BEGIN
  START TRANSACTION;
    INSERT INTO auth VALUES(userid, zoneid, rid);
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `changePasswd`(in name1 VARCHAR(64), in passwd1 VARCHAR(64))
BEGIN
  START TRANSACTION;
    UPDATE users SET passwd = passwd1 WHERE name = name1;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `changePasswd2`(in name1 VARCHAR(64), in passwd21 VARCHAR(64))
BEGIN
  START TRANSACTION;
    UPDATE users SET passwd2 = passwd21 WHERE name = name1;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearonlinerecords`(in zoneid1 INTEGER, in aid1 INTEGER)
BEGIN
  START TRANSACTION;
    UPDATE point SET zoneid = NULL, zonelocalid = NULL WHERE aid = aid1 AND zoneid = zoneid1;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteTimeoutForbid`(in userid1 INTEGER)
BEGIN
  START TRANSACTION;
    DELETE FROM forbid WHERE userid = userid1 AND timestampdiff(second, ctime, now()) > forbid_time;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delUserPriv`(in userid1 INTEGER, in zoneid1 INTEGER, in rid1 INTEGER, in deltype1 INTEGER)
BEGIN
START TRANSACTION;
  IF deltype1 = 0 THEN
    DELETE FROM auth WHERE userid = userid1 AND zoneid = zoneid1 AND rid = rid1;
  ELSE
    IF deltype1 = 1 THEN
      DELETE FROM auth WHERE userid = userid1 AND zoneid = zoneid1;
    ELSE
      IF deltype1 = 2 THEN
        DELETE FROM auth WHERE userid = userid1;
      END IF;
    END IF;
  END IF;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `enableiplimit`(in uid1 INTEGER, in enable1 CHAR(1))
BEGIN
  DECLARE rowcount INTEGER;
  START TRANSACTION;
  UPDATE iplimit SET enable=enable1 WHERE uid=uid1;
  SET rowcount = ROW_COUNT();
  IF rowcount = 0 THEN
    INSERT INTO iplimit (uid,enable) VALUES (uid1,enable1);
  END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `lockuser`(in uid1 INTEGER, in lockstatus1 CHAR(1))
BEGIN
  DECLARE rowcount INTEGER;
  START TRANSACTION;
  UPDATE iplimit SET lockstatus=lockstatus1 WHERE uid=uid1;
  SET rowcount = ROW_COUNT();
  IF rowcount = 0 THEN
    INSERT INTO iplimit (uid,lockstatus,enable) VALUES (uid1,lockstatus1,'t');
  END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `recordoffline`(in uid1 INTEGER, in aid1 INTEGER, inout zoneid1 INTEGER, inout zonelocalid1 INTEGER, inout overwrite1 INTEGER)
BEGIN
  DECLARE rowcount INTEGER;
  START TRANSACTION;
    UPDATE point SET zoneid = NULL, zonelocalid = NULL WHERE uid = uid1 AND aid = aid1 AND zoneid = zoneid1;
    SET rowcount = ROW_COUNT();
    IF overwrite1 = rowcount THEN
      SELECT zoneid, zonelocalid INTO zoneid1, zonelocalid1 FROM point WHERE uid = uid1 AND aid = aid1;
    END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `recordonline`(in uid1 INTEGER, in aid1 INTEGER, inout zoneid1 INTEGER, inout zonelocalid1 INTEGER, inout overwrite INTEGER)
BEGIN
  DECLARE tmp_zoneid INTEGER;
  DECLARE tmp_zonelocalid INTEGER;
  DECLARE rowcount INTEGER;
  START TRANSACTION;
    SELECT SQL_CALC_FOUND_ROWS zoneid, zonelocalid INTO tmp_zoneid, tmp_zonelocalid FROM point WHERE uid = uid1 and aid = aid1;
    SET rowcount = FOUND_ROWS();
    IF rowcount = 0 THEN
      INSERT INTO point (uid, aid, time, zoneid, zonelocalid, lastlogin) VALUES (uid1, aid1, 0, zoneid1, zonelocalid1, now());
    ELSE IF tmp_zoneid IS NULL OR overwrite = 1 THEN
      UPDATE point SET zoneid = zoneid1, zonelocalid = zonelocalid1, lastlogin = now() WHERE uid = uid1 AND aid = aid1;
    END IF;
    END IF;
    IF tmp_zoneid IS NULL THEN
      SET overwrite = 1;
    ELSE
      SET zoneid1 = tmp_zoneid;
      SET zonelocalid1 = tmp_zonelocalid;
    END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `remaintime`(in uid1 INTEGER, in aid1 INTEGER, out remain INTEGER, out freetimeleft INTEGER)
BEGIN
  DECLARE enddate1 DATETIME;
  DECLARE now1 DATETIME;
  DECLARE rowcount INTEGER;
  START TRANSACTION;
  SET now1 = now();
  IF aid1 = 0 THEN
    SET remain = 86313600;
    SET enddate1 = date_add(now1, INTERVAL '30' DAY);
  ELSE
    SELECT time, IFNULL(enddate, now1) INTO remain, enddate1 FROM point WHERE uid = uid1 AND aid = aid1;
    SET rowcount = ROW_COUNT();
    IF rowcount = 0 THEN
      SET remain = 0;
      INSERT INTO point (uid,aid,time) VALUES (uid1, aid1, remain);
    END IF;
  END IF;
  SET freetimeleft = 0;
  IF enddate1 > now1 THEN
    SET freetimeleft = timestampdiff(second, now1, enddate1);
  END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setiplimit`(in uid1 INTEGER, in ipaddr11 INTEGER, in ipmask11 VARCHAR(2), in ipaddr21 INTEGER, in ipmask21 VARCHAR(2), in ipaddr31 INTEGER, in ipmask31 VARCHAR(2), in enable1 CHAR(1))
BEGIN
  DECLARE rowcount INTEGER;
  START TRANSACTION;
    UPDATE iplimit SET ipaddr1 = ipaddr11, ipmask1 = ipmask11, ipaddr2 = ipaddr21, ipmask2 = ipmask21, ipaddr3 = ipaddr31, ipmask3 = ipmask31 WHERE uid = uid1;
    SET rowcount = ROW_COUNT();
    IF rowcount = 0 THEN
      INSERT INTO iplimit (uid, ipaddr1, ipmask1, ipaddr2, ipmask2, ipaddr3, ipmask3, enable1) VALUES (uid1, ipaddr11, ipmask11, ipaddr21, ipmask21, ipaddr31, ipmask31,'t');
    END IF;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserInfo`(
  in name1 VARCHAR(32),
  in prompt1 VARCHAR(32),
  in answer1 VARCHAR(32),
  in truename1 VARCHAR(32),
  in idnumber1 VARCHAR(32),
  in email1 VARCHAR(32),
  in mobilenumber1 VARCHAR(32),
  in province1 VARCHAR(32),
  in city1 VARCHAR(32),
  in phonenumber1 VARCHAR(32),
  in address1 VARCHAR(32),
  in postalcode1 VARCHAR(32),
  in gender1 INTEGER,
  in birthday1 VARCHAR(32),
  in qq1 VARCHAR(32)
 )
BEGIN
  START TRANSACTION;
    UPDATE users SET prompt = prompt1, answer = answer1, truename = truename1, idnumber = idnumber1, email = email1, mobilenumber = mobilenumber1, province = province1, city = city1, phonenumber = phonenumber1, address = address1, postalcode = postalcode1, gender = gender1, birthday = birthda1, qq = qq1 WHERE name = name1;
  COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `usecash`(
  in userid1 INTEGER,
  in zoneid1 INTEGER,
  in sn1 INTEGER,
  in aid1 INTEGER,
  in point1 INTEGER,
  in cash1 INTEGER,
  in status1 INTEGER,
  out error INTEGER
)
BEGIN
DECLARE sn_old INTEGER;
DECLARE aid_old INTEGER;
DECLARE point_old INTEGER;
DECLARE cash_old INTEGER;
DECLARE status_old INTEGER;
DECLARE createtime_old DATETIME;
DECLARE time_old INTEGER;
DECLARE need_restore INTEGER;
DECLARE exists1 INTEGER;
DECLARE rowcount INTEGER;
START TRANSACTION;
  SET error = 0;
  SET need_restore = 0;
  SELECT SQL_CALC_FOUND_ROWS sn, aid, point, cash, status, creatime INTO sn_old, aid_old, point_old, cash_old, status_old, createtime_old FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND sn >= 0;
  SET rowcount = FOUND_ROWS();
  IF rowcount = 1 THEN
    SET exists1 = 1;
  ELSE
    SET exists1 = 0;
  END IF;
  IF status1 = 0 THEN
    IF exists1 = 0 THEN
      SELECT aid, point INTO aid1, point1 FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn1;
      SET point1 = IFNULL(point1,0);
      UPDATE point SET time = time-point1 WHERE uid = userid1 AND aid = aid1 AND time >= point1;
      SET rowcount = ROW_COUNT();
      IF rowcount = 1 THEN
        UPDATE usecashnow SET sn = 0, status = 1 WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn1;
      ELSE
        SET error = -8;
      END IF;
    END IF;
  ELSE
    IF status1 = 1 THEN
      IF exists1 = 0 THEN
        UPDATE point SET time = time-point1 WHERE uid = userid1 AND aid = aid1 AND time >= point1;
        SET rowcount = ROW_COUNT();
        IF rowcount = 1 THEN
          INSERT INTO usecashnow (userid, zoneid, sn, aid, point, cash, status, creatime) VALUES (userid1, zoneid1, sn1, aid1, point1, cash1, status1, now());
        ELSE
          INSERT INTO usecashnow SELECT userid1, zoneid1, IFNULL(min(sn),0)-1, aid1, point1, cash1, 0, now() FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND 0 >= sn;
          SET error = -8;
        END IF;
      ELSE
        INSERT INTO usecashnow SELECT userid1, zoneid1, IFNULL(min(sn),0)-1, aid1, point1, cash1, 0, now() FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND 0 >= sn;
        SET error = -7;
      END IF;
    ELSE
      IF status1 = 2 THEN
        IF exists1 = 1 AND status_old = 1 AND sn_old = 0 THEN
          UPDATE usecashnow SET sn = sn1, status = status1 WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn_old;
        ELSE
          SET error = -9;
        END IF;
      ELSE
        IF status1 = 3 THEN
           IF exists1 = 1 AND status_old = 2 THEN
            UPDATE usecashnow SET status = status1 WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn_old;
           ELSE
            SET error = -10;
            END IF;
        ELSE
         IF status1 = 4 THEN
          IF exists1 = 1 THEN
            DELETE FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn_old;
            INSERT INTO usecashlog (userid, zoneid, sn, aid, point, cash, status, creatime, fintime) VALUES (userid1, zoneid1, sn_old, aid_old, point_old, cash_old, status1, createtime_old, now());
          END IF;
          IF NOT (exists1 = 1 AND status_old = 3) THEN
            SET error = -11;
          END IF;
        ELSE
          SET error = -12;
        END IF;
      END IF;
    END IF;
  END IF;
  END IF;
  IF need_restore = 1 THEN
    UPDATE point SET time = time+point_old WHERE uid = userid1 AND aid = aid_old;
    DELETE FROM usecashnow WHERE userid = userid1 AND zoneid = zoneid1 AND sn = sn_old;
    INSERT INTO usecashlog (userid, zoneid, sn, aid, point, cash, status, creatime, fintime) VALUES (userid1, zoneid1, sn_old, aid_old, point_old, cash_old, status1, createtime_old, now());
  END IF;
COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `zoneid` int(11) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`zoneid`,`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth`
--

INSERT INTO `auth` (`userid`, `zoneid`, `rid`) VALUES
(1024, 2, 0),
(1024, 2, 1),
(1024, 2, 2),
(1024, 2, 3),
(1024, 2, 4),
(1024, 2, 5),
(1024, 2, 6),
(1024, 2, 7),
(1024, 2, 8),
(1024, 2, 9),
(1024, 2, 10),
(1024, 2, 11),
(1024, 2, 100),
(1024, 2, 101),
(1024, 2, 102),
(1024, 2, 103),
(1024, 2, 104),
(1024, 2, 105),
(1024, 2, 200),
(1024, 2, 201),
(1024, 2, 202),
(1024, 2, 203),
(1024, 2, 204),
(1024, 2, 205),
(1024, 2, 206),
(1024, 2, 207),
(1024, 2, 208),
(1024, 2, 209),
(1024, 2, 210),
(1024, 2, 211),
(1024, 2, 212),
(1024, 2, 213),
(1024, 2, 214),
(1024, 2, 500),
(1024, 2, 501),
(1024, 2, 502),
(1024, 2, 503),
(1024, 2, 504),
(1024, 2, 505),
(1024, 2, 506),
(1024, 2, 507),
(1024, 2, 508),
(1024, 2, 509),
(1024, 2, 510),
(1024, 2, 511),
(1024, 2, 512),
(1024, 2, 513),
(1024, 2, 514),
(1024, 2, 515),
(1024, 2, 516),
(1024, 2, 517),
(1024, 2, 518);

-- --------------------------------------------------------

--
-- Структура таблицы `base`
--

CREATE TABLE IF NOT EXISTS `base` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `akkid` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `race` int(11) DEFAULT NULL,
  `occupation` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `exp` int(11) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  `mp` int(11) DEFAULT NULL,
  `vp` int(11) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `base`
--

INSERT INTO `base` (`bid`, `version`, `akkid`, `id`, `name`, `gender`, `race`, `occupation`, `level`, `exp`, `hp`, `mp`, `vp`) VALUES
(1, 1, 1024, 8202, 'Martin', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 1024, 12298, 'ÐºÐ°67Ñ‰', 0, 5, 3, 1, 0, 1080, 800, 0),
(3, 1, 1024, 16394, 'rdj', 1, 5, 3, 1, 0, 1080, 800, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `forbid`
--

CREATE TABLE IF NOT EXISTS `forbid` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL,
  `forbid_time` int(11) NOT NULL DEFAULT '0',
  `reason` blob NOT NULL,
  `gmroleid` int(11) DEFAULT '0',
  PRIMARY KEY (`userid`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `iplimit`
--

CREATE TABLE IF NOT EXISTS `iplimit` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `ipaddr1` int(11) DEFAULT '0',
  `ipmask1` varchar(2) DEFAULT '',
  `ipaddr2` int(11) DEFAULT '0',
  `ipmask2` varchar(2) DEFAULT '',
  `ipaddr3` int(11) DEFAULT '0',
  `ipmask3` varchar(2) DEFAULT '',
  `enable` char(1) DEFAULT '',
  `lockstatus` char(1) DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `listfamily`
--

CREATE TABLE IF NOT EXISTS `listfamily` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `master` int(11) NOT NULL,
  `factionid` int(11) NOT NULL,
  `createtime` int(100) NOT NULL,
  `jointime` int(100) NOT NULL,
  `deletetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `listfamilyuser`
--

CREATE TABLE IF NOT EXISTS `listfamilyuser` (
  `rid` int(11) NOT NULL,
  `familyid` varchar(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `nickname` int(11) NOT NULL,
  `level` int(100) NOT NULL,
  `title` int(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `contribution` int(11) NOT NULL,
  `jointime` datetime NOT NULL,
  `devotion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `listrole`
--

CREATE TABLE IF NOT EXISTS `listrole` (
  `roleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `occupation` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `race` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `delete_time` datetime NOT NULL,
  `create_time` datetime NOT NULL,
  `lastlogin_time` datetime NOT NULL,
  `forbid_size` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `mp` int(11) NOT NULL,
  `posx` int(11) NOT NULL,
  `posy` int(11) NOT NULL,
  `posz` int(11) NOT NULL,
  `pkvalue` int(11) NOT NULL,
  `worldtag` int(11) NOT NULL,
  `time_used` int(11) NOT NULL,
  `reputation` int(11) NOT NULL,
  `achievementpoints` int(11) NOT NULL,
  `custom_status_size` int(11) NOT NULL,
  `filter_data_size` int(11) NOT NULL,
  `charactermode_size` int(11) NOT NULL,
  `dbltime_data_size` int(11) NOT NULL,
  `var_data_size` int(11) NOT NULL,
  `skills_size` int(11) NOT NULL,
  `storehousepasswd_size` int(11) NOT NULL,
  `coolingtime_size` int(11) NOT NULL,
  `recipes` int(11) NOT NULL,
  `storehouse_money` int(11) NOT NULL,
  `storehouse_size` int(11) NOT NULL,
  `inventory_money` int(11) NOT NULL,
  `inventory_bindmoney` int(11) NOT NULL,
  `inventory_size` int(11) NOT NULL,
  `equipment_size` int(11) NOT NULL,
  `taskinventory_size` int(11) NOT NULL,
  `task_data_size` int(11) NOT NULL,
  `task_complete_size` int(11) NOT NULL,
  `god_level` int(11) NOT NULL,
  `evil_level` int(11) NOT NULL,
  `fly_level` int(11) NOT NULL,
  `inventory_bindcash` int(11) NOT NULL,
  `talent_branch` int(11) NOT NULL,
  PRIMARY KEY (`roleid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `listrole`
--

INSERT INTO `listrole` (`roleid`, `userid`, `name`, `occupation`, `gender`, `race`, `status`, `delete_time`, `create_time`, `lastlogin_time`, `forbid_size`, `level`, `exp`, `hp`, `mp`, `posx`, `posy`, `posz`, `pkvalue`, `worldtag`, `time_used`, `reputation`, `achievementpoints`, `custom_status_size`, `filter_data_size`, `charactermode_size`, `dbltime_data_size`, `var_data_size`, `skills_size`, `storehousepasswd_size`, `coolingtime_size`, `recipes`, `storehouse_money`, `storehouse_size`, `inventory_money`, `inventory_bindmoney`, `inventory_size`, `equipment_size`, `taskinventory_size`, `task_data_size`, `task_complete_size`, `god_level`, `evil_level`, `fly_level`, `inventory_bindcash`, `talent_branch`) VALUES
(16, 16, 'race1occu1gend0', 1, 0, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:26:13', 0, 1, 0, 1500, 500, -145, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 16, 'race1occu1gend1', 1, 1, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:27:27', 0, 1, 0, 1500, 500, -144, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 16, 'race1occu3gend0', 3, 0, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:28:37', 0, 1, 0, 1080, 800, -144, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 16, 'race1occu3gend1', 3, 1, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:29:38', 0, 1, 0, 1080, 800, -145, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 16, 'race1occu5gend0', 5, 0, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:30:44', 0, 1, 0, 800, 1450, -145, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 16, 'race1occu5gend1', 5, 1, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:31:50', 0, 1, 0, 800, 1450, -145, 102, 34, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 16, 'race1occu6gend0', 6, 0, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:32:55', 0, 1, 0, 920, 1200, -145, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 16, 'race1occu6gend1', 6, 1, 1, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:33:56', 0, 1, 0, 920, 1200, -145, 102, 35, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 32, 'race2occu1gend0', 1, 0, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:35:12', 0, 1, 0, 1500, 500, -149, 209, -70, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(33, 32, 'race2occu1gend1', 1, 1, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:36:22', 0, 1, 0, 1500, 500, -149, 209, -70, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 32, 'race2occu6gend0', 6, 0, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:37:23', 0, 1, 0, 920, 1200, -149, 209, -69, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 32, 'race2occu6gend1', 6, 1, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:38:25', 0, 1, 0, 920, 1200, -149, 209, -70, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 32, 'race2occu8gend0', 8, 0, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:39:28', 0, 1, 0, 900, 1300, -149, 209, -69, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 32, 'race2occu8gend1', 8, 1, 2, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:40:35', 0, 1, 0, 900, 1300, -149, 209, -69, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 32, 'race3occu4gend0', 4, 0, 3, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:41:35', 0, 1, 0, 980, 850, 184, 185, -171, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(39, 32, 'race3occu4gend1', 4, 1, 3, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-10-31 08:55:43', 0, 1, 0, 980, 850, 185, 185, -171, 0, 9, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(48, 48, 'race4occu2gend0', 2, 0, 4, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-10-31 08:54:17', 0, 1, 0, 1420, 450, 255, 246, 252, 0, 10, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(49, 48, 'race5occu3gend0', 3, 0, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:45:01', 0, 1, 0, 1080, 800, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(50, 48, 'race5occu3gend1', 3, 1, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:46:03', 0, 1, 0, 1080, 800, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(51, 48, 'race5occu5gend0', 5, 0, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:46:59', 0, 1, 0, 800, 1450, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(52, 48, 'race5occu5gend1', 5, 1, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:47:56', 0, 1, 0, 800, 1450, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(53, 48, 'race5occu7gend0', 7, 0, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:48:50', 0, 1, 0, 960, 900, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, 48, 'race5occu7gend1', 7, 1, 5, 17, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-11-20 15:49:47', 0, 1, 0, 960, 900, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 15, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(64, 64, 'race6occu3gend0', 3, 0, 6, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:04:58', 0, 1, 0, 1080, 800, -312, 197, -17, 0, 31, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(65, 64, 'race6occu6gend1', 6, 1, 6, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:04:28', 0, 1, 0, 920, 1200, -308, 197, -13, 0, 31, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(66, 64, 'race6occu9gend0', 9, 0, 6, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:03:58', 0, 1, 0, 1460, 475, -311, 197, -16, 0, 31, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(67, 64, 'race6occu9gend1', 9, 1, 6, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:03:29', 0, 1, 0, 1460, 475, -311, 197, -16, 0, 31, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, 64, 'race5occu9gend0', 9, 0, 5, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:02:59', 0, 1, 0, 1460, 475, 208, 139, 199, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 64, 'race5occu9gend1', 9, 1, 5, 1, '2000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-11-07 07:02:19', 0, 1, 0, 1460, 475, 208, 139, 198, 0, 11, 0, 0, 0, 0, 12, 16, 24, 60, 16, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4106, 1024, 'Berlin', 3, 0, 1, 1, '2000-00-00 00:00:00', '2020-02-08 17:14:46', '2020-02-10 16:46:19', 0, 4, 146, 3906, 1160, -143, 102, 38, 0, 9, 7390, 0, 10, 0, 12, 16, 24, 60, 21, 0, 8, 0, 0, 0, 0, 500033, 9, 6, 0, 540, 998, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `listrolebrief`
--

CREATE TABLE IF NOT EXISTS `listrolebrief` (
  `roleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `occupation` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `moneyall` int(11) NOT NULL,
  `save_time` varchar(100) NOT NULL,
  `race` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mw_chat`
--

CREATE TABLE IF NOT EXISTS `mw_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `src` int(10) NOT NULL,
  `src_name` varchar(50) NOT NULL DEFAULT '',
  `msg` text,
  `date` varchar(50) NOT NULL DEFAULT '',
  `channel` tinyint(2) NOT NULL DEFAULT '0',
  `dst` int(10) NOT NULL DEFAULT '0',
  `dst_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_id` (`src`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mw_factions`
--

CREATE TABLE IF NOT EXISTS `mw_factions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '1',
  `master` int(10) NOT NULL,
  `members` int(10) NOT NULL DEFAULT '0',
  `nimbus` int(10) NOT NULL DEFAULT '0',
  `prosperity` int(10) NOT NULL DEFAULT '0',
  `contribution` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mw_roles`
--

CREATE TABLE IF NOT EXISTS `mw_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `spouse` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  `mp` int(11) DEFAULT NULL,
  `pkvalue` int(11) DEFAULT NULL,
  `reputation` int(11) DEFAULT NULL,
  `time_used` int(11) DEFAULT NULL,
  `occupation` int(11) DEFAULT NULL,
  `crs_server_viplevel` int(11) DEFAULT NULL,
  `combatkills` int(11) DEFAULT NULL,
  `bind_money` varchar(32) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `race` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mw_roles`
--

INSERT INTO `mw_roles` (`id`, `name`, `gender`, `spouse`, `level`, `hp`, `mp`, `pkvalue`, `reputation`, `time_used`, `occupation`, `crs_server_viplevel`, `combatkills`, `bind_money`, `money`, `race`) VALUES
(4106, 'adwdwad', 1, 0, 1, NULL, NULL, 0, 0, 3519, 4, 9, 0, '0', 0, 3),
(8202, '7еш', 0, 0, 10, NULL, NULL, 0, 0, 21417, 1, 9, 0, '110032', 0, 1),
(12298, 'ногв7е', 0, 0, 1, NULL, NULL, 0, 0, 0, 1, 0, 0, '0', 0, 2),
(16394, 'T7I7', 1, 0, 1, NULL, NULL, 0, 0, 327, 7, 9, 0, '0', 0, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `point`
--

CREATE TABLE IF NOT EXISTS `point` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `aid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `zoneid` int(11) DEFAULT '0',
  `zonelocalid` int(11) DEFAULT '0',
  `accountstart` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`,`aid`),
  KEY `IX_point_aidzoneid` (`aid`,`zoneid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `point`
--

INSERT INTO `point` (`uid`, `aid`, `time`, `zoneid`, `zonelocalid`, `accountstart`, `lastlogin`, `enddate`) VALUES
(1024, 19, 0, NULL, NULL, NULL, '2020-06-28 13:06:20', NULL),
(1040, 19, 0, NULL, NULL, NULL, '2020-02-15 12:06:30', NULL),
(1056, 19, 0, NULL, NULL, NULL, '2020-02-18 10:48:35', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `account_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_level` smallint(6) NOT NULL,
  `role_race` tinyint(4) NOT NULL,
  `role_occupation` tinyint(4) NOT NULL,
  `role_gender` tinyint(4) NOT NULL,
  `role_money` bigint(20) NOT NULL,
  `role_rep` int(11) NOT NULL,
  `role_exp` bigint(20) NOT NULL,
  `role_hp` int(11) NOT NULL,
  `role_mp` int(11) NOT NULL,
  `pkvalue` int(11) NOT NULL,
  `klan_id` int(11) NOT NULL,
  `klan_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `usecashlog`
--

CREATE TABLE IF NOT EXISTS `usecashlog` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `zoneid` int(11) NOT NULL DEFAULT '0',
  `sn` int(11) NOT NULL DEFAULT '0',
  `aid` int(11) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `cash` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `creatime` datetime NOT NULL,
  `fintime` datetime NOT NULL,
  KEY `IX_usecashlog_creatime` (`creatime`),
  KEY `IX_usecashlog_uzs` (`userid`,`zoneid`,`sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `usecashlog`
--

INSERT INTO `usecashlog` (`userid`, `zoneid`, `sn`, `aid`, `point`, `cash`, `status`, `creatime`, `fintime`) VALUES
(1024, 2, 1, 19, 0, 5000000, 4, '2020-02-08 17:17:48', '2020-02-08 17:19:02'),
(1040, 2, 1, 19, 0, 50000, 4, '2020-02-11 20:09:08', '2020-02-11 20:12:09'),
(1024, 2, 2, 19, 0, 1000, 4, '2020-02-14 18:05:46', '2020-02-14 18:07:10'),
(1056, 2, 1, 19, 0, 1000, 4, '2020-02-14 19:53:39', '2020-02-14 19:57:10'),
(1024, 2, 3, 19, 0, 100, 4, '2020-02-16 10:11:38', '2020-02-16 10:13:45'),
(1024, 2, 1, 19, 0, 500000, 4, '2020-02-19 15:19:31', '2020-02-19 15:23:10'),
(1024, 2, 2, 19, 0, 1000, 4, '2020-02-21 01:28:34', '2020-02-22 13:31:50'),
(1024, 2, 2, 19, 0, 25, 4, '2020-06-26 12:14:41', '2020-06-26 12:17:00'),
(1024, 2, 3, 19, 0, 3, 4, '2020-06-26 14:51:04', '2020-06-26 14:52:00'),
(1024, 2, 4, 19, 0, 25, 4, '2020-06-26 16:30:18', '2020-06-26 16:32:00'),
(1024, 2, 1, 19, 0, 12500, 4, '2020-06-28 13:14:43', '2020-06-28 13:19:11');

-- --------------------------------------------------------

--
-- Структура таблицы `usecashnow`
--

CREATE TABLE IF NOT EXISTS `usecashnow` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `zoneid` int(11) NOT NULL DEFAULT '0',
  `sn` int(11) NOT NULL DEFAULT '0',
  `aid` int(11) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `cash` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `creatime` datetime NOT NULL,
  PRIMARY KEY (`userid`,`zoneid`,`sn`),
  KEY `IX_usecashnow_creatime` (`creatime`),
  KEY `IX_usecashnow_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `usecashnow`
--

INSERT INTO `usecashnow` (`userid`, `zoneid`, `sn`, `aid`, `point`, `cash`, `status`, `creatime`) VALUES
(1152, 2, -1, 19, 0, 1000, 0, '2020-06-27 08:57:28');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `passwd` varchar(64) NOT NULL,
  `Prompt` varchar(32) NOT NULL DEFAULT '',
  `answer` varchar(32) NOT NULL DEFAULT '',
  `truename` varchar(32) NOT NULL DEFAULT '',
  `idnumber` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `mobilenumber` varchar(32) DEFAULT '',
  `province` varchar(32) DEFAULT '',
  `city` varchar(32) DEFAULT '',
  `phonenumber` varchar(32) DEFAULT '',
  `address` varchar(64) DEFAULT '',
  `postalcode` varchar(8) DEFAULT '',
  `gender` int(11) DEFAULT '0',
  `birthday` datetime DEFAULT NULL,
  `creatime` datetime NOT NULL,
  `qq` varchar(32) DEFAULT '',
  `passwd2` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `IX_users_name` (`name`),
  KEY `IX_users_creatime` (`creatime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `name`, `passwd`, `Prompt`, `answer`, `truename`, `idnumber`, `email`, `mobilenumber`, `province`, `city`, `phonenumber`, `address`, `postalcode`, `gender`, `birthday`, `creatime`, `qq`, `passwd2`) VALUES
(1024, 'martin', '0x986b229bba69e6a42e0be2ece3e0af41', '0', '0', '0', '0', 'rchernih@gmail.com', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-01-23 21:30:35', '', '0x986b229bba69e6a42e0be2ece3e0af41'),
(1040, 'test', '0x47ec2dd791e31e2ef2076caf64ed9b3d', '0', '0', '0', '0', '456ih@gmail.com', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-02-11 20:03:23', '', '0x47ec2dd791e31e2ef2076caf64ed9b3d'),
(1056, 'martin2', '0x3d69cea805f56db46189e754b7710d11', '0', '0', '0', '0', 'cgykgu@yfj.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-02-14 19:52:32', '', '0x3d69cea805f56db46189e754b7710d11'),
(1072, 'test2', '0x80660e29103d525b694f45e34e23f498', '0', '0', '0', '0', 'dyjt@ghjk.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-02-17 01:20:43', '', '0x80660e29103d525b694f45e34e23f498'),
(1088, 'martin7700', '0x641dca8142d5ec28ad3f9a54c342069f', '0', '0', '0', '0', '435rty56gu@yfj.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-26 15:00:41', '', '0x641dca8142d5ec28ad3f9a54c342069f'),
(1104, 'martin77001', '0x5b65f4473e8be154342eb9b906e463ad', '0', '0', '0', '0', '43435gu@yfj.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-26 15:01:48', '', '0x5b65f4473e8be154342eb9b906e463ad'),
(1120, 'beach20', '0x8a855db871350cd3ca859f3ac3136f62', '0', '0', '0', '0', '5474nih@gmail.com', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-26 15:06:13', '', '0x8a855db871350cd3ca859f3ac3136f62'),
(1136, 'martin910', '0x9ac35bb9f0edba65cf531dd90a1a8913', '0', '0', '0', '0', '5609ih@gmail.com', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-26 15:12:11', '', '0x9ac35bb9f0edba65cf531dd90a1a8913'),
(1152, 'ricco', '0xe77f389a14a341c9bafa4b0660add45d', '0', '0', '0', '0', '435657gu@yfj.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-27 08:57:06', '', '0xe77f389a14a341c9bafa4b0660add45d'),
(1168, 'beach20222', '0xa05ce509944f1b17bcc5774abfd2b202', '0', '0', '0', '0', 'rc564ih@gmail.com', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-27 09:14:36', '', '0xa05ce509944f1b17bcc5774abfd2b202'),
(1184, 'beach205464', '0x8c9871dbd443f9285cac9f33c0704102', '0', '0', '0', '0', '435g4564u@yfj.ru', '0', '0', '0', '', '0', '1', 0, '0000-00-00 00:00:00', '2020-06-27 09:17:02', '', '0x8c9871dbd443f9285cac9f33c0704102');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

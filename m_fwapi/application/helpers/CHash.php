<?php
/**
 * CHash is a helper class file that provides different encryption methods
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * create
 * getRandomString
 * 
 */	  

class CHash
{
    /**
     * Encrypt given value
     * @param $value
     * @param $secretKey
     * @return string
     */
	public static function encrypt($value, $secretKey)
    {
		return trim(strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secretKey, $value, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))), '+/=', '-_,'));
    }

    /**
     * Decrypt given value
     * @param $value
     * @param $secretKey
     * @return string
     */
	public static function decrypt($value, $secretKey)
	{
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secretKey, base64_decode(strtr($value, '-_,', '+/=')), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
}

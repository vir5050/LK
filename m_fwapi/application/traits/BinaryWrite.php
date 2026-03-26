<?php
/**
 * Class BinaryWrite
 */
trait BinaryWrite
{
    /**
     * @param $data
     * @return string
     */
    protected function WriteByte($data)
    {
        return pack('C', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteInt16($data)
    {
        return pack('n', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteInt16LE($data)
    {
        return pack('v', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteInt32($data)
    {
        return pack('N', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteInt32LE($data)
    {
        return pack('V', $data);
    }

    /**
     * @param $data
	 * @param boolean $reverse
     * @return string
     */
    protected static function WriteFloat($data, $reverse = true)
    {
        return ($reverse===true) ? strrev(pack('f', $data)) : pack('f', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteInt64($data)
    {
        $left = 0xffffffff00000000;
        $right = 0x00000000ffffffff;
        $l = ($data & $left) >> 32;
        $r = $data & $right;
        $res = pack('N*', $l, $r);

        return $res;
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteCUInt($data)
    {
        if($data < 128)
            return pack('C', $data);
        else if($data < 16384)
            return pack('n', ($data | 0x8000));
        else if($data < 536870912)
            return pack('N', ($data | 0xC0000000));
        return pack('C', 224) . pack('N', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteString($data)
    {
        $data = iconv("UTF-8", "UTF-16LE", $data);
        return $this->WriteCUInt(strlen($data)).$data;
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteOctet($data)
    {
        $data = pack('H*', $data);
        return $this->WriteCUInt(strlen($data)).$data;
    }

    /**
     * @param $data
     * @return string
     */
    protected function WriteShortOctet($data)
    {
        return  pack("n", strlen($data) + 32768).$data;
    }
}
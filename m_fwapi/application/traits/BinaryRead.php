<?php
/**
 * Class BinaryRead
 */
trait BinaryRead
{
    /** @var int */
    public $pointer = 0;

    /**
     * @param $data
     * @return mixed
     */
    protected function ReadByte($data)
    {
        list($result) = array_values(unpack('C', substr($data, $this->pointer)));
        $this->pointer++;

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function ReadInt16($data)
    {
        list($result) = array_values(unpack('n', substr($data, $this->pointer)));
        $this->pointer += 2;

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function ReadInt16LE($data)
    {
        list($result) = array_values(unpack('v', substr($data, $this->pointer)));
        $this->pointer += 2;
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function ReadInt32($data)
    {
        list($result) = array_values(unpack('N', substr($data, $this->pointer)));
        $this->pointer += 4;

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function ReadInt32LE($data)
    {
        list($result) = array_values(unpack('V', substr($data, $this->pointer)));
        $this->pointer += 4;
        return $result;
    }

    /**
     * @param $data
     * @param boolean $reverse
     * @return mixed
     */
    protected function ReadFloat($data, $reverse = true)
    {
        list($result) = array_values(unpack("f", ($reverse===true) ? strrev(substr($data, $this->pointer, 4)) : substr($data, $this->pointer, 4)));
        $this->pointer += 4;
        return $result;
    }

    /**
     * @param $data
     * @return int
     */
    protected function ReadInt64($data)
    {
        $set = unpack('N2', substr($data, $this->pointer));
        $result = $set[1] << 32 | $set[2];
        $this->pointer += 8;

        return $result;
    }

    /**
     * @param $data
     * @return int
     */
    protected function ReadCUInt($data)
    {
        list($byte) = array_values(unpack('C', substr($data, $this->pointer)));

        switch($byte & 0xE0){
            case 224:
                $this->pointer++;
                list($byte) = array_values(unpack('N', substr($data, $this->pointer)));
                $this->pointer += 4;
                return $byte;
            case 192:
                list($byte) = array_values(unpack('N', substr($data, $this->pointer)));
                $this->pointer += 4;
                return $byte & 0x3FFFFFFF;
            case 128:
            case 160:
                list($byte) = array_values(unpack('n', substr($data, $this->pointer)));
                $this->pointer += 2;
                return $byte & 0x7FFF;
        }
        $this->pointer++;

        return $byte;
    }

    /**
     * @param $data
     * @return string
     */
    protected function ReadString($data)
    {
        $size = $this->ReadCUInt($data);
        $string = mb_convert_encoding(substr($data, $this->pointer, $size), "UTF-8","UTF-16LE");
        $this->pointer += $size;

        return $string;
    }

    /**
     * @param $data
     * @return string
     */
    protected function ReadOctet($data)
    {
        $size = $this->ReadCUInt($data);
        $oct = bin2hex(substr($data, $this->pointer, $size));
        $this->pointer += $size;

        return $oct;
    }
}
<?php
/**
 * Chat
 *
 * PUBLIC:				PROTECTED			   PRIVATE
 * ---------------		---------------		 ---------------
 * __construct
 *
 * STATIC:
 * ------------------------------------------
 *
 */
class Chat
{
    /** @var string */
    protected $_table = '';

    /**
     * Class default constructor
     */
    public function __construct()
    {
    }

    public static function formatter($message, $channel = 0)
    {
        $message = str_replace('<0>', '', $message);
        $message = str_replace('<1>', '', $message);
        $message = preg_replace("#\\<(.+?)\\:(.*?)\\>#is", '<img src="uploads/smiles/0/$2.gif" width="15" height="15" />', $message);
        //$message = preg_replace("#\\<(.+?)\\:(.*?)\\>#is", '', $message);
        $message = preg_replace("#\\<\\^(.+?)\\[(.*?)\\]\\>#is", '<span style="color:#$1;">[$2]</span>', $message);
        $message = preg_replace("#\\^(.+?)\\&(.*?)\\&#is", '<span style="color:#$1;">$2</span>', $message);

        if($channel == 12){
            $message = '<span style="color:#'.substr($message, -8, 6).'">'.substr($message, 0, -8).'</span>';
        }

        return $message;
    }
}

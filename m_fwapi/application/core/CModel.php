<?php
/**
 * CModel base class file
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		        
 * ----------               ----------                  ----------              
 * __construct                                          
 * __set                                                
 * __get                                                
 * getError
 * getErrorMessage
 *
 * STATIC:
 * ---------------------------------------------------------------
 *
 */	  

class CModel
{
	/** @var object */    
    private static $_instance;
	/** @var CDatabase */
	protected $db;
	/**	@var boolean */
	protected $error;
	/**	@var string */
	protected $errorMessage;
	/**	@var array */
	protected $columns = [];
    
	/**
	 * Class constructor
	 * @param array $params
	 */
	public function __construct($params = [])
	{
		$this->db = CDatabase::init($params);
        
        $this->error = CDatabase::getError();
        $this->errorMessage = CDatabase::getErrorMessage();
	}

    /**
     * Initializes the database class
     * @param array $params
     * @return \CModel|object
     */
	public static function init($params = [])
	{
		if(self::$_instance == null) self::$_instance = new self($params);
        return self::$_instance;    		
	}    
   
    /**	
	 * Setter
	 * @param $index
	 * @param $value
	 */
	public function __set($index, $value)
	{
        $this->columns[$index] = $value;
	}

    /**
     * Getter
     * @param $index
     * @return string
     */
	public function __get($index)
	{
        return isset($this->columns[$index]) ? $this->columns[$index] : '';
	}

	/**	
	 * Get error status
	 * @return boolean
	 */
	public function getError()
	{
		return $this->error;
	}
 
	/**	
	 * Get error message
	 * @return string
	 */
	public function getErrorMessage()
	{
		return $this->errorMessage;
	}
}
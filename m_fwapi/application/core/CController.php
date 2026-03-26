<?php

/**
 * CController base class file

 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------               ----------                  ----------
 * __construct                                          _getCalledClass
 *
 * STATIC:
 * ---------------------------------------------------------------
 *
 */
class CController
{
    /** @var CView $view */
    protected $view;

    /**
     * Class constructor
     * @return \CController
     */
    function __construct()
    {
        $this->view = My::app()->view;
    }
}
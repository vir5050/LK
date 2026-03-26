<?php

/**
 * ErrorController
 *
 * PUBLIC:				 PRIVATE
 * -----------			 ------------------
 * indexAction
 *
 */
class ErrorController extends CController
{
    /**
     * Controller default action handler
     * @param string $code
     */
    public function indexAction($code = 404)
    {
        $this->view->renderJson([
            'error'=>$code
        ]);
    }
}
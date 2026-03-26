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
     * @param int $code
     */
    public function indexAction($code = 404)
    {
        $this->view->render('error/'.$code);
    }
}
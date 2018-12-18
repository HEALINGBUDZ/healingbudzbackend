<?php
/**
 * Created by PhpStorm.
 * User: vengile
 * Date: 5/5/2017
 * Time: 5:33 PM
 */

namespace Traits;


trait RequestHelper
{
    public function getAuthorizationHeader(){
        if(isset(getallheaders()['Authorization']))
            return getallheaders()['Authorization'];
        return null;
    }
}
<?php

namespace RattfieldNz\SafeUrls\Libraries\Traits;

trait StaticCalling
{
    /**
     * Performs a static method call.
     *
     * Note that parent::class should be used instead of 'parent'
     * to refer to the actual parent class.
     *
     * @param string $className  Name of the class
     * @param string $methodName Name of the method
     *
     * @return mixed
     *
     * @see https://www.pagemachine.de/blog/mocking-static-method-calls/.
     */
    public function callStatic($className, $methodName)
    {
        $parameters = func_get_args();
        $parameters = array_slice($parameters, 2); // Remove $className and $methodName

        return call_user_func_array($className.'::'.$methodName, $parameters);
    }
}

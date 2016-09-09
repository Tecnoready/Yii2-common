<?php

/*
 * This file is part of the BtoB4Rewards package.
 * 
 * (c) www.btob4rewards.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnoready\Yii2\Common\Twig\Extension;

use Twig_Extension;
use Yii;

/**
 * Extension de cosas comunes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Yii2CommonExtension extends Twig_Extension 
{
    public function getFunctions() 
    {
        $functions = [];
        $functions[] = new \Twig_SimpleFunction('breadcrumb', array($this,'breadcrumb'), array());
        $functions[] = new \Twig_SimpleFunction('breadcrumb_render', array($this,'breadcrumbRender'), array('is_safe' => array('html')));
        return $functions;
    }
    
    public function breadcrumb()
    {
        return call_user_func_array([Yii::$container->get("common.manager.breadcrumb"),"breadcrumb"],func_get_args());
    }
    public function breadcrumbRender(){
        return Yii::$container->get("common.manager.breadcrumb")->breadcrumbRender();
    }

    public function getName() {
        return "tecnoready_yii2_common";
    }
}

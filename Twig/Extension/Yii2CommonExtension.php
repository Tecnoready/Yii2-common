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

/**
 * Extension de cosas comunes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class Yii2CommonExtension extends Twig_Extension 
{
    private $config;
    
    public function __construct(array $config = array()) {
        $this->config = $config;
    }
    
    public function getFunctions() 
    {
        $functions = [];
        $functions[] = new \Twig_SimpleFunction('breadcrumb', array($this,'breadcrumb'), array('is_safe' => array('html')));
        return $functions;
    }
    
    public function breadcrumb()
    {
        $parameters = array();
        $args = func_get_args();
        foreach ($args as $key => $arg) {
            if(empty($arg)){
                continue;
            }
            $item = new \stdClass();
            $item->link = null;
            $item->label = null;
            if(is_array($arg)){
                $count = count($arg);
                if($count > 1){
                    throw new \LogicException('The array elment must be one, count');
                }
                foreach ($arg as $key => $value) {
                    $item->link = $key;
                    $item->label = $value;
                }
            }else{
                $item->label = $arg;
            }
            $parameters[] = $item;
        }
        $this->config["twig"]["breadcrumb"]["template"];
        $emplate = $this->container->getParameter('tecnocreaciones_tools.twig.breadcrumb.template');
        return $this->container->get('templating')->render($emplate, 
            array(
                'breadcrumbs' => $parameters,
            )
        );
    }

    public function getName() {
        return "tecnoready_yii2_common";
    }
}

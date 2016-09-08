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
    private $options;
    private $breadcrumbs;
    
    public function __construct(array $options = array()) {
        //$basePath = dirname(dirname(__DIR__));
        $resolver = new \Symfony\Component\OptionsResolver\OptionsResolver();
        $resolver->setDefaults([
           "twig.breadcrumb.template" => "@vendor/tecnoready/yii2-common/Views/twig/breadcrumb.twig"
        ]);
        $this->options = $resolver->resolve($options);
    }
    
    public function getFunctions() 
    {
        $functions = [];
        $functions[] = new \Twig_SimpleFunction('breadcrumb', array($this,'breadcrumb'), array());
        $functions[] = new \Twig_SimpleFunction('breadcrumb_render', array($this,'breadcrumbRender'), array('is_safe' => array('html')));
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
        
        if($this->breadcrumbs === null){
            $this->breadcrumbs = [];
        }
        $this->breadcrumbs = array_merge($this->breadcrumbs, $parameters);
    }
    public function breadcrumbRender(){
        $template = $this->options["twig.breadcrumb.template"];
        $breadcrumbs = $this->breadcrumbs;
        $this->breadcrumbs = [];
        return Yii::$container->get("twig")->render($template, 
            array(
                'breadcrumbs' => $breadcrumbs,
            )
        );
    }

    public function getName() {
        return "tecnoready_yii2_common";
    }
}

<?php

/*
 * This file is part of the BtoB4Rewards package.
 * 
 * (c) www.btob4rewards.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnoready\Yii2\Common\Services;

use LogicException;
use stdClass;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yii;

/**
 * Servicio de breadcump (common.manager.breadcrumb)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BreadcrumbManager {
    
    private $options;
    private $breadcrumbs;
    
    public function __construct(array $options = array()) {
        //$basePath = dirname(dirname(__DIR__));
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
           "twig.breadcrumb.template" => "@vendor/tecnoready/yii2-common/Views/twig/breadcrumb.twig"
        ]);
        $this->options = $resolver->resolve($options);
    }
    
    public function breadcrumb()
    {
        $parameters = array();
        $args = func_get_args();
        foreach ($args as $key => $arg) {
            if(empty($arg)){
                continue;
            }
            $item = new stdClass();
            $item->link = null;
            $item->label = null;
            if(is_array($arg)){
                $count = count($arg);
                if($count > 1){
                    throw new LogicException('The array elment must be one, count');
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
}

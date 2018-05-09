<?php
/**
 * Created by PhpStorm.
 * User: LEOBA
 * Date: 09/05/2018
 * Time: 00:10
 *
 * main router
 */

namespace Core;


class Router
{

    /**
     * url a recuperer
     * @var string
     */
    private $url;

    /**
     * Controller a utiliser
     * @var string
     */
    private $controller;

    /**
     * Function a utiliser (action)
     * @var string
     */
    private $action;

    /**
     * tableau des parametre
     * @var array
     */
    private $params;

    /**
     * Action par defaut(index)
     * @var string
     */
    private $defaultAction;

    /**
     * Controller par defaut (index)
     * @var string
     */
    private $defaultController;

    /**
     * Controller a appeler en cas d'erreur
     * @var string
     */
    private $errorController;

    /**
     * Action a appeler lors d'une erreur
     * @var string
     */
    private $errorAction ;


    /*
     * constructeur
     */
    public function __construct()
    {
        $this->setUrl($_SERVER['REQUEST_URI']);
        $this->defaultAction = 'index';
        $this->defaultController = 'index';
        $this->errorController = 'error';
        $this->errorAction = 'index';
    }


    public function load()
    {
//        $url = $this->getUrl();
        $url = $this->url;
        $params = $this->formatUrl($url);

        array_shift($params);
        if (!empty($params)) {
            $this->controller = array_shift($params);
            $this->action = array_shift($params);
            $this->setParams($params);
        }

        $this->controller = (!empty($this->controller)) ? $this->controller : $this->defaultController;
        $this->action = (!empty($this->action)) ? $this->action : $this->defaultAction;

        var_dump($this);
    }

    private function run()
    {

    }


    /**
     * netoyer les url si necessaire
     * @param $url url a formater
     * @return array url en tableau
     */
    public function formatUrl($url)
    {
        $arrUrl = explode('/', $url);
//        $arrScripts = explode('/', $script);
        $size = count($arrUrl);
        for ($i = 0; $i < $size; $i ++){
           if (empty($arrUrl[$i])){
               unset($arrUrl[$i]);
           }
        }
        return array_values($arrUrl);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }



    /**
     * modifier un url
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = trim($url, '/');
    }

    /**
     * modifier les parametre
     * @param array $params (nomParams1/valueParam1/nomParam2/valueParams2....)
     */
    public function setParams($params)
    {
        $arr = [];

        #on veut avoir cette forme nomParam => valuerParam1
        if (count($params) >= 2){
            for ($i = 0; $i < count($params); $i += 2){
                $k = (isset($params[$i])) ? $params[$i] : $i;
                $v = (isset($params[$i + 1])) ? $params[$i + 1] : NULL;
                $arr[$k] = $v;
            }
            $this->params = $arr;
        }else{
            $this->params = $params;
        }
        var_dump($params);

    }

    /**
     * modifier l'action par defaut
     * @param string $defaultAction
     */
    public function setDefaultAction($defaultAction)
    {
        $this->defaultAction = $defaultAction;
    }

    /**
     * modifier le controller par defaut
     * @param string $defaultController
     */
    public function setDefaultController($defaultController)
    {
        $this->defaultController = $defaultController;
    }

    /**
     * modifier le controller erreur
     * @param string $errorController
     */
    public function setErrorController($errorController)
    {
        $this->errorController = $errorController;
    }

    /**
     * modifier l'action erreur
     * @param string $errorAction
     */
    public function setErrorAction($errorAction)
    {
        $this->errorAction = $errorAction;
    }


}
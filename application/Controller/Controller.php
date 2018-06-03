<?php

namespace Controller;

/**
 * This is the base controller class. 
 * All other "normal" controllers should extend this class.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */
abstract class Controller {
    
    /**
     * @var string Prefix that is used for action methods in controllers.
     */
    const PREFIX_FOR_ACTIONS = 'action_';
    
    /**
     * @var string Suffix for all controllers class names extended by this abstract.
     */
    const SUFFIX_FOR_CONTROLLERS = 'Controller';
    
    /**
     * @var string Name of controller without "Controller" suffix and namespaces.
     */
    public $name;
    
    /**
     * @var string Absolute path to default directory with views for this controller.
     */
    protected $dirViews;

    /**
     * Default action for each controller.
     * 
     * @param array $parameters Parameters passed with URL.
     */
    public abstract function action_index(array $parameters = []);
    
    /**
     * @param bool $loadModel TRUE if load default model for this controller, FALSE if not load model.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    public function __construct(bool $loadModel = true) {
        
        $reflect = new \ReflectionClass($this);
        
        $this->name = strtolower(str_replace($reflect->getNamespaceName(), '', $reflect->getShortName()));
        $this->dirViews = DIR_VIEW . $this->name . DS;
        $this->model = $loadModel ? \Model\Model::loadModel($this->name) : null;
    }
    
    /**
     * Loads footer view template.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    protected function outputFooter() {
        //Default footer.
        require DIR_VIEW . 'templates' . DS . 'footer.phtml';
    }
    
    /**
     * Loads header view template.
     * 
     * @author theKindlyMallard <the.kindly.mallard@gmail.com>
     */
    protected function outputHeader() {
        //Default header.
        require DIR_VIEW . 'templates' . DS . 'header.phtml';
    }
}

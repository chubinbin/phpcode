<?php
/**
 * BehatMink接口
 * 用于测试，以及模拟浏览器，支持js
 * //////////////////////////////////////////////////////////////////////////////////////////////////////
//      页面查找（主要是查得到操作节点） Traversing Pages
/////////////////////////////////////////////////////////////////////////////////////////////////////        
        $page = $session->getPage();    //You can now manipulate the page.初始话完成
        $page->has();   //Checks whether a child element matches the given selector but without returning it.
        $page->findById();//Looks for a child element with the given id.
        $page->findLink();//Looks for a link with the given text, title, id or alt attribute (for images used inside links).
        $page->findButton();//Looks for a button with the given text, title, id, name attribute or alt attribute (for images used inside links).
        $page->findField();//Looks for a field (input, textarea or select) with the given label, placeholder, id or name attribute.
        //find
        $registerForm = $page->find('css', 'form.register');
        $field = $registerForm->findField('Email');
        $title = $page->find('css', 'h1');
        $buttonIcon = $page->find('css', '.btn > .icon'); 
        //findAll
        $anchorsWithoutUrl = $page->findAll('xpath', '//a[not(@href)]');    //XPath Selector xpath 选择器（要用xpath语法）
//////////////////////////////////////////////////////////////////////////////////////////////////////
//      操纵页面（主要是获取方法） Manipulating Pages mink封装方法
/////////////////////////////////////////////////////////////////////////////////////////////////////           
        //mink封装方法
        $el = $page->find('css', '.something');
        
        
        echo $el->getTagName(); // displays 'a'  // get tag name:
        $el->hasAttribute();//Checks whether the element has a given attribute                              NodeElement
        $el->getAttribute();//Gets the value of an attribute.                                               NodeElement
        $el->hasClass();//Checks whether the element has the given class (convenience wrapper around        NodeElement
        
        $el->getHtml();//Gets the inner HTML of the element, i.e. all children of the element.              Element
        $el->getOuterHtml();//Gets the outer HTML of the element, i.e. including the element itself.        Element
        $el->getText();//Gets the text of the element.                                                      Element
        $el->getValue();//Gets the value of the element                                                     NodeElement
        $el->isChecked();//Checks whether the checkbox or radio button is checked.                          NodeElement
        $el->isSelected();//Checks whether the <option> element is selected.                                NodeElement
        $el->hasCheckedField();//Looks for a checkbox (see findField) and checks whether it is checked.     TraversableElement
        $el->hasUncheckedField();//Looks for a checkbox (see findField) and checks whether it is not checkedTraversableElement
        //
//////////////////////////////////////////////////////////////////////////////////////////////////////
//      模拟操作（主要是用户操作$page-> or $el->） Interacting with Pages
/////////////////////////////////////////////////////////////////////////////////////////////////////          
        //form 操作 Interacting with Forms
        $el->setValue();//sets the value of a form field      xpath,array
        $el->check();//checks a checkbox field.
        $el->uncheck();//unchecks a checkbox field.
        $el->selectOption();//select an option in a select box or in a radio group.
        $el->attachFile();//attaches a file in a file input.
        $el->submit();//submits the form.
        //鼠标操作  Interacting with the Mouse
        $el->click();//performs a click on the element.
        $el->doubleClick();//performs a double click on the element.
        $el->rightClick();//performs a right click on the element.
        $el->mouseOver();//moves the mouse over the element.
        //操作键盘 Interacting with the Keyboard
        $el->keyDown();//
        $el->keyPress();//
        $el->keyUp();//
        //操控焦点  Manipulating the Focus
        $el->focus();//
        $el->blur();// blur mehtod
        
//////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      快捷操作方法  Shortcut Methods
//      
/////////////////////////////////////////////////////////////////////////////////////////////////////  
        //mink封装方法
        //里面的click press 都是封装了selenium的方法
        $page->clickLink();//Looks for a link (see findLink) and clicks on it.
        $page->pressButton();//Looks for a button (see findButton) and presses on it.
        $page->fillField();//Looks for a field (see findField) and sets a value in it.
        $page->checkField();//Looks for a checkbox (see findField) and checks it.
        $page->uncheckField();//Looks for a checkbox (see findField) and unchecks it.
        $page->selectFieldOption();//Looks for a select or radio group (see findField) and selects a choice in it.
        $page->attachFileToField();//Looks for a file field (see findField) and attach a file to it.

 */
namespace Component;

class BehatMink{
    protected $session; //浏览器进程
    protected $page;    //当前访问页面的对象，
    protected $element; //选中的页面对象内的节点
    public    $html;  //页面内容
    //方法分类数组
    protected $shortcut_method  = array('fillField');
    protected $query_method     = array('xpath','css');
    protected $operate_method   = array('click','submit');
    protected $page_method   = array('visit','getPage','getHtml','wait');
            
        function __construct() {
            import("Lib.BehatMink.vendor.autoload",APP_PATH,'.php');  
        }
        
        function getSession($driver = 'Selenium2'){
            switch ($driver){
                case 'Goutte':
                    // Choose a Mink driver. More about it in later chapters.
                    //$driver = new \Behat\Mink\Driver\GoutteDriver();
                    $driver = new \Behat\Mink\Driver\GoutteDriver();
                    break;
                case 'Selenium2':
                    // Choose a Mink driver. More about it in later chapters.
                    //$driver = new \Behat\Mink\Driver\GoutteDriver();
                    $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
                    break;
                default:
                    return false;
            }
            $session = new \Behat\Mink\Session($driver);

            return $session;
        }
        
        function closeSession(){
            $this->session->stop();
        }
        
        public function bdd($bdd){
            //$session = $behatMink->getSession('Goutte');        //headless浏览器，速度快，不支持js， 类似curl
            $this->session = $this->getSession($bdd['driver']);   //模拟真实浏览器，速度慢，支持js等操作
            $this->session->start();

            foreach($bdd['command'] as $value){
                 if(in_array($value['cmd'], $this->shortcut_method)){ 
                     //快捷操作方法
                     $this->shortcutMethod($value);
                 }elseif(in_array($value['cmd'], $this->query_method)){
                     //通用节点查询方法
                     $this->queryMethod($value);
                 }elseif(in_array($value['cmd'], $this->operate_method)){
                     //通用操作方法
                     $this->operateMethod($value);
                 }elseif(in_array($value['cmd'], $this->page_method)){
                     //通用操作方法
                     $this->pageMethod($value);
                 }else{
                     echo "Can not find this method!";
                 }
            }
            
            return $this->html;
        }
 
        public function executeCommand($bdd){
            foreach($bdd['command'] as $value){
                 if(in_array($value['cmd'], $this->shortcut_method)){ 
                     //快捷操作方法
                     $this->shortcutMethod($value);
                 }elseif(in_array($value['cmd'], $this->query_method)){
                     //通用节点查询方法
                     $this->queryMethod($value);
                 }elseif(in_array($value['cmd'], $this->operate_method)){
                     //通用操作方法
                     $this->operateMethod($value);
                 }elseif(in_array($value['cmd'], $this->page_method)){
                     //通用操作方法
                     $this->pageMethod($value);
                 }else{
                     echo "Can not find this method!";
                 }
            }
            
            return $this->html;
        }
        
        public function executeRegex($regex){
            $this->html = $this->page->getHTML();
            $html = $this->getHTML();
            if( $value['regex'] == 'multiple'){ 
                $array1 = preg_match();
                // foreach(){
                    // $this->executeRegex($value);
                // }
            }else{
                $result_value = preg_match();
                $this->data[]['INVOICE'] = $result_value;
                $this->executeCommand($regex['cmd']);
                $this->executeRegex($value);
            }
                     //快捷操作方法
            foreach($regex as $value){
                 if(in_array($value['cmd'], $this->shortcut_method)){ 
                     //快捷操作方法
                     $this->executeRegex($value);
                     
                 }elseif(in_array($value['cmd'], $this->query_method)){
                     //通用节点查询方法
                     $this->queryMethod($value);
                 }elseif(in_array($value['cmd'], $this->operate_method)){
                     //通用操作方法
                     $this->operateMethod($value);
                 }elseif(in_array($value['cmd'], $this->page_method)){
                     //通用操作方法
                     $this->pageMethod($value);
                 }else{
                     echo "Can not find this method!";
                 }
            }
            
            return $this->html;
        }
        
        public function getHTML(){
            $this->html = $this->page->getHTML();
            return $this->html;
        }
        /**
         * 快捷操作方法
         * @param type $method
         * array()
         */
        protected function shortcutMethod($data){
            switch( $data['cmd'] ){
                case 'fillField':
                    $this->page->fillField($data['key'], $data['value']);    //填写字段  
                    break;
             }
        }
        /**
         * 节点查询
         * 通用查询方法
         * array('xpath','css')
         */
        protected function queryMethod($data){
            switch( $data['cmd'] ){
                case 'xpath':
                    $this->element = $this->page->find('xpath', $data['value']);    //XPath Selector xpath 选择器（要用xpath语法）
                    break;
                case 'css':
                    $this->element = $this->page->find('css', $data['value']);    //XPath Selector xpath 选择器（要用xpath语法）
                    break;
             }
        }
        /**
         *  通用操作方法
         * 
         */
        protected function operateMethod ($data){
             switch( $data['cmd'] ){
                case 'click':
                    $this->element->click();
                    break;
                case 'submit':
                    $this->element->submit();
                    break;
             }
        }
        /**
         * 页面操作
         * @param type $data
         */
        protected function pageMethod($data){
            switch( $data['cmd'] ){
                case 'visit':
                    $this->session->visit($data['url']);
                    //$page = $session->getPage();
                    break;
                case 'getPage':
                    $this->page = $this->session->getPage();
                    break;
                case 'wait':
                    $this->session->wait($data['value'], "");  //如果是timeout会返回false
                    break;
                case 'getHtml':
                    $this->html = $this->page->getHtml();
                    break;
            }
        }



        
}


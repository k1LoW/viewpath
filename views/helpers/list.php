<?php
class ListHelper extends AppHelper {

    var $helpers = array('Html');

    /**
     * afterLayout
     *
     */
    function afterLayout(){

        parent::afterLayout();
        $view =& ClassRegistry::getObject('view');

        if (!$view) {
            return false;
        }

        $view->output = $view->output;

        if (empty($view->ctp)) {
            $view->ctp = array();
        }

        $viewPath = APP . 'views/';

        if ($view->theme) {
            $viewPath = APP . 'views/themed/' . $view->theme;
        }

        if ($view->params['plugin']) {
            $viewPath = APP . $view->params['plugin'] . '/views/';
        }

        // layout
        array_push($view->ctp, $viewPath . 'layouts/' . $view->layout . $view->ext);

        // view
        array_push($view->ctp, $viewPath . $view->params['controller'] . '/' . $view->params['action'] . $view->ext);

        $viewFiles = '<ul style="margin-left:15px;list-style-type:circle;color:#000000;"><li>' . implode("</li><li>", $view->ctp) . '</li></ul>';

        $tip = '';
        $style = 'position: fixed;
                  border-bottom:1px solid #AAAAAA;
                  background:-moz-linear-gradient(center top , #EFEFEF, #CACACA) repeat scroll 0 0 transparent;
                  -moz-border-radius-bottomright:8px;
                  -moz-border-radius-topright:8px;
                  margin:0px; line-height:1.6em; padding:4px 4px;
                  top:35px; left:0px; cursor:pointer;';
        $tip = "<div id='viewpath' style='" . $style . "'>"
            . $this->Html->image('../viewpath/img/viewpath.png')
            . "</div>";
        $tip .= "<div id='viewpathList' style='background-color: #FFFFFF;
                                           font-size:14px;
                                           display:none;
                                           font-family: helvetica,arial,sans-serif;
                                           padding: 5px;
                                           border: 1px solid #AAAAAA;
                                           position: fixed;
                                           top:65px; left:0px;'>"
            . '<h2 style="font-size:16px;
                          font-family:\'Trebuchet MS\',trebuchet,helvetica,arial,sans-serif;
                          color:#5D1717;margin-bottom:5px;">'
            . 'View File Path'
            . '</h2>'
            . $viewFiles
            . "</div>";
        $tip .= $this->Html->script('../viewpath/js/list.js');

        if (preg_match('#</body>#', $view->output) && $viewFiles) {
            $view->output = preg_replace('#</body>#', $tip . "\n</body>", $view->output, 1);
        }
    }

  }

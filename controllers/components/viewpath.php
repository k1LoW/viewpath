<?php
class ViewpathComponent extends Object {
    /**
     * startup
     *
     * @param &$controller
     * @return
     */
    function startup(&$controller) {

        if (Configure::read('debug') < 1) {
            return false;
        }

        if ($controller->view = 'Theme') {
            $controller->view = 'Viewpath.PathTheme';
        } else {
            $controller->view = 'Viewpath.Path';
        }

        $controller->helpers[] = 'Viewpath.List';
    }

  }
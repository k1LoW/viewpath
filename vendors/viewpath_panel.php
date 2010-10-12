<?php
class ViewpathPanel extends DebugPanel {
	var $plugin = 'viewpath';
	var $title = 'Viewpath';

	function startup(&$controller) { }

	function beforeRender(&$controller) {
		$baseClassName = $controller->view;
		$controller->view = 'Viewpath.Viewpath';
	}
}
?>
<?php
class ViewpathPanel extends DebugPanel {
	var $plugin = 'viewpath';
	var $title = 'Viewpath';

	function startup(&$controller) {
		$baseClassName = $controller->view;
		$controller->view = 'Viewpath.Viewpath';
	}
}
?>
<?php
if (!class_exists('DebugView')) {
	App::import('View', 'DebugKit.Debug');
}

class ViewpathView extends DebugView {

	function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
		$out = parent::_render($___viewFn, $___dataForView, $loadHelpers, $cached);

		if (strpos($___viewFn, '/debug_kit/views/elements/') === false) {
			$this->viewpathCtp[] = array($___viewFn);
		}

		return $out;
	}
}
?>
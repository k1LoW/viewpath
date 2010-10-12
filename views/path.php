<?php
class PathView extends View {
    /**
     * Constructor for ThemeView sets $this->theme.
     *
     * @param Controller $controller
     */
    function __construct(&$controller, $register = true) {
        parent::__construct($controller, $register);
        $this->theme =& $controller->theme;
    }

    /**
     * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
     *
     * This realizes the concept of Elements, (or "partial layouts")
     * and the $params array is used to send data to be used in the
     * Element.      Elements can be cached through use of the cache key.
     *
     * ### Special params
     *
     * - `cache` - enable caching for this element accepts boolean or strtotime compatible string.
     *   Can also be an array. If `cache` is an array,
     *   `time` is used to specify duration of cache.
     *   `key` can be used to create unique cache files.
     * - `plugin` - Load an element from a specific plugin.
     *
     * @param string $name Name of template file in the/app/views/elements/ folder
     * @param array $params Array of data to be made available to the for rendered
     *    view (i.e. the Element)
     * @return string Rendered Element
     * @access public
     */
    function element($name, $params = array(), $loadHelpers = false) {
        $file = $plugin = $key = null;

        if (isset($params['plugin'])) {
            $plugin = $params['plugin'];
        }

        if (isset($this->plugin) && !$plugin) {
            $plugin = $this->plugin;
        }

        if (isset($params['cache'])) {
            $expires = '+1 day';

            if (is_array($params['cache'])) {
                $expires = $params['cache']['time'];
                $key = Inflector::slug($params['cache']['key']);
            } elseif ($params['cache'] !== true) {
                $expires = $params['cache'];
                $key = implode('_', array_keys($params));
            }

            if ($expires) {
                $cacheFile = 'element_' . $key . '_' . $plugin . Inflector::slug($name);
                $cache = cache('views' . DS . $cacheFile, null, $expires);

                if (is_string($cache)) {
                    return $cache;
                }
            }
        }
        $paths = $this->_paths($plugin);

        foreach ($paths as $path) {
            if (file_exists($path . 'elements' . DS . $name . $this->ext)) {
                $file = $path . 'elements' . DS . $name . $this->ext;
                break;
            }
        }

        if (is_file($file)) {
            /** set $this->ctp **/
            if (empty($this->ctp)) {
                $this->ctp = array();
            }
            array_push($this->ctp, $file);

            $params = array_merge_recursive($params, $this->loaded);
            $element = $this->_render($file, array_merge($this->viewVars, $params), $loadHelpers);
            if (isset($params['cache']) && isset($cacheFile) && isset($expires)) {
                cache('views' . DS . $cacheFile, $element, $expires);
            }
            return $element;
        }
        $file = $paths[0] . 'elements' . DS . $name . $this->ext;

        if (Configure::read() > 0) {
            return "Not Found: " . $file;
        }
    }

  }
?>
<?php

App::uses('Component', 'Controller');

/**
 * Base Api Component class
 */
class BaseApiComponent extends Component {

/**
 * Controller instance
 */
	protected $_controller;

/**
 * API Methods
 */
	protected $_apiMethods = array();

/**
 * API Version
 */
	protected $_apiVersion;

/**
 * Route prefix representing the API version
 */
	protected $_apiVersionPrefix;

/**
 * initialize
 */
	public function initialize(Controller $controller) {
		$this->_controller = $controller;
		parent::initialize($controller);

		if (empty($controller->request->params['ext'])) {
			$controller->viewClass = 'Json';
		}

		$this->_apiVersionPrefix = str_replace('.', '_', $this->_apiVersion);

		$methods = $this->_apiMethods;
		foreach ($methods as &$method) {
			$method = $this->_apiVersionPrefix . '_' . $method;
		}

		$controller->methods =
			array_keys(array_flip($controller->methods) +
			array_flip($methods));
	}

/**
 * Get API version
 *
 * @return string API Version
 */
	public function version() {
		return $this->_apiVersion;
	}

/**
 * Verify that current request matches API version this component is serving
 *
 * @return bool
 */
	public function isVersionMatched() {
		if (!$this->_controller->request) {
			return false;
		}
		$prefix = str_replace('.', '_', $this->_controller->request->params['prefix']);
		return $this->_apiVersionPrefix == $prefix;
	}

/**
 * Verify that $action exists in the current request
 *
 * @return bool
 */
	public function isValidAction($action) {
		return $this->isVersionMatched() && in_array($action, $this->_apiMethods);
	}

/**
 * Get a list of API methods
 */
	public function apiMethods() {
		return $this->_apiMethods;
	}

}

<?php

App::uses('BaseApiComponent', 'Croogo.Controller/Component');

class UserApiComponent extends BaseApiComponent {

	protected $_apiVersion = 'v1.0';

	protected $_apiMethods = array(
		'index', 'add', 'edit', 'delete', 'view',
	);

	public function _display($action) {
		$controller = $this->_controller;
		$name = str_replace('Component', '', get_class($this));
		$code = 0;
		$message = sprintf('api: %s -> %s called (%s)',
			$this->_apiVersion, $action, $name
		);
		$response = compact('code', 'message');
		$controller->set(compact('response'));
		$controller->set('_serialize', 'response');
	}

	public function index(Controller $controller) {
		$request = $controller->request;
		$controller->Prg->commonProcess();

		$controller->User->recursive = 0;
		$controller->paginate['conditions'] = $controller->User->parseCriteria(
			$request->query
		);

		$controller->set('users', $controller->paginate());
		$controller->set('_serialize', 'users');
	}

	public function add(Controller $controller) {
		$this->_display('add');
	}

	public function edit(Controller $controller) {
		$this->_display('edit');
	}

	public function view(Controller $controller) {
		$this->_display('view');
	}

	public function delete(Controller $controller) {
		$this->_display('delete');
	}

}

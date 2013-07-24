<?php

App::uses('CakeRoute', 'Routing');

class ApiRoute extends CakeRoute {

	public function parse($url) {
		$parsed = parent::parse($url);
		if (!isset($url['prefix']) || !isset($parsed['action'])) {
			return false;
		}
		$parsed['prefix'] = str_replace('.', '_', $parsed['prefix']);
		return $parsed;
	}

	public function match($url) {
		if (isset($url['prefix'])) {
			$prefix = $url['prefix'];
			$url['prefix'] = str_replace('_', '.', $url['prefix']);
			$url['action'] = str_replace($prefix . '_', '', $url['action']);
		}
		$match = parent::match($url);
		if ($match && isset($url['action']) && $url['action'] == 'index') {
			$match = str_replace('/index', '', $match);
		}
		return $match;
	}

}

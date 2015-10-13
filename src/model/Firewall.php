<?php

abstract class Firewall
{
	const ALLOWED_HTML_TAGS = '<br><img><a>';

	private static $check = [
		'int' => [
			'check' => 'is_numeric',
			'factory' => 'int',
		],
		'string' => [
			'check' => 'is_string',
			'factory' => 'string',
		],
		'html' => [
			'check' => 'is_string',
			'factory' => 'html',
		],
		'bool' => [
			'check' => 'is_string',
			'factory' => 'bool',
		],
		'url' => [
			'check' => 'is_string',
			'factory' => 'url',
		],
	];

	public static function secureGet($secure)
	{
		if (isset($secure['get'])) {
			$gets = [];
			foreach ($secure['get'] as $key => $get) {
				$function = self::$check[$get['type']]['check'];
				if (isset($_GET[$key]) && $function($_GET[$key])) {
					$gets[$key] = self::{self::$check[$get['type']]['factory']}($_GET[$key], $get);
				}
			}

			return $gets;
		}
		return [];
	}

	public static function securePost($secure)
	{
		if (isset($secure['post'])) {
			$posts = [];
			foreach ($secure['post'] as $key => $post) {
				$function = self::$check[$post['type']]['check'];
				if (isset($_POST[$key]) && $function($_POST[$key])) {
					$posts[$key] = self::{self::$check[$post['type']]['factory']}($_POST[$key], $post);
				}
			}

			return $posts;
		}
		return [];
	}

	private static function int($get, $checks)
	{
		if ($get < pow(10, $checks['size'])) {
			return (int)$get;
		}
		return null;
	}

	private static function string($get, $checks)
	{
		if (strlen($get) < $checks['size']) {
			return (string)$get;
		}
	}

	private static function html($get, $checks)
	{
		return strip_tags($get, self::ALLOWED_HTML_TAGS);
	}

	private static function url($get, $checks)
	{
		// A securiser a coup de regex
		return $get;
	}

	private static function bool($get, $checks)
	{
		if ($get === 'true') {
			return true;
		}
		return false;
	}
}

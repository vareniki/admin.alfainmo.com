<?php

App::uses('Component', 'Controller');

class AlfaComponent extends Component {

	/**
	 * @param $info
	 * @return array
	 */
	public static function getTypologyArray($info) {
    $result = array();

    foreach ($info as $item) {
      $firstValue = each($item);
      $value = $firstValue[1]['description'];
      if (!empty($firstValue[1]['description2'])) {
        $value .= ' (' . $firstValue[1]['description2'] . ')';
      }
      $result[$firstValue[1]['id']] = $value;
    }

    return $result;
  }

	/**
	 * @param $object
	 * @param $callback
	 * @param bool $cache
	 * @return array|mixed
	 */
	public function getTypologyInfo($object, $callback, $cache = true) {
	  if (!$cache) {
		  $result = self::getTypologyArray($callback());
	  } else {
		  $result = Cache::read($object);
		  if (!$result) {
			  $result = self::getTypologyArray($callback());
			  Cache::write($object, $result);
		  }
	  }

    return $result;
  }
}
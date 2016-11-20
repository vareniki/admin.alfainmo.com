<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class ModelHelper extends Helper {


  /**
   * @param $text
   * @param bool|false $popup
   *
   * @return mixed
   */
  protected static function linksToHtml($str, $popup = false) {
    if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches)){
      $pop = ($popup == TRUE) ? " target=\"_blank\" " : "";
      for ($i = 0; $i < count($matches['0']); $i++){
        $period = '';
        if (preg_match("|\.$|", $matches['6'][$i])){
          $period = '.';
          $matches['6'][$i] = substr($matches['6'][$i], 0, -1);
        }
        $str = str_replace($matches['0'][$i],
            $matches['1'][$i].'<a target="_blank" href="http'.
            $matches['4'][$i].'://'.
            $matches['5'][$i].
            $matches['6'][$i].'"'.$pop.'>http'.
            $matches['4'][$i].'://'.
            $matches['5'][$i].
            $matches['6'][$i].'</a>'.
            $period, $str);
      }//end for
    }//end if
    return $str;
  }


  public $helpers = array('Html', 'Number', 'Time');

	/**
	 * @param $info
	 * @param $campos
	 * @param array $options
	 */
	public function printIfExists($info, $campos, $options = array()) {
		echo $this->getIfExists($info, $campos, $options);
	}

	/**
	 * @param $info
	 * @param $campos
	 * @param array $options
	 * @return string
	 */
	public function getIfExists($info, $campos, $options = array()) {

		$result = '';

    $model = isset($options['model']) ? $options['model'] : 'Inmueble';
    $format = isset($options['format']) ? $options['format'] : '';
    $tag = isset($options['tag']) ? $options['tag'] : 'li';
		$places = isset($options['places']) ? $options['places'] : 0;

		$moneda =  (isset($info['TipoMoneda']['symbol'])) ? $info['TipoMoneda']['symbol'] : '&euro;';

    if (!is_array($campos)) {
      $campos = array($campos);
    }
    $values = array();
    foreach ($campos as $campo) {
      $value = '';
      if ($model == 'expression') {
        $expr = '$info' . $campo;
        $value = eval("return ((!empty($expr)) ? $expr : '');");
      } else {
        if (!empty($info[$model][$campo])) {
          $value = $info[$model][$campo];
        } else if (!empty($info[$model][0][$campo])) {
          $value = $info[$model][0][$campo];
        }
      }

      if (is_array($value)) {
        foreach ($value as $item) {
          $values[] = $item['description'];
        }
      } else {

        $value = trim($value);

        if (empty($value)) {
          continue;
        }

        switch ($format) {
          case 'email':
            $value = "<a href='mailto:$value'>$value</a>";
            break;
          case 'tel':
            $value = "<a href='tel:$value'>$value</a>";
            break;
          case 'web':
            $value = "<a href='http://$value' target='_blank'>$value</a>";
            break;
          case 'date':
            $value = $this->Time->format('d/m/Y H:i', $value);
            break;
          case 'currency':
            $value = $this->Number->format($value, array('places' => $places, 'before' => false, 'thousands' => '.', 'decimals' => ',')) . ' ' . $moneda;
            break;
          case 'number':
            $value = $this->Number->format($value, array('places' => $places, 'before' => false, 'thousands' => '.', 'decimals' => ','));
            break;
          case 'area':
            $value .= ' m<sup>2</sup>';
            break;
          case 'longitud':
            $value .= ' metros';
            break;
          case 'porc':
            $value .= '%';
            break;
          case 'ud_moneda';
            if (is_numeric($value)) {
              $value = $this->Number->format((int) $value, array('places' => 0, 'before' => false, 'thousands' => '.'));
            } else {
              $value = str_replace('e', $moneda, $value);
            }

            break;
          case 'links_html':
            $value = self::linksToHtml($value);
            break;
        }
        $values[] = $value;
      }
    }
		if (!empty($values)) {
			$separator = isset($options['separator']) ? $options['separator'] : '/';
			$value = implode(" $separator ", $values);

			switch ($tag) {
				case ',':
					$result .= ' ';
					break;
				case '':
					break;
				default:
					$result .= "<$tag>";

			}
			if (isset($options['label'])) {
				$result .= '<span>' . $options['label'] . ' </span>';
			}
			if (isset($options['adicional'])) {
				$value .= ' ' . $options['adicional'];
			}
			$result .= $value;

			if ($tag != ',' && $tag != '') {
				$result .= ".</$tag>";
			}
		}

		return $result;
  }

	/**
	 * @param $info
	 * @param $campos
	 * @param array $options
	 */
	public function printBooleans($info, $campos, $options = array()) {
		echo $this->getBooleans($info, $campos, $options);
	}

	/**
	 * @param $info
	 * @param $campos
	 * @param array $options
	 * @return string
	 */
	public function getBooleans($info, $campos, $options = array()) {

		$result = '';

    $model = isset($options['model']) ? $options['model'] : 'Inmueble';
    $tag = isset($options['tag']) ? $options['tag'] : 'li';

    $values = array();
    foreach ($campos as $campo => $label) {
      $value = '';
      if ($model == 'expression') {
        $expr = '$info' . $campo;
        $value = eval("return ((!empty($expr)) ? $expr : '');");
      } else {

        if (!empty($info[$model][$campo])) {
          $value = $info[$model][$campo];
        } else if (!empty($info[$model][0][$campo])) {
          $value = $info[$model][0][$campo];
        }
      }
      if (!empty($value)) {
        if ($value == 't') {
          $values[] = $label;
        } else if ($value != 'f') {
          $values[] = trim($label . ' ' . $value);
        }
      }
    }

    if (!empty($values)) {
      $value = implode(', ', $values);
	    if ($tag != ',') {
		    $result .= "<$tag>";
	    } else {
		    $result .= ' ';
	    }

      if (isset($options['label'])) {
	      $result .= '<span>' . $options['label'] . '</span>';
      }

	    $result .= $value;
	    if ($tag != ',') {
		    $result .= ".</$tag>";
	    }
    }

		return $result;
  }

}

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
class AppHelper extends Helper {

  public $helpers = array('Form', 'Text', 'Html');

	/**
	 * @param $request
	 * @param $link
	 * @param bool $exact
	 * @param string $noclass
	 * @return string
	 */
	public static function getActiveClass($request, $link, $exact = false, $noclass = '') {
    $result = "";

    if ($link == '') {

      if ($request->url == false) {
        $result = " class='active'";
      }
    } else {

      if (!$exact) {
        if (strpos($request->url, $link) !== false) {
          $result = " class='active'";
        }
      } else if ($request->url == $link) {
        $result = " class='active'";
      }

      if ($result == "" && strpos($link, '/index') !== false) {
        $pieces = explode('/', $link);
        if ($link == $pieces[0]) {
          $result = " class='active'";
        }
      }
    }

    if (empty($result) && !empty($noclass)) {
      $result = " class='$noclass'";
    }
    return $result;
  }

  /**
   * 
   * @return type
   */
  public static function getBrowser() {

    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = null;

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
      $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
      $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
      $platform = 'windows';
    }

    // Next get the name of the useragent yes separately and for good reason.
    if ((preg_match('/MSIE/i', $u_agent) || (preg_match('/Trident/i', $u_agent))) && !preg_match('/Opera/i', $u_agent)) {
      $bname = 'Internet Explorer';
      $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
      $bname = 'Mozilla Firefox';
      $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
      $bname = 'Google Chrome';
      $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
      $bname = 'Apple Safari';
      $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
      $bname = 'Opera';
      $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
      $bname = 'Netscape';
      $ub = "Netscape";
    } else {
      $bname = 'Google Chrome';
      $ub = "Chrome";
    }

    // Finally get the correct version number.
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
      // we have no matching number just continue
    }

    // See how many we have.
    $i = count($matches['browser']);
    if ($i > 1) {
      //we will have two since we are not using 'other' argument yet
      //see if version is before or after the name
      if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
        $version = $matches['version'][0];
      } else {
        $version = $matches['version'][1];
      }
    } elseif ($i == 1) {
      $version = $matches['version'][0];
    }

    // Check if we have a number.
    if ($version == null || $version == "") {
      $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'aname' => $ub,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
  }

  /**
   * 
   * @return type
   */
  public static function getJQueryVersion() {
    $config = Configure::read('alfainmo');

    $nav = self::getBrowser();
    $nav_ver = (int) $nav['version'];
    $jquery = $config['jquery.ie8.js'];

    if (($nav['aname'] == 'Safari' && $nav_ver >= 5) ||
            ($nav['aname'] == 'Chrome' && $nav_ver >= 20) ||
            ($nav['aname'] == 'Firefox' && $nav_ver >= 10) ||
            ($nav['aname'] == 'Opera' && $nav_ver >= 11)) {

      $jquery = $config['jquery.js'];
    }

    return $jquery;
  }

	/**
	 * @param $field
	 * @param $label
	 * @param array $options
	 * @return string
	 */
	public function horizontalInput($field, $label, $options = array()) {

    $result = '';

    if (isset($options['datalist']) && is_array($options['datalist'])) {
      $datalistName = strtolower($field . '_list');

      $result = "<datalist id='$datalistName'>";
      foreach ($options['datalist'] as $item) {
        $result .= "<option value='$item'>";
      }
      $result .= '</datalist>';

      unset($options['datalist']);
    }


    $options['class'] = 'form-control';
    $options['label'] = false;
    $options['div'] = false;
    $divClass = isset($options['divClass']) ? ' ' . $options['divClass'] : '';
    unset($options['divClass']);
		
		$labelClass = isset($options['labelClass']) ? ' ' . $options['labelClass'] : '';
		unset($options['labelClass']);

    $result .= '<div class="form-group' . $divClass . '"><label class="control-label col-xs-5 col-lg-4 col-sm-4' . $labelClass . '">' . $label . '</label><div class="controls col-xs-7 col-lg-8 col-sm-8">';

    if (isset($datalistName)) {
      $options['list'] = $datalistName;
    }

		if (isset($options['click'])) {
			$click_options = $options['click'];
			unset($options['click']);

			$result .= "<div class='input-group'>";
		}

    $result .= $this->Form->input($field, $options);

    if (isset($click_options)) {

	    $result .= "<span class='input-group-btn'>";

	    if (isset($click_options['icon']) || isset($click_options['id']) || isset($click_options['class'])) {
		    $click_array[] = $click_options;
	    } else {
		    $click_array = $click_options;
	    }

	    foreach($click_array as $click_options) {
		    $click_icon = isset($click_options['icon']) ? $click_options['icon'] : '';
		    $click_id = isset($click_options['id']) ? $click_options['id'] : '';
		    $click_class = isset($click_options['class']) ? $click_options['class'] : '';

		    $result .= "<button id='$click_id' class='btn btn-default $click_class' type='button'><i class='glyphicon glyphicon-$click_icon'></i></button>";
	    }

	    $result .= '</span></div>';
    }
    $result .= '</div></div>';

    return $result;
  }

	/**
	 * @param $field
	 * @param $label
	 * @param array $options
	 *
	 * @return string
	 */
  public function horizontalTextarea($field, $label, $options = array()) {
    $options['class'] = 'form-control';
    $options['label'] = false;
    $options['div'] = false;
    $divClass = isset($options['divClass']) ? ' ' . $options['divClass'] : '';
    unset($options['divClass']);

    $result = '<div class="form-group' . $divClass . '"><label class="control-label col-xs-5 col-lg-4 col-sm-4">' . $label . '</label><div class="col-xs-7 col-lg-8 col-sm-8">';
    $result .= $this->Form->textarea($field, $options);
    $result .= '</div></div>';

    return $result;
  }

	/**
	 * @param $field
	 * @param $label
	 * @param $items
	 * @param array $options
	 * @return string
	 */
	public function horizontalSelect($field, $label, $items, $options = array()) {
    $options['class'] = 'form-control';
    $options['label'] = false;
    $options['div'] = false;
    $divClass = isset($options['divClass']) ? ' ' . $options['divClass'] : '';
    unset($options['divClass']);
		
		$labelClass = isset($options['labelClass']) ? ' ' . $options['labelClass'] : '';
    unset($options['labelClass']);

    $result = '<div class="form-group' . $divClass . '"><label class="control-label col-xs-5 col-lg-4 col-sm-4' . $labelClass . '">' . $label . '</label><div class="col-xs-7 col-lg-8 col-sm-8">';
    $result .= $this->Form->select($field, $items, $options);
    $result .= '</div></div>';

    return $result;
  }

	/**
	 * @param $field
	 * @param $label
	 * @param $items
	 * @param array $options
	 * @return string
	 */
	public function horizontalRadio($field, $label, $items, $options = array()) {
    //$options['label'] = false;
    //$options['div'] = false;
    $divClass = isset($options['divClass']) ? ' ' . $options['divClass'] : '';
    unset($options['divClass']);
		
		$labelClass = isset($options['labelClass']) ? ' ' . $options['labelClass'] : '';
    unset($options['labelClass']);

    $result = '<div class="form-group' . $divClass . '"><label class="control-label col-xs-5 col-lg-4 col-sm-4' . $labelClass . '">' . $label . '</label><div class="col-xs-7 col-lg-8 col-sm-8">';
    $result .= $this->Form->radio($field, $items, $options);
    $result .= '</div></div>';

    return $result;
  }

	/**
	 * @param $tiposEvento
	 * @param null $options
	 * @return string
	 */
	public function crmEventTypes($tiposEvento, $options = null) {

    $result = '<div class="btn-toolbar nuevo-evento">';
    $result .= '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary disabled"><i class="glyphicon glyphicon-plus-sign"></i></button></div>';

    $lastType = null;
    foreach ($tiposEvento as $tipo) {

      $data = (object) $tipo['TipoEvento'];

      if ($options != null) {
        if ($data->inc_inmueble == 0 && in_array('inmueble', $options)) {
          continue;
        }
        if ($data->inc_demandante == 0 && in_array('demandante', $options)) {
          continue;
        }
        if ($data->inc_propietario == 0 && in_array('propietario', $options)) {
          continue;
        }
      }

      if ($lastType == null || $lastType != $data->type) {
        if ($lastType != null) {
          $result .= '</ul></div>';
        }
        $result .= "<div class='btn-group'>" .
                "<button type='button' class='btn btn-sm btn-default dropdown-toggle' data-toggle='dropdown'>$data->type  <span class='caret'></span></button><ul class='dropdown-menu'>";
        $lastType = $data->type;
      }
      $result .= "<li><a href='#' class='add-evento' data-id='$data->id' 
        data-description='$data->description'
        data-inmueble='$data->inc_inmueble' data-propietario='$data->inc_propietario' 
        data-demandante='$data->inc_demandante' data-texto='$data->inc_texto' 
        data-valoracion='$data->inc_valoracion'>$data->description</a>\n";
    }

    $result .= '</li></div></div>';

    return $result;
  }

  /**
   * 
   * @param type $info
   * @return type
   */
  public function contactoShowInfo($info, $link=null) {

	  $tooltip = '';
    if (!empty($info['email_contacto'])) {
      $tooltip .= ' EMail:' . $info['email_contacto'] . '.';
    }

	  $telefonos = array();
    if (!empty($info['telefono1_contacto'])) {
	    $telefonos[] = $info['telefono1_contacto'];
    }
    if (!empty($info['telefono2_contacto'])) {
      $telefonos[] = $info['telefono2_contacto'];
    }

	  if (!empty($telefonos)) {
		  $tooltip .= ' Tfnos.: ' . implode(' / ', $telefonos);
	  }
	  if (!empty($tooltip)) {

		  $result = $this->Html->link($info['nombre_contacto'], '#',
			  array('data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => trim($tooltip) . '.'));

	  } else {

		  if ($link != null) {
			  $result = $this->Html->link($info['nombre_contacto'], $link, array('escape' => false));
		  } else {
			  $result = $info['nombre_contacto'];
		  }

	  }

    return $result;
  }

}

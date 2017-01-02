<?php

/**
 * Description of IndexController
 *
 * @author dmonje
 */
class IndexController extends AppController {
/*
	public function getUrlDomibus() {
		$this->layout = null;
		$this->autoRender = false;
		if ($this->request->is('ajax')) {

			$client="alfa"; //identificador de cliente
			$shared_secret = 'sdjduvn9731$SDfsa087124ljkgas7gs87fg8g737g878js9kwk01&(%7(lsooÇ'; // Clave privada compartida. No ha de ser mandado por la URL del API
			$userid = str_pad($this->viewVars['agencia']['Agencia']['numero_agencia'], 4, '0', STR_PAD_LEFT);
			$timestamp = time(); //Toma la hora de vuestro servidor para dar una validez temporal al token
			$token = md5($userid.$shared_secret.$timestamp); //Genera el token encriptado

			$url="https://www.domibus.com/?s2_remote_auto_login=yes&c=".$client."&u=".$userid."&id=".$token."&t=".$timestamp;

			return $url;
		}
	}
*/

	function index() {

		/*
		 *  Domibus
		 */
		/*
		$client="alfa"; //identificador de cliente
		$shared_secret = 'sdjduvn9731$SDfsa087124ljkgas7gs87fg8g737g878js9kwk01&(%7(lsooÇ'; // Clave privada compartida. No ha de ser mandado por la URL del API
		$userid = str_pad($this->viewVars['agencia']['Agencia']['numero_agencia'], 4, '0', STR_PAD_LEFT);
		$timestamp = time(); //Toma la hora de vuestro servidor para dar una validez temporal al token
		$token = md5($userid.$shared_secret.$timestamp); //Genera el token encriptado

		$url="https://www.domibus.com/?s2_remote_auto_login=yes&c=".$client."&u=".$userid."&id=".$token."&t=".$timestamp;

		$this->set('url_domibus', $url);*/
	}

}

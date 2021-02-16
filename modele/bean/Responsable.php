<?php

/**
* Classe permettant d'implémenter un responsable sous forme d'objet.
*/
class Responsable {
	private $IDresp;
	private $nomResp;
	private $prenomResp;
    private $mailResp;
    private $mdpResp;
    private $numtelResp;

	public function getIDresp() {
		return $this->IDresp;
	}
	public function getnomResp() {
		return $this->nomResp;
	}
	public function getprenomResp() {
		return $this->prenomResp;
	}
	public function getmailResp() {
		return $this->mailResp;
    }
    public function getmdpResp() {
        return $this->mdpResp;
    }
    public function getnumtelResp() {
        return $this->numtelResp;
    }
}

?>

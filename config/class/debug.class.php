<?php
/**
* Classe débug : Permet de déboguer le programme
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 06/10/2012
*/
class Debug{
	
	private $debugMode;
	private $onLog;
	private $whatShow;
	private $list = array();
	
	/**
	* Constructeur de la débug
	* @param boolean $debugMode Activer ou désactiver le mode debug
	* @param array $whatShow Indique ce qu'il faut afficher (Erreur, Avertissement, Indication, Autre)
	* @param boolean $onLog Créer un log à partir des erreurs
	*/
	public function __construct($debugMode=false, $whatShow=array(true, true, false, false), $onLog=false){
		$this->debugMode = $debugMode;
		$this->whatShow = $whatShow;
		$this->onLog = $onLog;
	}
	
	/**
	* Ajoute un élément dans le débogueur
	* @param string $text Le texte de débogage
	* @param string $type Le type d'erreur parmis (error, warning, notice)
	* @todo Ajouter la possibilité de gérer un log
	*/
	public function add($text, $type='notice'){
		$element=array($type, $text);
		$this->list[]=$element;
		if($this->debugMode){
			$this->showHTML($element);
		}
	}
	
	/**
	* Ajoute un élément Indication dans le débogueur
	* @param string $text L'indication
	*/
	public function addNotice($text){
		$this->add($text, 'notice');
	}
	
	/**
	* Ajoute un élément Avertissement dans le débogueur
	* @param string $text L'avertissement
	*/
	public function addWarning($text){
		$this->add($text, 'warning');
	}
	
	/**
	* Ajoute un élément Erreur dans le débogueur
	* @param string $text L'erreur
	*/
	public function addError($text){
		$this->add($text, 'error');
	}
	
	/**
	* Affiche tous le débogage en html
	*/
	public function showAllHTML(){
		if(!empty($this->list)){
?><h1><?php echo T_('Débogage'); ?></h1><?php
			foreach($this->list as $k => $v){
				$this->showHTML($v);
			}
		}
	}
	
	/**
	* Affiche un élément de débogage en html
	* @param array $element L'élément à afficher comprenant comme argument 0, le type string de débogage et en argument 1, le message
	*/
	private function showHTML($element){
		$show = true;
		if($element[0]=='error' AND $this->whatShow[0]){
			$debugText = T_('Erreur');
		}
		else if($element[0]=='warning' AND $this->whatShow[1]){
			$debugText = T_('Avertissement');
		}
		else if($element[0]=='notice' AND $this->whatShow[2]){
			$debugText = T_('Indication');
		}
		else if($this->whatShow[3]){
			$debugText = T_('Débogage non identifié');
		}
		else{
			$show = false;
		}
		if($show){
?><p><strong><?php echo $debugText; ?> : </strong><?php echo $element[1]; ?></p><?php
		}
	}
}
?>
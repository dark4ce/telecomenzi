<?php 
class ModelExtensionPaymentEuPlatesc extends Model {
	
	public function getRate(){
		return array('apb'=>'Alpha Bank','bcr'=>'Banca Comerciala Romana','brdf'=>'BRD Finance','btrl'=>'Banca Transilvania','pbr'=>'Piraeus Bank','rzb'=>'Raiffeisen Bank');
	}
	
	public function getRateByInd($ind){
		$i=1;
		foreach($this->getRate() as $code=>$name){
			if($i==$ind)return $code;
			$i++;
		}
	}
	
  	public function getMethod($address) {
		
		if ($this->config->get('euplatesc_status')) {
        	$status = TRUE;
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'euplatesc',
        		'terms'      => '',
        		'title'      => $this->config->get('euplatesc_name'),
				'sort_order' => $this->config->get('euplatesc_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
	
	public function displayRate(){
		//de afisat ratele
		$this->load->language('payment/euplatesc');
		$ret='';
		if($this->config->get('euplatesc_ratestatus')){
			$ret.=$this->getRateScript();
			$ret.='<center><h4>'.$this->language->get('euplatesc_select_tran').'</h4>';
			$ret.='<br><div><input type="radio" name="ep_type" value="0" checked onchange="ep_change(0);">Plata integrala';
			$ret.='<br><input type="radio" name="ep_type" value="1" onchange="ep_change(1);"> Plata in rate';
			$ret.='<br><div id="ep_container" style="display:none;">'.$this->modeRate().'</div></div></center>';
		}
		return $ret;
	}
	
	public function getRateScript(){
		$ret='<script>function ep_change(type){if(type){document.getElementById("ep_container").style.display="block";}else{document.getElementById("ep_container").style.display="none";}}';
		if($this->config->get('euplatesc_ratedisplay')){
			$table=array();
			$table['no']=array("Selecteaza nr. rate");
		
			foreach($this->getRate() as $code=>$name){		
				if($this->config->get('euplatesc_rateactive_'.$code)){
					if($this->config->get('euplatesc_rate_'.$code)!=""){
						$ratenr=explode(',',$this->config->get('euplatesc_rate_'.$code));
						$table[$code]=$ratenr;
					}
				}
			}
			$ret.='window.epr_table=epr_table='.json_encode($table).';';
			$ret.='function ep_bchange(obj){
				var container=document.getElementById("ep_rate_nr");
				var html="";
				for(var i=0;i<epr_table[obj.value].length;i++){
					html+="<option value="+epr_table[obj.value][i]+">"+epr_table[obj.value][i]+" rate</option>";
				}
				container.innerHTML=html;
			}';
		}
		$ret.="</script>";
		return $ret;
	}
	
	public function modeRate(){
		$ret='';
		$afisate=array();
		if($this->config->get('euplatesc_ratedisplay')){/*compact*/
			
			$ret.='<br><select name="euplatesc_rate_banca" onchange="ep_bchange(this);" style="width:200px;" id="ep_rate_banca">';
			$ret.='<option selected value="no">Selecteaza banca</option>';
			$ordinecustom=$this->config->get('euplatesc_rateorder');
			if($ordinecustom!=""){
				$ordinecustom=explode(',',$ordinecustom);
				foreach($ordinecustom as $ind){
					$code=$this->getRateByInd($ind);
					if($this->config->get('euplatesc_rateactive_'.$code)){
						$afisate[]=$code;
						if($this->config->get('euplatesc_rate_'.$code)!=""){
							$ret.='<option value="'.$code.'">'.$this->getRate()[$code].'</option>';
						}
					}
				}
			}
			foreach($this->getRate() as $code=>$name){
				if($this->config->get('euplatesc_rateactive_'.$code)){
					if(!in_array($code,$afisate)){
						if($this->config->get('euplatesc_rate_'.$code)!=""){
							$ret.='<option value="'.$code.'">'.$this->getRate()[$code].'</option>';
						}
					}
				}
			}
			$ret.='</select>';
			$ret.='<select name="euplatesc_rate_nr" style="width:200px;" id="ep_rate_nr">';
			$ret.='<option selected value="no">Selecteaza nr. rate</option>';
			$ret.='</select><br><br>';
			

		}else{
			$ordinecustom=$this->config->get('euplatesc_rateorder');
			if($ordinecustom!=""){
				$ordinecustom=explode(',',$ordinecustom);
				foreach($ordinecustom as $ind){
					$code=$this->getRateByInd($ind);
					if($this->config->get('euplatesc_rateactive_'.$code)){
						$afisate[]=$code;
						if($this->config->get('euplatesc_rate_'.$code)!=""){
							foreach(explode(',',$this->config->get('euplatesc_rate_'.$code)) as $nr){
								$ret.='<input name="euplatesc_rate" type="radio" value="'.$code.'-'.$nr.'">'.$nr.' rate '.$this->getRate()[$code].'<br>';
							}
						}
					}
				}
			}
			foreach($this->getRate() as $code=>$name){
				if($this->config->get('euplatesc_rateactive_'.$code)){
					if(!in_array($code,$afisate)){
						if($this->config->get('euplatesc_rate_'.$code)!=""){
							foreach(explode(',',$this->config->get('euplatesc_rate_'.$code)) as $nr){
								$ret.='<input name="euplatesc_rate" type="radio" value="'.$code.'-'.$nr.'">'.$nr.' rate '.$this->getRate()[$code].'<br>';
							}
						}
					}
				}
			}
		}
		return $ret;
	}
	
	
}
?>
<?php
class SymconPegelstand extends IPSModule
{

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		$this->CreateVarProfilePGLTendenz();
		$this->CreateVarProfilePGLPegelstand();

        $this->RegisterPropertyString("PEGELSTATION", "KONSTANZ");
		$this->RegisterPropertyInteger("Intervall", 14400);
        $this->RegisterPropertyBoolean("debug", false);
		
        $this->RegisterVariableInteger("Tendenz", "Tendenz","PGL.Tendenz",1);
		$this->RegisterVariableFloat("Pegelaktuell", "Pegelstand aktuell","PGL.Pegelstand",0);
		

		
        $this->RegisterTimer("UpdatePegelstand", 14400, 'PGL_Update($_IPS[\'TARGET\']);');
    }

    public function Destroy()
    {
        //Never delete this line!!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
        
        $this->Update();
        $this->SetTimerInterval("UpdatePegelstand", $this->ReadPropertyInteger("Intervall"));
    }

    public function Update()
    {
 		$pegelUrl = "https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/" .$this->ReadPropertyString("PEGELSTATION") ."/W/currentmeasurement.json";
        if($this->ReadPropertyBoolean("debug")) IPS_LogMessage($_IPS['SELF'], $pegelUrl);
        
		$pegelDataJSON = @file_get_contents($pegelUrl);
        if($this->ReadPropertyBoolean("debug")) IPS_LogMessage($_IPS['SELF'], $pegelDataJSON);
        
		$pegelData = json_decode($pegelDataJSON);
		if ($pegelData == NULL)
		{
			echo 'Error on read Pegelonline';
			return;
		}
        
        // 2022-12-17
        // Es wird keine Tendenz mehr ausgegeben.
        $pegelStandAktuell = $pegelData->value;
        $pegelTendenzAktuell = "0";

        $varPegelAktuell = $this->GetValue("Pegelaktuell");
        $pegelStandAktuell = $pegelData->value;
        $pegelTendenzAktuell = "0";

        if($this->ReadPropertyBoolean("debug")) IPS_LogMessage($_IPS['SELF'], "varPegelAktuell: " .$varPegelAktuell);
        if($this->ReadPropertyBoolean("debug")) IPS_LogMessage($_IPS['SELF'], "Pegeldata: " .$pegelStandAktuell);

        if( $varPegelAktuell > $pegelStandAktuell){
                        $pegelTendenzAktuell = "-1";
                }
        if( $varPegelAktuell < $pegelStandAktuell){
                        $pegelTendenzAktuell = "1";
                }

        $this->SetValueFloat("Pegelaktuell", $pegelStandAktuell);
        $this->SetValueInt("Tendenz", $pegelTendenzAktuell);
    }

	private function SetValueInt($Ident, $Value)
	{
    	$id = $this->GetIDforIdent($Ident);
    	SetValueInteger($id, $Value);
    	return true;	
  	}
	
	private function SetValueFloat($Ident, $Value)
	{
    	$id = $this->GetIDforIdent($Ident);
    	SetValueFloat($id, $Value);
    	return true;
  	}
   
    private function SetValueString($Ident, $Value)
    {
    		$id = $this->GetIDforIdent($Ident);
    		if (GetValueString($id) <> $Value)
    		{
    				SetValueString($id, $Value);
    				return true;
    		}
    		return false;
  	}
	
	private function CreateVarProfilePGLTendenz() {
		if (!IPS_VariableProfileExists("PGL.Tendenz")) {
			IPS_CreateVariableProfile("PGL.Tendenz", 1);
			IPS_SetVariableProfileValues("PGL.Tendenz", -1, 1, 1);
			IPS_SetVariableProfileAssociation("PGL.Tendenz", -1, "fallend", "", -1);
			IPS_SetVariableProfileAssociation("PGL.Tendenz", 0, "gleichbleibend", "", -1);
			IPS_SetVariableProfileAssociation("PGL.Tendenz", 1, "steigend", "", -1);
		 }
	}
	
	private function CreateVarProfilePGLPegelstand() {
		if (!IPS_VariableProfileExists("PGL.Pegelstand")) {
			IPS_CreateVariableProfile("PGL.Pegelstand", 2);
			IPS_SetVariableProfileValues("PGL.Pegelstand", -1, 1, 1);
			IPS_SetVariableProfileAssociation("PGL.Pegelstand", 0, "%.1f", "", -1);
			IPS_SetVariableProfileAssociation("PGL.Pegelstand", 330, "%.1f", "", -1);
			IPS_SetVariableProfileAssociation("PGL.Pegelstand", 400, "%.1f", "", -1);
			IPS_SetVariableProfileIcon("PGL.Pegelstand",  "Wave");
		 }
	}
	
}
?>
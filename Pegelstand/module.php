<?
class SymconPegelstand extends IPSModule
{

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        $this->RegisterPropertyString("PEGELSTATION", "KONSTANZ");
		$this->RegisterPropertyInteger("Intervall", 1800);
		
        $this->RegisterVariableInteger("Tendenz", "Tendenz","",1);
		$this->RegisterVariableFloat("Pegelaktuell", "Pegelstand aktuell","",0);
		
        $this->RegisterTimer("UpdatePegelstand", 1800, 'PGL_Update($_IPS[\'TARGET\']);');
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
		
		$pegelDataJSON = @file_get_contents($pegelUrl);
		$pegelData = json_decode($pegelDataJSON);
		
		$pegelStandAktuell = $pegelData->value;
		$this->SetValueFloat("Pegelaktuell", $pegelStandAktuell);
		
		$pegelTendenzAktuell = $pegelData->trend;
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
	
}
?>
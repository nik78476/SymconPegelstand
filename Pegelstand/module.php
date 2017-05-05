<?
class SymconPegelstand extends IPSModule
{

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.


        $this->RegisterPropertyString("PegelstandURL", "https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/KONSTANZ/W/currentmeasurement.json");
        $this->RegisterPropertyInteger("Intervall", 1800);
        $this->RegisterVariableInteger("Tendenz", 0);
		$this->RegisterVariableFloat("Pegelaktuell", 333.0);
		
        $this->RegisterTimer("UpdatePegelstand", 0, 'PGL_Update($_IPS[\'TARGET\']);');
    }

    public function Destroy()
    {
        $this->UnregisterTimer("UpdatePegelstand");
        
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
        IPS_LogMessage($_IPS['SELF'], "Pegelstand wird abgefragt.");
		
		$pegelUrl = $this->ReadPropertyString("PegelstandURL");
		$pegelDataJSON = @file_get_contents($pegelUrl);
		$pegelData = json_decode($pegelDataJSON);
		
		$pegelStandAktuell = $pegelData->value;
		IPS_LogMessage($_IPS['SELF'], "Pegelaktuell: ". $pegelStandAktuell. " ");
		$this->SetValueFloat("Pegelaktuell", $pegelStandAktuell);
		
		$pegelTendenzAktuell = $pegelData->trend;
		IPS_LogMessage($_IPS['SELF'], "Pegeltendenz: ". $pegelTendenzAktuell. " ");
		$this->SetValueInt("Tendenz", $pegelTendenzAktuell);
    }

	private function SetValueInt($Ident, $Value)
	{
    		$id = $this->GetIDforIdent($Ident);
    		if (GetValueInteger($id) <> $Value)
    		{
    				SetValueInteger($id, $Value);
    				return true;
    		}
    		return false;
  	}
	
	private function SetValueFloat($Ident, $Value)
	{
    		$id = $this->GetIDforIdent($Ident);
    		if (GetValueFloat($id) <> $Value)
    		{
    				SetValueFloat($id, $Value);
    				return true;
    		}
    		return false;
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

    protected function RegisterTimer($Name, $Interval, $Script)
    {
        $id = @IPS_GetObjectIDByIdent($Name, $this->InstanceID);
        if ($id === false)
            $id = 0;


        if ($id > 0)
        {
            if (!IPS_EventExists($id))
                throw new Exception("Ident with name " . $Name . " is used for wrong object type", E_USER_WARNING);

            if (IPS_GetEvent($id)['EventType'] <> 1)
            {
                IPS_DeleteEvent($id);
                $id = 0;
            }
        }

        if ($id == 0)
        {
            $id = IPS_CreateEvent(1);
            IPS_SetParent($id, $this->InstanceID);
            IPS_SetIdent($id, $Name);
        }
        IPS_SetName($id, $Name);
        IPS_SetHidden($id, true);
        IPS_SetEventScript($id, $Script);
        if ($Interval > 0)
        {
            IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, $Interval);

            IPS_SetEventActive($id, true);
        } else
        {
            IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, 1);

            IPS_SetEventActive($id, false);
        }
    }

    protected function UnregisterTimer($Name)
    {
        $id = @IPS_GetObjectIDByIdent($Name, $this->InstanceID);
        if ($id > 0)
        {
            if (!IPS_EventExists($id))
                throw new Exception('Timer not present', E_USER_NOTICE);
            IPS_DeleteEvent($id);
        }
    }

    protected function SetTimerInterval($Name, $Interval)
    {
        $id = @IPS_GetObjectIDByIdent($Name, $this->InstanceID);
        if ($id === false)
            throw new Exception('Timer not present', E_USER_WARNING);
        if (!IPS_EventExists($id))
            throw new Exception('Timer not present', E_USER_WARNING);

        $Event = IPS_GetEvent($id);

        if ($Interval < 1)
        {
            if ($Event['EventActive'])
                IPS_SetEventActive($id, false);
        }
        else
        {
            if ($Event['CyclicTimeValue'] <> $Interval)
                IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, $Interval);
            if (!$Event['EventActive'])
                IPS_SetEventActive($id, true);
        }
    }
}
?>
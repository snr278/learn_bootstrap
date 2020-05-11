<?php
class ldapUserOper
{
    private $server_addr;
    private $port;
    private $base_dn;
    private $connectId;
    private $bind_dn;
    private $bind_pass;
    private $userEntryIdName;
    private $userEntryIdValue;
    private $userEntryDn;
    private $accountEntryIdName;
    private $accountEntryIdValue;
    private $accCnt;
    private $filter;
    private $search_filds;
    private $userReadId;


    public function __construct($server_addr,$UserIdValue,$port="389",$base_dn="ou=users,dc=DHBU,dc=NSB",$bind_dn="cn=admin,dc=DHBU,dc=NSB",$bind_pass="dhbuldaps")
    {
        $this->server_addr=$server_addr;
        $this->port=$port;
        $this->base_dn=$base_dn;
        $this->bind_dn=$bind_dn;
        $this->bind_pass=$bind_pass;
        $this->userEntryIdName="mail";
        $this->accountEntryIdName="uid";
        $this->filter="objectClass=*";
        $this->accCnt=0;
        $this->search_filds=array('uid','host', 'userPassword');
        $this->userReadId=false;
        $this->userEntryIdValue=$UserIdValue;
        $this->userEntryDn=$this->userEntryIdName."=".$this->userEntryIdValue.",".$this->base_dn;
        $this->connectId=ldap_connect($this->server_addr,$this->port);
        if (!is_resource($this->connectId))
        {
            throw new Exception("That LDAP-URI was not parseable");
        }
        if(!ldap_set_option($this->connectId,LDAP_OPT_PROTOCOL_VERSION,3))
        {
            $this->throwErr("Failed to set protocol version to 3 ");
        }
        if(!ldap_set_option($this->connectId,LDAP_OPT_REFERRALS,0))
        {
            $this->throwErr("set LDAP_OPT_REFERRALS failed ");
        }
        if (!ldap_bind ($this->connectId,$this->bind_dn,$this->bind_pass))
        {
            $this->throwErr("bind failed,err ");
        }
    }
    private function getErrStr()
    {
        $err_str=ldap_error ($this->connectId);
        ldap_close($this->connectId);
        return '['.$err_str.']';
    }
    private function throwErr($err_str)
    {
        throw new Exception($err_str.$this->getErrStr());
    }
    private function addEntry($add_dn,$add_info)
    {
        if(!ldap_add ($this->connectId,$add_dn,$add_info))
        {
            $this->throwErr("add enntry failed!");
        }
        return true;
    }

    public function getUserEntryDn()
    {
        return $this->userEntryDn;
    }
    public function getAccountEntryDn($account)
    {
        $pre_dn=$this->getUserEntryDn();
        return $this->accountEntryIdName."=".$account.",".$pre_dn;
    }

    public function isUserEntryExist()
    {
        $dn=$this->getUserEntryDn();
        if (is_null($dn))
        {
            return false;
        }
        $this->userReadId=ldap_read ($this->connectId,$dn,$this->filter);
        if (!is_resource($this->userReadId))
        {
            return false;
        }
        return true;
    }

    public function addUserEntry($employeeId,$name)
    {
        if($this->isUserEntryExist())
        {
            return true;
        }
        $info = $this->assembleUserEntryInfo($employeeId,$name);
        $dn=$this->getUserEntryDn();
        return $this->addEntry($dn,$info);
    }
    public function getAllAccountEntry()
    {
        $ret_id=ldap_list($this->connectId,$this->userEntryDn,"objectClass=*",$this->search_filds);
        if (!is_resource($ret_id))
        {
            $this->throwErr("get all account entry ldap_list failed!");
        }
        $retData=ldap_get_entries ($this->connectId,$ret_id);
        if (!$retData)
        {
            $this->throwErr("get all account entry ldap_get_entries failed!");
        }
        $this->accCnt=$retData["count"];
        return $retData;
    }
    private function assembleUserEntryInfo($employeeId,$name)
    {
        $Info["sn"]=$employeeId;
        $Info["cn"]=$name;
        $Info[$this->userEntryIdName]=$this->userEntryIdValue;
        $Info["objectClass"]="pilotPerson";
        return $Info;
    }
    public function assembleAccountEntryInfo($account,$passwd,$host)
    {
        $Info[$this->accountEntryIdName]=$account;
        $Info["objectClass"][0]="account";
        $Info["objectClass"][1]="simpleSecurityObject";
        $Info["userPassword"]=sprintf('{SHA}%s',base64_encode(pack('H*',hash('sha1',$passwd))));
        $Info["host"][0]=$host;

        return $Info;
    }
    public function addAcc($account,$passwd,$host)
    {
        $entryInfo=$this->assembleAccountEntryInfo($account,$passwd,$host);
        $dn=$this->getAccountEntryDn($account);
        return $this->addEntry($dn,$entryInfo);
    }
    public function getAccountCnt()
    {
        return $this->accCnt;
    }
}


?>
<?php
$server_addr="127.0.0.1";
$root_dn="dc=DHBU,dc=NSB";

$ldap_id=ldap_connect($server_addr,"389");

$filter="(objectclass=*)";

if(! is_resource($ldap_id))
    die("ldap_connect failed\n");

ldap_set_option($resource,LDAP_OPT_PROTOCOL_VERSION,3);
ldap_set_option($resource,LDAP_OPT_REFERRALS,0);

echo "连上 ".$ldap_id."<p>";
$is_success=ldap_bind ($ldap_id,'cn=admin,dc=DHBU,dc=NSB','dhbuldaps');
if($is_success)
{
    //$SEARCH_DN= 'uid=byang006,ou=users,dc=DHBU,dc=NSB';
    $SEARCH_DN= 'mail=123456@test.com,ou=users,dc=DHBU,dc=NSB';
    $SEARCH_FIELDS= array('uid','host', 'userPassword');
    $users_dn="ou=users,".$root_dn;
    $email="123456@test.com";
    //$addInfo=assembleUserEntryInfo("123456",$email,"123456");
    $ret_obj=ldap_list ($ldap_id,$SEARCH_DN,"objectClass=*",$SEARCH_FIELDS);
    //$ret_obj=ldap_search ($ldap_id,$SEARCH_DN,"objectClass=*",$SEARCH_FIELDS);
    //$ret_obj=ldap_read ($ldap_id,$SEARCH_DN,$filter);
    $Add_Dn="uid=test,".$SEARCH_DN;
    //$addInfo=assembleAccountEntryInfo("aaa","aaa",array("1.1.1.1","2.2.2.2"));
    //$is_success=ldap_add ($ldap_id,$Add_Dn,$addInfo);

    $Entry['host'][]="3.3.3.3";
    $Entry['host'][]="3.3.4.3";
    $is_success = ldap_mod_add($ldap_id, $Add_Dn, $Entry);
    if (!$is_success)
    {
        $err_str=ldap_error($ldap_id);
        ldap_close($ldap_id);
        die("ldap_add failed!".$err_str);
    }
    $retData=ldap_get_entries ($ldap_id,$ret_obj);

    echo "<h1>Dump all data1</h1><pre>";
    print_r($retData);
    echo "</pre>";

    $ret_obj=ldap_list ($ldap_id,$SEARCH_DN,"objectClass=*",$SEARCH_FIELDS);
    $retData=ldap_get_entries ($ldap_id,$ret_obj);
    echo "<h1>Dump all data2</h1><pre>";
    print_r($retData);
    echo "</pre>";

    $hash_var=base64_encode(pack('H*',hash('sha1',"123456")));
    echo "has value ".$hash_var;

}
else
{
    $err_str=ldap_error ($ldap_id);
    echo "bind failed!".$err_str;
}
ldap_close($ldap_id); 

function assembleUserEntryInfo($employeeId,$email,$name)
{
    $Info["sn"]=$employeeId;
    $Info["cn"]=$name;
    $Info["mail"]=$email;
    $Info["objectClass"]="pilotPerson";
    return $Info;
}
function assembleAccountEntryInfo($account,$passwd,$host)
{
    if (!is_array($host))
    {
        throw new Exception("host should be array ");
    }
    $Info['uid']=$account;
    $Info["objectClass"][0]="account";
    $Info["objectClass"][1]="simpleSecurityObject";
    $Info["userPassword"]=sprintf('{SHA}%s',base64_encode(pack('H*',hash('sha1',$passwd))));
    $cnt=0;
    foreach($host as $addr)
    {
        $Info["host"][$cnt]=$addr;
        $cnt=$cnt+1;
    }
    return $Info;
}

?>
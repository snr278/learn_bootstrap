<?php
require_once('ldapUserOper.php');
try {
    $ldap_Op=new ldapUserOper('127.0.0.1','test@test.com');
    $ldap_Op->addUserEntry('666666','aaaaaa');

    procOpt($ldap_Op);
    //$result=$ldap_Op->modPwd("bbbadf","abcde");

    //var_dump($result);

    $allAccount=$ldap_Op->getAllAccountEntry();
    
    $ldap_Op->closeCon();
} catch (\Throwable $th) {
    //throw $th;
}
//var_dump($_GET);


function procOpt($ldap_Op)
{
    if(array_key_exists("delAcc",$_GET))
    {
        if(empty($_GET["accName"]))
        {
            return;
        }
        $ldap_Op->delAcc($_GET["accName"]);
    }
    else if (array_key_exists("addAcc",$_GET))
    {
        if((empty($_GET["accName"]))||(empty($_GET["accPwd"]))||
        (empty($_GET["host"])))
        {
            return ;
        }
        $ldap_Op->addAcc($_GET["accName"],$_GET["accPwd"],$_GET["host"]);
    }
    else if (array_key_exists("addHost",$_GET))
    {
        if((empty($_GET["accName"]))||(empty($_GET["host"])))
        {
            return ;
        }
        $ldap_Op->addHost($_GET["accName"],$_GET["host"]);
    }
    else if (array_key_exists("delHost",$_GET))
    {
        if((empty($_GET["accName"]))||(empty($_GET["host"])))
        {
            return ;
        }
        $ldap_Op->delHost($_GET["accName"],$_GET["host"]);
    }
    else if (array_key_exists("modPwd",$_GET))
    {
        if((empty($_GET["accName"]))||(empty($_GET["accPwd"])))
        {
            return;
        }
        $ldap_Op->modPwd($_GET["accName"],$_GET["accPwd"]);
    }
}

function showHosts($href,$accName,$hosts)
{
    
$page_format=<<<PAGEFORMAT
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="%shost%d">Host:</label>
    <div class="col-md-6">
        <input type="text" class="form-control" readonly id="%shost%d" value="%s">
    </div>
    <div class="col-md-3">
        <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="%s">
            <i class="fa fa-trash-o text-danger jqvmap-region"></i>
        </a>
    </div>
</div>

PAGEFORMAT;
    $page="";
    for($i=0;$i<$hosts["count"];$i++)
    {
        $tmp_href=$href."&host=".$hosts[$i];
        $page.=sprintf($page_format,$accName,$i,$accName,$i,$hosts[$i],$tmp_href);
    }
    return $page;

}

function showCard($accInfo)
{
    $accName=$accInfo["uid"][0];
    $pageHref="test.php";
    $deleAccountHref=$pageHref."?delAcc=1&accName=".$accName;
    $delHostHref=$pageHref."?delHost=1&accName=".$accName;

    
    $hostsPage=showHosts($delHostHref,$accName,$accInfo["host"]);
//accountName, deleAccountHref,formAction,accountName,
$page=<<<PAGEFORMAT
<div class="card card-block sameheight-item rounded" style="border:1px solid rgb(73, 177, 99); ">
    <div class="card-header bordered">
        <div class="header-block">
            <h4 class="title">{$accName}</h3>
        </div>
        <div class="header-block pull-right">
            <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="{$deleAccountHref}">
                <i class="fa fa-trash-o text-danger jqvmap-region"></i>
            </a>
        </div>
    </div>
    <div class=" card-body">
        <form action="{$pageHref}" method="get">
            <input type="hidden" name="accName" value="{$accName}">
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="{$accName}password">Password:</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" id="{$accName}password" name="accPwd" placeholder="******" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary rounded" name="modPwd" onClick='HashPwd("{$accName}password")' >Modify</button>
                </div>
            </div>
            {$hostsPage}
            
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="{$accName}host">Host:</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="{$accName}host" name="host" placeholder="xxx.xxx.xxx.xxx">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary rounded" name="addHost" onClick='return isValidIp("{$accName}host")'>Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

PAGEFORMAT;
    
    return $page;
}
function showCards($allAccount)
{
    $page="";
    
    for($i=0;$i<$allAccount["count"];$i++)
    {
        $page.=showCard($allAccount[$i]);
        
    }
    
    return $page;
}

?>


<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> ModularAdmin - Free Dashboard Theme | HTML Version </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="css/vendor.css">
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        
        <div class="main-wrapper">
            <div class="app pl-lg-0 " id="app">
                <header class="header text-center " style="left:0">
                    <div class="m-auto">
                        <h1 class="title l text-center"> Build Account Info </h1>
                    </div>
                </header>
                <article class="content ">
                    <section class="section ">
                        <div class="row sameheight-container">
                            <div class="m-auto w-50">
                                <div class="card " >
                                    <div class="card-header bordered">
                                        <div class="header-block">
                                            <h3 class="title"> Total Accounts: <?php echo $ldap_Op->getAccountCnt()?> </h3>
                                        </div>
                                        <div class="header-block pull-right">
                                            <a href="" class="btn btn-primary btn-sm rounded pull-right" data-toggle="modal" data-target="#AddAccountModal"> Add new </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        
                                        <?php echo showCards($allAccount);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
                
                <div class="modal fade" id="AddAccountModal" aria-hidden="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> New Account</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="test.php" method="get" >
                                    <div class="form-group">
                                        <label for="name">Account Name</label>
                                        <input type="text" class="form-control" id="name" name="accName" placeholder="Name" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="accPwd">Password</label>
                                        <input type="password" class="form-control" id="accPwd" name="accPwd" placeholder="Password" required="required" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="host">Host</label>
                                        <input type="text" class="form-control" id="host" name="host" placeholder="xx.xx.xx.xx" required="required">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="addAcc" onClick='return checkAddInfo("accPwd","host")'>Submit</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade" id="confirm-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure want to delete this item?</p>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-primary">Yes</a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script src="js/jquery-slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/hashes.min.js"></script>
        <script>
            (function(i, s, o, g, r, a, m)
            {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function()
                {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-80463319-4', 'auto');
            ga('send', 'pageview');


            $('#confirm-modal').on('show.bs.modal', function (event) {

                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('href') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                
                $(this).find('.btn-primary').attr('href' ,recipient)

                })
            function HashPwd(pwdId)
            {
                var id_str="#"+pwdId;
                var text=$(id_str).val();
                var SHA512 = new Hashes.SHA512;
                var pwd=SHA512.b64(text);
                $(id_str).val("{SHA512}"+pwd);
            }

            function isValidIp(hostId)
            {
                var id_str="#"+hostId;
                var text=$(id_str).val();
                if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(text))
                {
                    return true;
                }
                $(id_str).val("");
                alert("You have entered an invalid IP address!")
                return false;
            }
            function checkAddInfo(pwdId,hostId)
            {
                if(!isValidIp(hostId))
                {
                    return false;
                }
                HashPwd(pwdId);
                return true;
            }
        </script>
        <script src="js/vendor.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
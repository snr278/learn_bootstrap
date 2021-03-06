<?php

function getAccountCnt($cnt)
{
    return $cnt;
}

function showAcc()
{
    $AccountCnt="3";
$accInfo=<<<ACCINFO
<h3 class="title"> Total Accounts: {getAccountCnt($AccountCnt)} </h3>

ACCINFO;
    return $accInfo;
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
                                            <?php echo showAcc()?>
                                        </div>
                                        <div class="header-block pull-right">
                                            <a href="" class="btn btn-primary btn-sm rounded pull-right" data-toggle="modal" data-target="#AddAccountModal"> Add new </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card card-block sameheight-item" style="border:1px solid rgb(73, 177, 99); border-radius:20px">
                                            <div class="card-header bordered">
                                                <div class="header-block">
                                                    <h4 class="title"> account1 </h3>
                                                </div>
                                                <div class="header-block pull-right">
                                                    <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="./index.html">
                                                        <i class="fa fa-trash-o text-danger jqvmap-region"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class=" card-body">
                                                <form>
                                                    
                        
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="password">Password:</label>
                                                        <div class="col-md-6">
                                                            <input type="password" class="form-control" id="password" placeholder="******">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary " >Modify</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="host1">Host:</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" readonly id="host1" value="1.1.1.1">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="./index.html">
                                                                <i class="fa fa-trash-o text-danger jqvmap-region"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="host2">Host:</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" id="host2" placeholder="xxx.xxx.xxx.xxx">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary " >Add</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card card-block sameheight-item" style="border:1px solid rgb(73, 177, 99); border-radius:20px">
                                            <div class="card-header bordered">
                                                <div class="header-block">
                                                    <h4 class="title"> account1 </h3>
                                                </div>
                                                <div class="header-block pull-right">
                                                    <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="./index.html">
                                                        <i class="fa fa-trash-o text-danger jqvmap-region"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class=" card-body">
                                                <form>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="password">Password:</label>
                                                        <div class="col-md-6">
                                                            <input type="password" class="form-control" id="password" placeholder="******">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary " >Modify</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="host1">Host:</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" readonly id="host1" value="1.1.1.1">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a class="remove" data-toggle="modal" data-target="#confirm-modal" data-href="./index.html">
                                                                <i class="fa fa-trash-o text-danger jqvmap-region"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label" for="host2">Host:</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" id="host2" placeholder="xxx.xxx.xxx.xxx">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary " >Add</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
                                <form role="form" action="test.html">
                                    <div class="form-group">
                                        <label for="name">Account Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="passwd">Password</label>
                                        <input type="password" class="form-control" id="passwd" placeholder="Password" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="host">Host</label>
                                        <input type="text" class="form-control" id="host" placeholder="xx.xx.xx.xx" required="required">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" >Submit</button>
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
                                <p>Are you sure want to do this?</p>
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
        </script>
        <script src="js/vendor.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
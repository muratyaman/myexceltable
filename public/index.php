<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="MY ExcelTable">
        <meta name="author" content="muratyaman@gmail.com">
        
        <title>MY ExcelTable</title>
        
        <!-- Bootstrap -->
        <link href="/bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- sample taken from bootstrap -->
        <link href="cover.css" rel="stylesheet">
        
        <!-- HACI custom css -->
        <link href="index.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    
    </head>
    <body>
        
        <div class="site-wrapper">

            <div class="site-wrapper-inner">

              <div class="cover-container">

                <div class="masthead clearfix">
                  <div class="inner">
                    <h3 class="masthead-brand">MY ExcelTable</h3>
                    <ul class="nav masthead-nav">
                      <li class="active"><a href="#">Home</a></li>
                      <li><a href="#">Features</a></li>
                      <li><a href="#">Contact</a></li>
                    </ul>
                  </div>
                </div>

                <div class="inner cover">
                  
                    <form id="frmTable" name="frmTable" action="api.php" class="my_exceltable">

                        <div class="fx_cell_container">
                            <table border="0" cellspacing="2" cellpadding="0" width="100%">
                                <tr>
                                    <td>Current:</td>
                                    <td>(</td>
                                    <td><input id="current_row" name="current_row" value="" size="2" readonly /></td>
                                    <td>,</td>
                                    <td><input id="current_column" name="current_column" value="" size="2" readonly /></td>
                                    <td>)</td>
                                    <td><label for="fx_cell">f(x)</label></td>
                                    <td><input type="text" id="fx_cell" name="fx_cell" size="50" class="fx_cell" /></td>
                                    <td><button id="btn_ok" class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok"></span> OK</button></td>
                                    <td><button id="btn_cancel" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span> Cancel</button></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="table_container">

                            <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <th>&nbsp;</th>
                                    <?php for($r = 0; $r < 10; $r++): ?>
                                    <th><?php echo $r; ?></th>
                                    <?php endfor; ?>
                                </thead>
                                <tbody>
                                    <?php for($r = 0; $r < 10; $r++): ?>
                                    <tr>
                                        <td>&nbsp;<?php echo $r; ?>&nbsp;</td>
                                        <?php for($c = 0; $c < 10; $c++): ?>
                                        <td><input type="text" size="10" class="mycell"
                                                   id="data_<?php echo $r; ?>_<?php echo $c; ?>"
                                                   name="data[<?php echo $r; ?>][<?php echo $c; ?>]"
                                                   data-row="<?php echo $r; ?>" 
                                                   data-column="<?php echo $c; ?>"
                                                   />
                                            <input type="hidden" class="mycell_formula"
                                                   id="formula_<?php echo $r; ?>_<?php echo $c; ?>"
                                                   name="formulae[<?php echo $r; ?>][<?php echo $c; ?>]" 
                                                   data-row="<?php echo $r; ?>" 
                                                   data-column="<?php echo $c; ?>"
                                                   />
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                            
                            <div id="mymessages" class="alert alert-info"></div>
                        </div>
                    </form>
                  
                </div>

                <div class="mastfoot">
                  <div class="inner">
                    <p>MY ExcelTable by <a href="http://muratyaman.co.uk">muratyaman.co.uk</a>.</p>
                  </div>
                </div>

              </div>

            </div>

          </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="jquery-2.1.1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/bootstrap-3.1.1/js/bootstrap.min.js"></script>
        
        <!-- HACI custom code -->
        <script src="index.js" ></script>
        
    </body>
</html>
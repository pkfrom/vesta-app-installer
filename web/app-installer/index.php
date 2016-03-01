<?php
// Automatic APP INSTALLER FOR VESTA CP
// THIS SOFTWARE IS PROVIDED FOR FREE BY JOE MATTOS OWNER OF CDNMALL.COM.

  ob_start();
  session_start();
  $_SESSION['back'] = '/app-installer/';
  include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");
  include($_SERVER['DOCUMENT_ROOT']."/app-installer/scripts_DB.php");

    if(isset($_POST['ok']) && isset($_SESSION['token']) && ($_POST['ok'] == $_SESSION['token'])):

      if(empty($_POST['cdn_instdir'])) :
        $_SESSION['error_msg'] .= "YOU MUST ENTER AN INSTALL DIRECTORY.#";
      endif;
      
      if(substr($_POST['cdn_instdir'],0, 1) != "/") :
        $_SESSION['error_msg'] .= "INSTALL DIRECTORY MUST START WITH /.#";
      endif;
      
      if(stristr($_POST['cdn_instdir'], '..')!==FALSE) :
        $_SESSION['error_msg'] .= "INCORRECT DIRECTORY";
      endif;
      
      if(empty($_POST['cdn_domain'])) :
        $_SESSION['error_msg'] .= "PLEASE SELECT A DOMAIN.#";
      endif;
      
      if (empty($_POST['cdn_admin_email']) || (!filter_var($_POST['cdn_admin_email'], FILTER_VALIDATE_EMAIL))):
          $_SESSION['error_msg'] .= "PLEASE ENTER VAILD EMAIL ADDRESS.#";
      endif;
      
      if(empty($_POST['cdn_admin_user'])) :
        $_SESSION['error_msg'] .= "PLEASE ENTER A ADMIN USERNAME.#";
      endif;
      
      if(empty($_POST['cdn_package'])) :
        $_SESSION['error_msg'] .= "PLEASE SELECT A APP PACKAGE TO INSTALL.#";
      endif;
      
      if(empty($_POST['cdn_packagev'])) :
        $_SESSION['error_msg'] .= "PLEASE ENTER A APP PACKAGE VERSION TO INSTALL.#";
      endif;
      
      if(empty($_POST['cdn_public'])) :
        $_SESSION['error_msg'] .= "PLEASE SELECT A public_html OR public_shtml.#";
      endif;

      if(empty($_SESSION['error_msg'])):
        $cdn_public  = escapeshellarg($_POST['cdn_public']);
        $cdn_domain  = escapeshellarg($_POST['cdn_domain']);
        $cdn_instdir = escapeshellarg($_POST['cdn_instdir']);
        $cdn_package = escapeshellarg($_POST['cdn_package']);
        $cdn_packagev = escapeshellarg($_POST['cdn_packagev']);
        $cdn_admin_user = escapeshellarg($_POST['cdn_admin_user']);
        $cdn_admin_email = escapeshellarg($_POST['cdn_admin_email']);
      
          //When Admin is Logged in as user change there session to the real username
          if(isset($_SESSION['look']) && $_SESSION['user'] == 'admin' && $_SESSION['look'] != '') {
            $user = $_SESSION['look'];
          }
          
            exec (VESTA_CMD."v-app $user $cdn_instdir $cdn_public $cdn_domain $cdn_package $cdn_packagev $cdn_admin_user $cdn_admin_email", $output, $return_var);
            check_return_code($return_var,$output);
            
              if ($return_var == 0) {
                foreach($output as $out => $out_value) {
                  $_SESSION['ok_msg'] .= $out_value;
                }
              }
              
            unset($output);
      endif;
    endif;
  
    exec (VESTA_CMD."v-list-web-domains $user json", $output, $return_var);
    $domain = json_decode(implode('', $output), true);
    $domain = array_reverse($domain, true);
    unset($output);

    include($_SERVER['DOCUMENT_ROOT'].'/app-installer/header.php');

     echo "<div class=\"container\">\n
      <div class=\"row\">";
        $i='0';
        $app_data='';
          foreach ($APPS as $key => $APP) {
            $i=$i+1;
            $app_data .= '
            <div class="col-sm-12 col-md-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">'.$APP["name"].'</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-6 col-md-4 text-center"> 
                      '.(($APP['img_link'] == '') ? '<i class="fa fa-'.$APP["fa"].' fa-5x"></i>' :  '<img alt="'.$APP["name"].' Logo" src="https://'.$_SERVER["HTTP_HOST"].'/app-installer/img/'.$APP["img_link"].'" class="img-responsive">').'
                    </div>
                    <div class="col-sm-6 col-md-8"> 
                          <table class="table">
                            <tbody>
                              <tr>
                                <td>Website:</td>
                                <td><a href="http://'.$APP["link"].'" target="_BLANK">'.$APP["link"].'</a></td>
                              </tr>
                              <tr>
                                <td>Category:</td>
                                <td>'.$APP["cat"].'</td>
                              </tr> 
                              <tr>
                              
                                <td colspan="2">'.$APP["desc"].'</td>
                              </tr>
                              <tr>
                                <td>Version:</td>
                                <td>'.$APP["version"].'</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                  </div>
                </div>
                <div class="panel-footer text-right">
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#installModal" data-id="'.$key.'" data-pckv="'.$APP["version"].'" data-backdrop="static"> Install App <i class="fa fa-angle-double-right"></i></button>
                </div>
              </div>
            </div>';
              $app_data .= (($i%2 == 0) ? "\n      </div>\n      <div class=\"row\">" : "");
          }
        echo $app_data;

     echo"</div>\n
          </div>";

    include($_SERVER['DOCUMENT_ROOT'].'/app-installer/footer.php');

  unset($_SESSION['error_msg']);
  unset($_SESSION['ok_msg']);

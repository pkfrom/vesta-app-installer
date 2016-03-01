<?php
//Direct access not permitted show 404
if(count(get_included_files()) ==1){ header("HTTP/1.0 404 Not Found"); die(); }
?>

  <p class="small text-center"> All trademarks, service marks and trade names referenced in this material are the property of their respective owners. </p>


  <div class="modal fade" id="installModal" tabindex="-1" role="dialog" aria-labelledby="installModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="installModalLabel">Install</h4>
          </div>
          <div class="modal-body">
            <form role="form" name="CDNMALL" action="<?=(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="POST">
              <div class="row <?=(empty($domain) ? 'hidden' : '');?>">
                <div class="col-sm-12 col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label class="control-label">Administrator Username</label>   
                    <input class="form-control" type="text" name="cdn_admin_user" value="<?=(isset($_POST['cdn_admin_user']) ? $_POST['cdn_admin_user'] : '');?>">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-md-offset-2">
                  <div class="form-group">
                    <label class="control-label">Administrator Email Address</label>   
                    <input class="form-control" type="text" name="cdn_admin_email" value="<?=(isset($_POST['cdn_admin_email']) ? $_POST['cdn_admin_email'] : '');?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-4 col-md-offset-1">
                  <div class="form-group">
                    <label class="control-label">Domain Name</label>         
                    <?php
                     if(empty($domain)){ 
                      echo '<a href="https://'.$_SERVER["HTTP_HOST"].'/add/web/" class="form-control btn btn-primary">Add a Domain Name</a>'; 
                     }else{
                      echo '<select class="form-control" id="cdn_domain" name="cdn_domain">';
                      echo '<option value="" selected>Choose a Domain Name</option>';
                        foreach ($domain as $key => $value) {
                          echo '<option value="'.$key.'" '.(isset($_POST['cdn_domain']) && ($_POST['cdn_domain'] ===$key) ? 'selected' : '').'>'.$key.'</option>';
                        }
                      echo '</select>';
                     }
                    ?> 
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-md-offset-2 <?=(empty($domain) ? 'hidden' : '');?>">
                  <div class="form-group">
                    <label class="control-label">Install Directory Path</label>
                    <select class="form-control" id="cdn_public" name="cdn_public">
                      <option value="public_html" selected>public_html</option>
                      <option value="public_shtml">public_shtml</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row <?=(empty($domain) ? 'hidden' : '');?>">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                  <div class="form-group">
                    <label class="control-label">Install Directory</label> 
                    <p class="helper-block visible-xs" id="path"><?=$panel[$user]['HOME']?>/web/</p>
                      <div class="input-group">
                        <span class="input-group-addon hidden-xs" id="path1"><?=$panel[$user]['HOME']?>/web/</span>
                        <input class="form-control" type="text" name="cdn_instdir" value="<?=(isset($_POST['cdn_instdir']) ? $_POST['cdn_instdir'] : '/');?>">
                      </div>
                    <p class="helper-block">Install Directory must already be empty.</p>
                  </div>
                </div>
              </div>
              <input type="hidden" name="cdn_package" value="<?=(isset($_POST['cdn_package']) ? $_POST['cdn_package'] : '');?>">
              <input type="hidden" name="cdn_packagev" value="<?=(isset($_POST['cdn_packagev']) ? $_POST['cdn_packagev'] : '');?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" name="ok" value="<?=$_SESSION['token']?>" class="btn btn-primary" id="INSTALLNOW" <?=(empty($domain) ? 'disabled' : '');?>>Install Now</button>
            <div class="row">
              <div class="col-sm-12 col-md-12 footer">
                <p><strong>Disclaimer</strong><br>The use of this third-party software provided by CDN MALL is for use at your own discretion and risk and with agreement that you will be solely responsible for any damage to your server or loss of data that results from such activities. You are solely responsible for adequate protection and backup of the data and equipment used in connection with it, and we will not be liable for any damages that you may suffer in connection with downloading, installing, using, or modifying such software. </p>
              </div>
            </div>
          </div>
        </div>
       </form>
      </div>
      
      
    </div>
    <footer>
      <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
          <div class="navbar-header">
            <a href="#" class="navbar-brand">Verison 1.0.2</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-footer">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-footer">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="http://cdnmall.com" target="_BLANK">By CDN Mall</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>  
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    <script type="text/javascript">
      $(document).ready(function () {    
        $('#cdn_public, #cdn_domain').on('change', function() {
          var HOMEDIR = '/home/web/';
          var DOMAIN = $('#cdn_domain option:selected').text();
          var PUBLICDIR = $('#cdn_public option:selected').text();
          var REALPATH = HOMEDIR+DOMAIN+"/"+PUBLICDIR;
          $("#path").html(REALPATH);
          $("#path1").html(REALPATH);
        });
        
        $('#installModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var pck = button.data('id');
          var pckv = button.data('pckv');
          var HOMEDIR = '/home/web/';
          var DOMAIN = $('#cdn_domain option:selected').text();
          var PUBLICDIR = $('#cdn_public option:selected').text();
          var REALPATH = HOMEDIR+DOMAIN+"/"+PUBLICDIR;
          
          var modal = $(this);
          modal.find('.modal-title').text('Install ' + pck + ' ' + pckv);
          modal.find('input[name=cdn_package]').val(pck).end();
          modal.find('input[name=cdn_packagev]').val(pckv).end();
          modal.find("#path").html(REALPATH);
          modal.find("#path1").html(REALPATH);
        });
        

      });
    </script>
  </body>
</html>
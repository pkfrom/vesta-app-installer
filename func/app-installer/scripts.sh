# Automatic APP INSTALLER FOR VESTA CP
# THIS SOFTWARE IS PROVIDED FOR FREE BY JOE MATTOS OWNER OF CDNMALL.COM.

function INSTALL_WordPress_4.3() {

 APPI_QST="wp-admin/"

 BASE_INSTALL_START "y" "wp-config.php" "n"
 
 NEW_DB
  
    sed -i "s/##CHARSET##/$APPI_DB_CHAR/;s%##TPREF##%$APPI_DB_TPREF%;s%##SITEURL##%http\:\/\/$APPI_USER_DOMAIN$APPI_USER_INSTALL%;s/##ADMIN_PASS##/$APPI_SD_PASS/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s/##ADMIN_USER##/$APPI_SD_USER/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/database_name_here/$APPI_DB_NAME/;s/username_here/$APPI_DB_USER/;s/password_here/$APPI_DB_PASS/;s/localhost/$APPI_DB_HOST/;s/utf8/$APPI_DB_CHAR/;s/wp_/$APPI_DB_TPREF/g" $APPI_USER_INSTALLDIR"wp-config.php"
    
    printf '%s\n' "g/##PLACE_WP_SALT##/d" a "$(curl -sL https://api.wordpress.org/secret-key/1.1/salt/)" . w | ed -s $APPI_USER_INSTALLDIR"wp-config.php"
    
    chmod 600 $APPI_USER_INSTALLDIR"wp-config.php"

 IPORT_DB 

}

function INSTALL_OpenCart_2.0.3.1() {

 APPI_QST="admin/"

 BASE_INSTALL_START "n" "n" "n"
 
 NEW_DB
  
  chown -R $user:$user $HOMEDIR/$user/web/$APPI_USER_DOMAIN/$APPI_USER_HTTP
  chmod -R 755 $APPI_USER_INSTALLDIR"install/cli_install.php"
      
    INSTALLNOW=$(php $APPI_USER_INSTALLDIR"install/cli_install.php" install --db_hostname $APPI_DB_HOST --db_username $APPI_DB_USER --db_password $APPI_DB_PASS --db_database $APPI_DB_NAME --username $APPI_SD_USER --password $APPI_SD_PASS --email $APPI_SD_EMAIL --http_server http://$APPI_USER_DOMAIN$APPI_USER_INSTALL/)
    
      if [ $? != 0 ]; then
        echo "Installation Issue: Problems with the CLI Installer."
        BASE_BD_INSTALL $E_INVALID
      fi
          
      if [ -d $APPI_USER_INSTALLDIR"install" ]; then 
        rm -rf $APPI_USER_INSTALLDIR"install"
      fi
}

function INSTALL_Textpattern_4.5.7() {

  APPI_QST="textpattern/"
 
  BASE_INSTALL_START "y" "textpattern/config.php" "textpattern/config-dist.php"
 
  NEW_DB
    
    sed -i "s/##CHARSET##/$APPI_DB_CHAR/;s/##TPREF##/$APPI_DB_TPREF/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s/##ADMIN_USER##/$APPI_SD_USER/;s%##REALURL##%$APPI_USER_DOMAIN$APPI_USER_INSTALL%;s/##ADMIN_PASS##/$APPI_SD_PASS/;s%##INSTALL_FOLLDER##%$APPI_INSTALLDIR%;s%##INSTALL_TMP_FOLLDER##%$APPI_INSTALLDIR\/textpattern\/tmp%;s%##INSTALL_FILES_FOLLDER##%$APPI_INSTALLDIR\/files%;s%##SITEURL##%http\:\/\/${APPI_USER_DOMAIN}${APPI_USER_INSTALL}%g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##DB_HOST_HERE##/$APPI_DB_HOST/;s/##DB_NAME_HERE##/$APPI_DB_NAME/;s/##DB_USER_HERE##/$APPI_DB_USER/;s/##DB_PASS_HERE##/$APPI_DB_PASS/;s/##TPREF_HERE##/$APPI_DB_TPREF/;s/latin1/$APPI_DB_CHAR/;s%##D_HERE##%$APPI_INSTALLDIR%g" $APPI_USER_INSTALLDIR"textpattern/config.php"

    chmod -R 777 $APPI_USER_INSTALLDIR"files"   
    chmod -R 777 $APPI_USER_INSTALLDIR"images"   
    chmod -R 777 $APPI_USER_INSTALLDIR"textpattern/tmp" 

  IPORT_DB
}


function INSTALL_phpBB_3.1.5() {

  BASE_INSTALL_START "y" "config.php" "n"
 
  NEW_DB
    
    sed -i "s/##DB_HOST_HERE##/$APPI_DB_HOST/;s/##DB_NAME_HERE##/$APPI_DB_NAME/;s/##DB_USER_HERE##/$APPI_DB_USER/;s/##DB_PASS_HERE##/$APPI_DB_PASS/;s/##TPREF_HERE##/$APPI_DB_TPREF/g" $APPI_USER_INSTALLDIR"config.php"

    sed -i "s%##SITEURL##%$APPI_USER_DOMAIN$APPI_USER_INSTALL%g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##ADMIN_USER##/$APPI_SD_USER/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s%##ADMIN_PASS##%$APPI_SD_PASS%g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##TPREF_HERE##/$APPI_DB_TPREF/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##CHARSET##/$APPI_DB_CHAR/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##RANDOM_HERE##/$(cat /dev/urandom| tr -dc '0-9a-z'|head -c 5)/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s%##REALURL##%$APPI_USER_DOMAIN%g" $APPI_USER_INSTALLDIR"app_data.sql"

    chmod -R 777 $APPI_USER_INSTALLDIR"files"   
    chmod -R 777 $APPI_USER_INSTALLDIR"cache"   
    chmod -R 777 $APPI_USER_INSTALLDIR"store" 
    chmod -R 777 $APPI_USER_INSTALLDIR"images/avatars/upload" 
    chmod 644 $APPI_USER_INSTALLDIR"config.php"

  IPORT_DB
}

function INSTALL_PrestaShop_1.6.1.1() {

  APPI_QST="admin"
  
  BASE_INSTALL_START "n" "n" "n"
 
  NEW_DB
  
      if [ -f $APPI_USER_INSTALLDIR"install/index_cli.php" ]; then 

       INSTALLNOW=$(php $APPI_USER_INSTALLDIR"install/index_cli.php" install --domain=$APPI_USER_DOMAIN --db_server=$APPI_DB_HOST --db_name=$APPI_DB_NAME --db_user=$APPI_DB_USER --db_password=$APPI_DB_PASS --base_uri=$APPI_USER_INSTALL --email=$APPI_SD_EMAIL --password=$APPI_SD_PASS --send_email=0)

        if [ $? != 0 ]; then
          echo "Installation Issue: Problems with the CLI Installer."
          BASE_BD_INSTALL $E_INVALID
        fi
          
        if [ -d $APPI_USER_INSTALLDIR"install" ]; then 
          rm -rf $APPI_USER_INSTALLDIR"install"
        fi
        
      else
        echo "Installation Issue: Unable able to locate CLI Installer."
        BASE_BD_INSTALL $E_INVALID
      fi
}

function INSTALL_Joomla_3.4.1() {

  APPI_QST="administrator/"

  BASE_INSTALL_START "y" "configuration.php" "n"
 
  NEW_DB
    
    sed -i "s/##CHARSET##/$APPI_DB_CHAR/;s/##TPREF##/$APPI_DB_TPREF/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s/##ADMIN_USER##/$APPI_SD_USER/;s/##ADMIN_PASS##/$APPI_SD_PASS/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##DB_HOST_HERE##/$APPI_DB_HOST/;s/##DB_NAME_HERE##/$APPI_DB_NAME/;s/##DB_USER_HERE##/$APPI_DB_USER/;s/##DB_PASS_HERE##/$APPI_DB_PASS/;s/##TPREF_HERE##/$APPI_DB_TPREF/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s%##INSTALL_FOLLDER##%$APPI_INSTALLDIR%;s/##RANDOM_HERE##/$(cat /dev/urandom| tr -dc 'A-Z0-9a-z'|head -c 16)/g" $APPI_USER_INSTALLDIR"configuration.php"

  IPORT_DB
}

function INSTALL_SMF_2.0.10() {

  BASE_INSTALL_START "y" "Settings.php" "n"
 
  NEW_DB
    
    sed -i "s/##CHARSET##/$APPI_DB_CHAR/;s/##TPREF##/$APPI_DB_TPREF/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s/##ADMIN_PASS##/$APPI_SD_PASS/;s%##INSTALL_FOLLDER##%$APPI_INSTALLDIR%;s%##INSTALL_URL##%http\:\/\/${APPI_USER_DOMAIN}${APPI_USER_INSTALL}%;s/##ADMIN_USER##/$APPI_SD_USER/g" $APPI_USER_INSTALLDIR"app_data.sql"
    sed -i "s/##DB_HOST_HERE##/$APPI_DB_HOST/;s/##TPREF##/$APPI_DB_TPREF/;s/##DB_NAME_HERE##/$APPI_DB_NAME/;s/##DB_USER_HERE##/$APPI_DB_USER/;s/##DB_PASS_HERE##/$APPI_DB_PASS/;s/##TPREF_HERE##/$APPI_DB_TPREF/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s%##INSTALL_FOLLDER##%$APPI_INSTALLDIR%;s%##INSTALL_URL##%http\:\/\/${APPI_USER_DOMAIN}${APPI_USER_INSTALL}%g" $APPI_USER_INSTALLDIR"Settings.php"

  IPORT_DB
}
function INSTALL_Nibble_4.0.5() {

 APPI_QST="admin.php"

 BASE_INSTALL_START "n" "install.php" "n"

  chown -R $user:$user $HOMEDIR/$user/web/$APPI_USER_DOMAIN/$APPI_USER_HTTP
  chmod -R 755 $APPI_USER_INSTALLDIR"install.php"  
  cd $APPI_USER_INSTALLDIR
  
  sed -i "s/##DOMAIN##/$APPI_USER_DOMAIN/;s%##INSTALL_FOLLDER##%$APPI_USER_INSTALL\/%;s%##INSTALL_DIR##%$APPI_USER_INSTALL%;s/##ADMIN_USER##/$APPI_SD_USER/;s/##ADMIN_PASS##/$APPI_SD_PASS/;s/##ADMIN_EMAIL##/$APPI_SD_EMAIL/;s%##SITEURL##%http\:\/\/${APPI_USER_DOMAIN}${APPI_USER_INSTALL}\/%g" $APPI_USER_INSTALLDIR"install.php"

  INSTALLNOW=$(php "${APPI_USER_INSTALLDIR}install.php")

      if [ $? != 0 ]; then
        echo "Installation Issue: Problems with the CLI Installer."
        BASE_BD_INSTALL $E_INVALID
      fi
          
      if [ -f $APPI_USER_INSTALLDIR"install.php" ]; then 
        rm -rf $APPI_USER_INSTALLDIR"install.php"
      fi
}


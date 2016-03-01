# Automatic APP INSTALLER FOR VESTA CP
# THIS SOFTWARE IS PROVIDED FOR FREE BY JOE MATTOS OWNER OF CDNMALL.COM.

function BASE_CHECK () {
  if [ ! -d "$APPI_USER_INSTALLDIR" ]; then 
    mkdir -p $APPI_USER_INSTALLDIR
  fi

  if [ "$(ls -A $APPI_USER_INSTALLDIR)" ]; then  
    echo "INSTALL DIRECTORY $APPI_INSTALLDIR MUST BE EMPTY"
    exit $E_EXISTS
  fi 
  
  if [ ! -f "$APPI/$APPI_USER_PACKAGE-$APPI_USER_PACKAGEV.zip" ]; then
    echo "Installation Issue: Unable to locate APP PACKAGE."
    BASE_BD_INSTALL $E_INVALID
  fi
}

function BASE_CLEAN_UP() {
  chown -R $user:$user $HOMEDIR/$user/web/$APPI_USER_DOMAIN/$APPI_USER_HTTP
  
  if [ -f $APPI_USER_INSTALLDIR"/app_data.sql" ]; then 
    rm -rf $APPI_USER_INSTALLDIR/app_data.sql
  fi
  
  BASE_SEND_MAIL
}

function BASE_SEND_MAIL() {

    echo -e "Congratulations, you have just successfully installed $APPI_USER_PACKAGE $APPI_USER_PACKAGEV,

    http://${APPI_USER_DOMAIN}${APPI_USER_INSTALL}
    
    Your Login Credentials:
 
    Username: $APPI_SD_USER
    Password: $APPI_SD_PASS
    
    http://${APPI_USER_DOMAIN}${APPI_USER_INSTALL}/${APPI_QST}
    ________________________________________
    
    Installation Directory: $APPI_USER_INSTALLDIR
    DB HOST: $APPI_DB_HOST / DB NAME: $APPI_DB_NAME / DB USER: $APPI_DB_USER / DB PASS: $APPI_DB_PASS / DB PRE: $APPI_DB_TPREF" | $VESTA/web/inc/mail-wrapper.php -s " $APPI_USER_PACKAGE $APPI_USER_PACKAGEV Installation Details " $APPI_SD_EMAIL
}

function BASE_INSTALL_START() {

  unzip -qnd $APPI_USER_INSTALLDIR $APPI/$APPI_USER_PACKAGE-$APPI_USER_PACKAGEV.zip
  
  #APP SQL
  if [[ $1 == "y" && ! -f $APPI_USER_INSTALLDIR"app_data.sql" ]]; then
      echo "Installation Issue: Unable to locate app data file."
      BASE_BD_INSTALL $E_INVALID
  fi
 
  if [[ $3 != "n" && $2 != "n" ]]; then

    #APP CONFIG
    if [[ $3 == "n" && ! -f "$APPI_USER_INSTALLDIR$2" ]]; then
     echo "Installation Issue: Unable to locate app Config file."
     BASE_BD_INSTALL $E_INVALID 
    fi
      
    if [[ $3 != "n" && ! -f "$APPI_USER_INSTALLDIR$3" ]]; then
     echo "Installation Issue: Unable to locate app Config file."
     BASE_BD_INSTALL $E_INVALID 
    fi
    
    if [[ ! -f "$APPI_USER_INSTALLDIR$2" && $3 != "n" ]]; then 
      mv $APPI_USER_INSTALLDIR$3 $APPI_USER_INSTALLDIR$2
    fi 
    
    if [[ $2 != "n" && ! -f "$APPI_USER_INSTALLDIR$2" ]]; then 
      echo "Installation Issue: Unable to locate app Config file $2."
      BASE_BD_INSTALL $E_INVALID
    fi
  
  fi
  
}

function BASE_BD_INSTALL() {
  if [[ -n "$APPI_USER_INSTALLDIR" && -d "$APPI_USER_INSTALLDIR" ]]; then 
    rm -rf $APPI_USER_INSTALLDIR
  fi
  
  if [[ -n "$APPI_DB_NAME" && -d "/var/lib/mysql/"$APPI_DB_NAME ]]; then
    $BIN/v-delete-database $user $APPI_DB_NAME
  fi

  exit $1
}

function NEW_DB() {
  APPI_DB_HOST="localhost"
  APPI_DB_NAME=$(cat /dev/urandom | tr -dc 'a-z'| head -c 5)
  APPI_DB_USER=$(cat /dev/urandom | tr -dc 'a-z'| head -c 5)
  APPI_DB_PASS=$(cat /dev/urandom | tr -dc 'a-z'| head -c 10)
  APPI_DB_TPREF=$(cat /dev/urandom | tr -dc 'a-z'| head -c 5)"_"
  APPI_DB_CHAR="utf8"

  $BIN/v-add-database $user $APPI_DB_NAME $APPI_DB_USER $APPI_DB_PASS
  
  if [ $? -ne 0 ]; then
    BASE_BD_INSTALL $E_DB
  fi
  
  APPI_DB_NAME=$user"_"$APPI_DB_NAME
  APPI_DB_USER=$user"_"$APPI_DB_USER
}

function IPORT_DB() {
  mysql -h $APPI_DB_HOST -u$APPI_DB_USER -p$APPI_DB_PASS -D$APPI_DB_NAME < $APPI_USER_INSTALLDIR"app_data.sql"

  if [ $? -ne 0 ]; then
    echo "Installation Issue: $APPI_USER_PACKAGE has mysql import problems."
    BASE_BD_INSTALL $E_DB
  fi
}
#!/bin/bash

platform='unknown'

NORMAL="\\033[0;39m"
VERT="\\033[1;32m"
ROUGE="\\033[1;31m"
BLUE="\\033[1;34m"
ORANGE="\\033[1;33m"
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"

## Linux bin paths, change this if it can not be autodetected via which command
BIN="/usr/bin"
CP="$($BIN/which cp)"
SSH="$($BIN/which ssh)"
CD="$($BIN/which cd)"
GIT="$($BIN/which git)"
ECHO="$($BIN/which echo)"
LN="$($BIN/which ln)"
MV="$($BIN/which mv)"
RM="$($BIN/which rm)"
NGINX="/etc/init.d/nginx"
MKDIR="$($BIN/which mkdir)"
MYSQL="$($BIN/which mysql)"
MYSQLDUMP="$($BIN/which mysqldump)"
CHOWN="$($BIN/which chown)"
CHMOD="$($BIN/which chmod)"
GZIP="$($BIN/which gzip)"
ZIP="$($BIN/which zip)"
FIND="$($BIN/which find)"
TOUCH="$($BIN/which touch)"
PHP="$($BIN/which php)"
# PHP="/usr/local/php80/bin/php"
PERL="$($BIN/which perl)"
CURL="$($BIN/which curl)"
HASCURL=1
DEVMODE="--no-dev"
PHPCOPTS=" -d memory_limit=-1 "
SED="$($BIN/which sed)"

### directory and file modes for cron and mirror files
FDMODE=0777
CDMODE=0700
CFMODE=600
MDMODE=0755
MFMODE=644

os=${OSTYPE//[0-9.-]*/}
if [[ "$os" == 'darwin' ]]; then
  platform='macosx'
elif [[ "$os" == 'msys' ]]; then
  platform='window'
elif [[ "$os" == 'linux' ]]; then
  platform='linux'
fi
echo -e "$ROUGE You are using $platform $NORMAL"

###
## SOURCE="${BASH_SOURCE[0]}"
## while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
##   DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
##   SOURCE="$(readlink "$SOURCE")"
##   [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
## done
## DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
## cd $DIR
## SCRIPT_PATH=`pwd -P` # return wrong path if you are calling this script with wrong location
## SCRIPT_PATH=`pwd -P`
SCRIPT_PATH="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # return /path/bin
echo -e "$VERT--> Your path: $SCRIPT_PATH $NORMAL"

read_var(){
    VAL=$(grep -v '^#' .env | grep -e "$1" | sed -e 's/.*=//' -e 's/^"//' -e 's/"$//')
    # VAL="${VAL%\"}" // will remove the suffix " or just use -e 's/^"//' -e 's/"$//'
    # VAL="${VAL#\"}" // will remove the prefix " or just use -e 's/^"//' -e 's/"$//'
    echo $VAL
}

command -v php >/dev/null || {
  $ECHO "php command not found."
  exit 1
}

## command -v $CURL >/dev/null || HASCURL=0
command -v $CURL >/dev/null || {
  $ECHO "$CURL command not found."
  exit 1
}

die() {
  printf '%s\n' "$1" >&2
  exit 1
}

nonce=$(md5sum <<< $(ip route get 8.8.8.8 | awk '{print $NF; exit}')$(hostname) | cut -c1-5 )
LOCKFILE=/tmp/zipping_$nonce
EMAILFILE=/tmp/zipping_$nonce.email
if [ -f "$LOCKFILE" ]; then
  # Remove lock file if script fails last time and did not run longer than 2 days due to lock file.
  $FIND "$LOCKFILE" -mtime +2 -type f -delete
  $ECHO "$(date) - Warning - process is running"
  exit 1
fi

##
$ECHO -e "$ORANGE--> Please enter your $ROUGE domain name, such as: abc.com $NORMAL"
read domain
while :
do
    if [[ -z $domain ]]
    then
        $ECHO -e "$ORANGE--> Please enter your $ROUGE domain name, such as: abc.com $NORMAL"
        read domain
    else
        [[ -e $domain ]]
        DOMAIN_NAME="${domain}";break   # break the for looop
    fi
done

##
DB_HOST=$(read_var "DB_HOST")
if [ -z "$DB_HOST" ]; then
    $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Host (localhost) $NORMAL"
    read dbhost
    while :
    do
        if [[ -z $dbhost ]]
        then
            $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Host $NORMAL"
            read dbhost
        else
            [[ -e $dbhost ]]
            DB_HOST="${dbhost}";break   # break the for looop
        fi
    done
fi
$ECHO -e "$ORANGE--> Your DB Host is $ROUGE $DB_HOST $NORMAL"

##
DB_DATABASE=$(read_var "DB_DATABASE")
if [ -z "$DB_DATABASE" ]; then
    $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Name $NORMAL"
    read dbname
    while :
    do
        if [[ -z $dbname ]]
        then
            $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Name $NORMAL"
            read dbname
        else
            [[ -e $dbname ]]
            DB_DATABASE="${dbname}";break   # break the for looop
        fi
    done
fi
$ECHO -e "$ORANGE--> Your DB Name is $ROUGE $DB_DATABASE $NORMAL"

##
DB_USERNAME=$(read_var "DB_USERNAME")
if [ -z "$DB_USERNAME" ]; then
    $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Username $NORMAL"
    read dbusername
    while :
    do
        if [[ -z $dbusername ]]
        then
            $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Username $NORMAL"
            read dbusername
        else
            [[ -e $db ]]
            DB_USERNAME="${dbusername}";break   # break the for looop
        fi
    done
fi
$ECHO -e "$ORANGE--> Your DB Username is $ROUGE $DB_USERNAME $NORMAL"

##
DB_PASSWORD=$(read_var "DB_PASSWORD")
if [ -z "$DB_PASSWORD" ]; then
    $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Password $NORMAL"
    read dbpassword
    while :
    do
        if [[ -z $dbpassword ]]
        then
            $ECHO -e "$ORANGE--> Please enter your $ROUGE DB Password $NORMAL"
            read dbpassword
        else
            [[ -e $db ]]
            DB_PASSWORD="${dbpassword}";break   # break the for looop
        fi
    done
fi
$ECHO -e "$ORANGE--> Your DB Password is $ROUGE $DB_PASSWORD $NORMAL"

## WEBDAVPASS: oW9gE-fLqX9-7kF2b-HNFm2-YajN6
TIMESTAMP=$(date +"%d%m%Y-%H%M%S")
WEBDAV_DRIVE_URL="https://drive.fsofts.com"
WEBDAV_BASEURL="https://drive.fsofts.com/remote.php/webdav"
WEBDAVLOGIN="delivery@fsofts.com"
WEBDAVPASS="SCxjE-QQAMt-5tTYE-NPZMx-Qe5zW"
BACKUP_PATH_YEAR="Deployments"
BACKUP_PATH_PROJECT="$TIMESTAMP.$DOMAIN_NAME"
WEBDAV="$WEBDAV_BASEURL/$BACKUP_PATH_YEAR/$BACKUP_PATH_PROJECT/"

if [ $HASCURL == 1 ]; then
  $CURL -k -u "$WEBDAVLOGIN:$WEBDAVPASS" -X MKCOL $WEBDAV
  $ECHO -e "$VERT--> Your WebDav: $WEBDAV $NORMAL"
fi

BACKUP_SOURCENAME="$DOMAIN_NAME.source-$TIMESTAMP.zip"
BACKUP_SQLNAME="$DOMAIN_NAME.dbs-$TIMESTAMP.sql"

if [ -f "$SCRIPT_PATH/../$BACKUP_SOURCENAME" ]; then
  ($CD $SCRIPT_PATH/../ && $RM -f $BACKUP_SOURCENAME \;)
fi
if [ -f "$SCRIPT_PATH/../$BACKUP_SQLNAME" ]; then
  ($CD $SCRIPT_PATH/../ && $RM -f $BACKUP_SQLNAME \;)
fi

## for laravel
if [ -f "$SCRIPT_PATH/../artisan" ] && [ -d "$SCRIPT_PATH/../vendor" ]; then
  ($CD $SCRIPT_PATH/../ && $PHP $PHPCOPTS artisan config:clear && $PHP $PHPCOPTS artisan cache:clear)
  ($CD $SCRIPT_PATH/../ && $CP .env .env.example)
fi

## allow bots engine
if [ -f "$SCRIPT_PATH/../robots.txt" ]; then
    ($CD $SCRIPT_PATH/../ && $SED -i "s/Disallow\: \//Allow\: \//g" "$SCRIPT_PATH/../robots.txt")
fi
if [ -f "$SCRIPT_PATH/../public/robots.txt" ]; then
    ($CD $SCRIPT_PATH/../ && $SED -i "s/Disallow\: \//Allow\: \//g" "$SCRIPT_PATH/../public/robots.txt")
fi

################ without symlink
$ECHO -e "$VERT--> Your BACKUP_SOURCENAME: $BACKUP_SOURCENAME $NORMAL"
($CD $SCRIPT_PATH/../ && $ZIP -r4uy $BACKUP_SOURCENAME . -x \*bootstrap/cache/*.php \*storage/backup/\* \*storage/framework/\* \*storage/debugbar/\* \*storage/app/purifier/\* \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*node_modules/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.gitlab-ci.yml \*.sql \*.psd \*.swp \*.phar \*.md \*.MD \*.log \*.zip \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat bin/delivery.sh bin/optimize-image.sh bin/directory.sh bin/remove-bb* bin/search-replace.sh bin/doctrine-* readme.html composer.lock wp-config.secure.php \*.travis.yml\* \*.rnd\* \*.editorconfig\* \*.env \*editorconfig\* \*.gitlab-ci.yml\* __MACOSX/\*)

$ECHO -e "$VERT--> Your BACKUP_SQLNAME: $BACKUP_SQLNAME $MYSQLDUMP -h$DB_HOST -u$DB_USERNAME -p$DB_PASSWORD --default-character-set utf8 $DB_DATABASE > $BACKUP_SQLNAME$NORMAL"
($CD $SCRIPT_PATH/../ && $MYSQLDUMP -h$DB_HOST -u$DB_USERNAME -p$DB_PASSWORD --default-character-set utf8 $DB_DATABASE > $BACKUP_SQLNAME)

## ($CD $SCRIPT_PATH/../ && $CHOWN -R {HOME_USER}:{HOME_USER} .)

$ECHO "Backup Source size: $(du -h $BACKUP_SOURCENAME | awk '{printf "%s",$1}')"
$ECHO "Backup SQL size: $(du -h $BACKUP_SQLNAME | awk '{printf "%s",$1}')"

##################### Begin compress media files
## $FIND . -type f -iname "*.png" -print0 | xargs -I {} -0 optipng -o5 -quiet -keep -preserve "{}"
## $FIND . -type f -iname "*.png" -print0 | xargs -I {} -0 optipng -o5 -preserve "{}"
## command -v optipng >/dev/null || {
##   $ECHO "optipng command not found."
##   ## exit 1
## }

## Compress Quality to 50% for all Images in a Folder That are larger than 500kb
## $FIND . -size +300k -type f -name "*.jpg" | xargs jpegoptim --max=50 -f --strip-all
## jpegoptim --size=250k tecmint.jpeg
## command -v jpegoptim >/dev/null || {
##   $ECHO "jpegoptim command not found."
##   ## exit 1
## }
##################### End compress media files

##################### Begin upload to nextcloud webdav
if [ $HASCURL == 1 ]; then
  UPLOAD_SOURCE_CMD="$CURL --progress-bar --verbose -k -u "$WEBDAVLOGIN:$WEBDAVPASS" -X PUT -T $BACKUP_SOURCENAME $WEBDAV"
  UPLOAD_SQL_CMD="$CURL --progress-bar --verbose -k -u  "$WEBDAVLOGIN:$WEBDAVPASS" -X PUT -T $BACKUP_SQLNAME $WEBDAV"
  NEXT_WAIT_TIME=60

  if [ -f "$SCRIPT_PATH/../$BACKUP_SOURCENAME" ]; then
    until $UPLOAD_SOURCE_CMD || [ $NEXT_WAIT_TIME -eq 14 ]; do
      sleep $(( NEXT_WAIT_TIME++ ))
      $ECHO "$(date) - ERROR - Webdav Upload was failed, will retry after 60 seconds ($UPLOAD_SOURCE_CMD)."
    done
  fi
  if [ -f "$SCRIPT_PATH/../$BACKUP_SQLNAME" ]; then
  until $UPLOAD_SQL_CMD || [ $NEXT_WAIT_TIME -eq 14 ]; do
    sleep $(( NEXT_WAIT_TIME++ ))
    $ECHO "$(date) - ERROR - Webdav Upload was failed, will retry after 60 seconds ($UPLOAD_SQL_CMD)."
  done
  fi
  ## $ECHO -e "$VERT--> http://{DOMAIN_NAME}/$BACKUP_SOURCENAME $NORMAL"
  ## $ECHO -e "$VERT--> http://{DOMAIN_NAME}/$BACKUP_SQLNAME $NORMAL"

  $ECHO -e "$ROUGE--> PLEASE LOGIN TO  $WEBDAV_DRIVE_URL THEN SHARE TO CLIENT THE LINK, MAKE SURE THAT THEY CAN ACCESS $NORMAL"
  $ECHO -e "$VERT--> The Link is: $WEBDAV_DRIVE_URL/index.php/apps/files/?dir=/$BACKUP_PATH_YEAR/$BACKUP_PATH_PROJECT $NORMAL"
  $ECHO -e "$ORANGE--> Done!$NORMAL"
else
  $ECHO "$(date) - ERROR - Config file could not be read."
fi
## End

$ECHO "Checking $SCRIPT_PATH/../$BACKUP_SOURCENAME"
$ECHO -e "$VERT--> Your path: $SCRIPT_PATH $NORMAL"
if [ -f "$SCRIPT_PATH/../$BACKUP_SOURCENAME" ]; then
    ($CD $SCRIPT_PATH/../ && $RM -f $SCRIPT_PATH/../$BACKUP_SOURCENAME \;)
    $ECHO "Removed $SCRIPT_PATH/../$BACKUP_SOURCENAME"
fi

$ECHO "Checking $SCRIPT_PATH/../$BACKUP_SQLNAME"
if [ -f "$SCRIPT_PATH/../$BACKUP_SQLNAME" ]; then
    ($CD $SCRIPT_PATH/../ && $RM -f $SCRIPT_PATH/../$BACKUP_SQLNAME \;)
    $ECHO "Removed $SCRIPT_PATH/../$BACKUP_SQLNAME"
fi

exit 0

################################################################
## Shell script : remove author information with shell,
## This script will be remove author information, namespace (use Platform). No change other application's structure anymore!
##
## Author: Weber Team!
## Copy Right: @2011 Weber Team!
################################################################

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

# Linux bin paths, change this if it can not be autodetected via which command
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
PERL="$($BIN/which perl)"
CURL="$($BIN/which curl)"
HASCURL=1
DEVMODE="--dev"
PHPCOPTS=" -d memory_limit=-1 "

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
SCRIPT_PATH="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # return /path/bin
echo -e "$VERT--> Your path: $SCRIPT_PATH $NORMAL"

# Usage info
show_help() {
  cat <<EOF
Usage: ${0##*/} [-hv] [-e APPLICATION_ENV] [development]...
    -h or --help         display this help and exit
    -e or --env APPLICATION_ENV
    -v or --verbose      verbose mode. Can be used multiple times for increased
                verbosity.
EOF
}
die() {
  printf '%s\n' "$1" >&2
  exit 1
}

# Initialize all the option variables.
# This ensures we are not contaminated by variables from the environment.
verbose=0
while :; do
  case $1 in
  -e | --env)
    if [ -z "$2" ]; then
      show_help
      die 'ERROR: please specify "--e" enviroment.'
    fi
    APPLICATION_ENV="$2"
    if [[ "$2" == 'd' ]]; then
      APPLICATION_ENV="development"
    fi
    if [[ "$2" == 'p' ]]; then
      APPLICATION_ENV="production"
    fi
    shift
    break
    ;;
  -h | -\? | --help)
    show_help # Display a usage synopsis.
    exit
    ;;
  -v | --verbose)
    verbose=$((verbose + 1)) # Each -v adds 1 to verbosity.
    ;;
  --) # End of all options.
    shift
    break
    ;;
  -?*)
    printf 'WARN: Unknown option (ignored): %s\n' "$1" >&2
    ;;
  *)          # Default case: No more options, so break out of the loop.
    show_help # Display a usage synopsis.
    die 'ERROR: "--env" requires a non-empty option argument.'
    ;;
  esac
  shift
done

export APPLICATION_ENV="${APPLICATION_ENV}"

echo -e "$VERT--> You are uing APPLICATION_ENV: $APPLICATION_ENV $NORMAL"

command -v $PHP >/dev/null || {
  echo "The 'php' command not found."
  exit 1
}

command -v $PERL >/dev/null || {
  echo "The 'perl' command not found."
  exit 1
}
HASCURL=1

command -v curl >/dev/null || HASCURL=0

if [ -z "$1" ]; then
  DEVMODE=$1
else
  DEVMODE="--no-dev"
fi

### settings / options
PHPCOPTS="-d memory_limit=-1"

# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/platform_path\(\?string \\\$path = null\)/platform_path\(\?string \\\$path = null, string \\\$platform_path = 'dev'\)/g")
# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/base_path\('dev'/base_path\(\\\$platform_path/g")
# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/addTemplateSettings\(string \\\$module, \?array \\\$data, string \\\$type = 'plugins'\)/addTemplateSettings\(string \\\$module, \?array \\\$data, string \\\$type = 'plugins', string \\\$platform_path = 'dev'\)/g")
# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/\\\$key . '.tpl'\n/\\\$key . '.tpl', \\\$platform_path\n/g")
# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s//g")
# ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s//g")

if [ -f "$SCRIPT_PATH/../dev/core/base/src/Supports/EmailHandler.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/public function __construct\(\)/protected string \\\$platform_path = 'dev';\n\n\tpublic function setPlatformPath\(\\\$platform_path = 'dev')\{\\\$this\-\>platform_path = \\\$platform_path; return \\\$this;\}\n\tpublic function getPlatformPath\()\{return \\\$this\-\>platform_path;\}\n\n\tpublic function __construct\(public string \\\$platform_type = 'dev'\)/g" $SCRIPT_PATH/../dev/core/base/src/Supports/EmailHandler.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/\\\$key . '.tpl'\n/\\\$key . '.tpl', \\\$this->getPlatformPath\(\)\n/g" $SCRIPT_PATH/../dev/core/base/src/Supports/EmailHandler.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/get_setting_email_template_content\(\\\$type, \\\$this\-\>module, \\\$template\)/get_setting_email_template_content\(\\\$type, \\\$this\-\>module, \\\$template, \\\$this\-\>getPlatformPath\(\)\)/g" $SCRIPT_PATH/../dev/core/base/src/Supports/EmailHandler.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/get_setting_email_template_content\(\\\$this\-\>type, \\\$this\-\>module, \\\$this\-\>template\)/get_setting_email_template_content\(\\\$this\-\>type, \\\$this\-\>module, \\\$this\-\>template, \\\$this\-\>getPlatformPath\(\)\)/g" $SCRIPT_PATH/../dev/core/base/src/Supports/EmailHandler.php)
fi
if [ -f "$SCRIPT_PATH/../dev/core/base/helpers/common.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/base_path\('dev'/base_path\(\\\$platform_path/g" $SCRIPT_PATH/../dev/core/base/helpers/common.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/platform_path\(\?string \\\$path = null\)/platform_path\(\?string \\\$path = null, string \\\$platform_path = 'dev'\)/g" $SCRIPT_PATH/../dev/core/base/helpers/common.php)
fi
if [ -f "$SCRIPT_PATH/../dev/core/setting/helpers/helpers.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/get_setting_email_template_content\(string \\\$type, string \\\$module, string \\\$templateKey\)/get_setting_email_template_content\(string \\\$type, string \\\$module, string \\\$templateKey, string \\\$platform_path = 'dev'\)/g" $SCRIPT_PATH/../dev/core/setting/helpers/helpers.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/\\\$templateKey . '.tpl'\)/\\\$templateKey . '.tpl', \\\$platform_path\)/g" $SCRIPT_PATH/../dev/core/setting/helpers/helpers.php)
fi

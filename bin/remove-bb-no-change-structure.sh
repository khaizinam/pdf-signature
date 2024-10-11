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
[ ! -d $SCRIPT_PATH/../vendor ] && $ECHO "No vendor directory found" || $RM -rf $SCRIPT_PATH/../vendor/

if [ -d "$SCRIPT_PATH/../lang" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../lang/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/version of Botble/version of Platform/g')
fi

if [ -f "$SCRIPT_PATH/../database.sql" ]; then
  ### SuperAdmin in Botble CMS
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$10\$GB\.Fw1a\/osntfrkiyX72cO5BxfgMDhg80XpdFHh5joj1udK\/cgAU6/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$\/TFkWFGqoi8ghH8FTOjM4ucqge2KXuZRZ\/4Mv3klr4ZAYxU500ctW/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$LQ4\/xO2jnhCKQwoIrhGdnepKXy\/2fOPdkkVz6v7xdGk5AxICb2BlC/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$AjaffJm\/SgRqIkEq\.Hw6lOiKhKDhvYyaTmaohTHLM9thXe1AhMt3q/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$t\.LS\.QjivLPruXccnl8B0uuy9U8V4k\.6GRcRNJ70qUwfc3\/xtI2Yu/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ### SuperAdmin in Flexhome
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$HYEUN4HLrjx5mXO8M1JfBOcqH\.gXdQVl\/qqqJp\/N2d8DHFjtLhaui/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$3ouZBNvZ8yOPcxXxEKJVQuEoMGrK\/QVtpA6FRX2LZwMMAK4Vi\/0Oe/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$TIf84jZuSeuYTPOWpH7rR\.fv0zt4F4ZTDEeCkzNsum2OTvWy9Lcoe/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ### SuperAdmin in Shopwise
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$10\$Y1n8whq\/bq2jjp8WC6kM6evQ2RZwOWxXxTierjBu0i8wtkQjVNHgW/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/super\@botble\.com/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/admin\@botble\.com/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/user\@botble\.com/user\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/valentine\.stiedemann\@funk\.com/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/alphonso22\@keebler\.info/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/lboyle\@jones\.com/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/toni93\@weber\.org/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/admin\@botble.com - 159357/superadmin\@fsofts\.com - It\@\@246357/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble - 159357/superadmin\@fsofts\.com - It\@\@246357/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/A young team in Vietnam/Laravel is the best/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/dev-botble/dev-laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/1\.envato\.market\/LWRBY/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/botble-cms-php-platform-based-on-laravel-framework\/16928182/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Database\: botble/Database\: laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.ticksy.com/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble, botble team, botble platform/vswb team, developer team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/cms\.botble\.com/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.local/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.technologies/laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Platform/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble-cms/laravel-cms/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minhsang2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minsang2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyen\.info/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Nghia Minh/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\//\"platform\//g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/84988606928/84943999819/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/nghiadev\.com/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/The Botble/The Laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangplus\.com/fsofts\.com\/docs-cms/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Platform\\\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Platform\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Platform\\\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Platform\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble/Laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\/cms/laravel\/cms/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\=botble/\=laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Nghia Minh/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Sang Nguyen/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.test/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/BOTBLE Teams/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Fans/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble team/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble product/Laravel product/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble product/Laravel product/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/good job Botble/good job Laravel product/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/confident in Botble/confident in Laravel product/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble puts/Laravel Technologies puts/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/at Botble/at Laravel Technologies/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Thank you Botble/Thank you Laravel/g' $SCRIPT_PATH/../database.sql)
else
  echo -e "$COL_RED Could not found database.sql $NORMAL"
fi

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/\(Botble/\(Platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble community/Laravel community/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_cookie_consent/apps_cookie_consent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\/translations/vswb\/translations/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev-botble/dev-laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-my-style/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\@botble\/core/\@platform\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\@botble\/media/\@platform\/media/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-my-style/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble-my-style/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble My Style/My Style/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble core/Platform core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble Marketplace/Laravel CMS Platform Marketplace/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/BotBle CMS/Laravel Platform CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble IP Blocker/Laravel Platform IP Blocker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble URL/Laravel Platform URL/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\[Botble/\[Platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\#botble/\#platform/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble\.com\/storage\/uploads\/1/https\:\/\/fsofts\.com\/docs-cms\/images\/analytics/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\` - \`159357\`/superadmin\@fsofts\.com - It\@\@246357/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\`/superadmin\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`159357\`/It\@\@246357/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/user\/botble/fsofts\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\/plugin-management\`/\`platform\/plugin-management\`/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/whats-new-in-botble-cms-33/whats-new-in-laravel-cms-33/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/github\.com\/botble\/issues\/issues\/1/https\:\/\/github\.com\/google\/issues\/issues\/1/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\/vendor\/botble\/menu/\/vendor\/platform\/menu/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble-ip-blocker/platform-ip-blocker/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/ngoquocdat.dev/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/1\.envato\.market\/LWRBY/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/botble-cms-php-platform-based-on-laravel-framework\/16928182/https\:\/\/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\/botble\//\/vswb\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble plugin/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/composer require botble/composer require platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/marketplace.laravel-cms.demo.fsofts.com/marketplace.fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble\/git-commit-checker/platform\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github.com\/botble/github.com\/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '.env.example' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble\//fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/baoboine\//fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/baoboine\/botble-comment/fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-comment/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/nivianh\//fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Martfury/Laravel CMS Platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/martfury-multipurpose-laravel-ecommerce-system\/29925223/https\:\/\/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/repos\/botble/repos\/vswb/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\:\:log\-viewer/platform\:\:log\-viewer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Try to reinstall botble\/git-commit-checker package/Try to reinstall platform\/git-commit-checker package/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs.botble.com/docs.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/1.envato.market\/LWRBY/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Just another Botble CMS site/Just another Laravel CMS Website/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/john.smith\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/support\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble.com\/go\/download-cms/mailto\:contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble.com/mailto\:contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble BOT/Anonymous BOT/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_session/apps_session/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Team/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Ex: botble/Ex: your-key/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/amazonaws.com\/botble/amazonaws.com\/your-key/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\"/\"Laravel Framework\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble cms/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble assets/Laravel CMS Assets/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble git commit checker/Git Commit Checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite Technologies/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/fsofts\.com/g')
#
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/vswb team, developer team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/vswb team, developer team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/vswb team, developer team/g')
#
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.local/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.local/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.local/fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/version of Botble/version of Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"platform\//g')
#($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"platform\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"platform\//g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/fsofts\.com\/docs-cms/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/fsofts\.com\/docs-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/fsofts\.com\/docs-cms/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Platform\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Platform\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Platform\\\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.env' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.env' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Platform\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Platform\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble.com/superadmin\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sales\@botble.com/sales\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sale\@botble.com/sales\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Shopwise/Laravel Ecommerce/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/159357/It\@\@246357/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BOTBLE Teams/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Fans/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble team/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Team/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble product/Laravel product/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble product/Laravel product/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/good job Botble/good job Laravel product/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/confident in Botble/confident in Laravel product/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble puts/Laravel Technologies puts/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/at Botble/at Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Thank you Botble/Thank you Laravel/g')

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

if [ -f "$SCRIPT_PATH/../database/seeders/UserSeeder.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble/superadmin/g' $SCRIPT_PATH/../database/seeders/UserSeeder.php)
fi
if [ -f "$SCRIPT_PATH/../database/seeders/WidgetSeeder.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble/Platform/g' $SCRIPT_PATH/../database/seeders/WidgetSeeder.php)
fi
if [ -f "$SCRIPT_PATH/../_ide_helper.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Platform\\/g' $SCRIPT_PATH/../_ide_helper.php)
fi

## Hack license +1k years
## ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/return \$response\-\>setError\(\)\-\>setMessage\(\'Your license is invalid, please contact support\'\)\;/\/\/ return \$response\-\>setError\(\)\-\>setMessage\(\'Your license is invalid, please contact support.\'\)\;/g")

############################ VERY IMPORTANT: Below lines MUST BE run at the end of ABOVE process
############################ BEGIN: make sure all botble.com domain already have replaced by fsofts.com
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/fsofts\.com/g')

## BEGIN: Assets & Git Commit Checker Package Processing
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/assets\"\: \"\^1\.0\"/\"platform\/assets\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/assets/\"platform\/assets/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool\"\: \"\^1\.0\"/\"platform\/dev-tool\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool\"\: \"\^2\.0\"/\"platform\/dev-tool\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"platform\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^1\.0\"/\"platform\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^2\.0\"/\"platform\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^2\.1\"/\"platform\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"platform\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-vnpayment-plugin/vnpayment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-2fa/2fa/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-ip-blocker/ip-blocker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-plugin/plugin/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble api/platform api/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble dev tools/platform dev tools/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/BotBle CMS/Laravel Platform CMS/g')
## END: Assets & Git Commit Checker Package Processing

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name 'LICENSE' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble.com/contact\@fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name 'LICENSE' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')

if [ -f "$SCRIPT_PATH/../composer.lock" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Platform\\\\/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\//\"platform\//g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/github\.com\/botble/github\.com\/vswb/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/github\.com\/repos\/botble/github\.com\/repos\/vswb/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/fsofts\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/fsofts\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.ticksy\.com/vswb\.ticksy\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Sang Nguyen/Developer Team/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Platform/Laravel CMS Platform/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble/\"platform/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyenplus\@gmail.com/admin\@fsofts.com/g' $SCRIPT_PATH/../composer.lock)
fi

($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/get-started/\"platform\/get-started/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/installer/\"platform\/installer/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/git-commit-checker/\"platform\/git-commit-checker/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/comment/\"platform\/comment/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/api/\"platform\/api/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/menu/\"platform\/menu/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/optimize/\"platform\/optimize/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/page/\"platform\/page/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/platform/\"platform\/platform/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/shortcode/\"platform\/shortcode/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/theme\"/\"platform\/theme\"/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/theme-generator\"/\"platform\/theme-generator\"/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/plugin-management/\"platform\/plugin-management/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/dev-tool/\"platform\/dev-tool/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/plugin-generator/\"platform\/plugin-generator/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/widget-generator/\"platform\/widget-generator/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/revision/\"platform\/revision/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/sitemap/\"platform\/sitemap/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/slug/\"platform\/slug/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/seo-helper/\"platform\/seo-helper/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/widget/\"platform\/widget/g' $SCRIPT_PATH/../composer.json)

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/\{-module\}/\"platform\/\{-module\}/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/audit-log/\"platform\/audit-log/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/backup/\"platform\/backup/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/block/\"platform\/block/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/blog/\"platform\/blog/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/contact/\"platform\/contact/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/cookie-consent/\"platform\/cookie-consent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/custom-fields/\"platform\/custom-fields/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/gallery/\"platform\/gallery/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/language/\"platform\/language/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/language-advanced/\"platform\/language-advanced/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/member/\"platform\/member/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/request-log/\"platform\/request-log/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/get-started/\"platform\/get-started/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/installer/\"platform\/installer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"platform\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/comment/\"platform\/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"platform\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/api\"/\"platform\/api\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/menu\"/\"platform\/menu\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/optimize\"/\"platform\/optimize\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/page\"/\"platform\/page\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/platform\"/\"platform\/platform\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/shortcode\"/\"platform\/shortcode\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/theme\"/\"platform\/theme\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/theme-generator\"/\"platform\/theme-generator\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/plugin-management/\"platform\/plugin-management/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"platform\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/plugin-generator/\"platform\/plugin-generator/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/widget-generator\"/\"platform\/widget-generator\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/\{\-theme\}/platform\/\{\-theme\}/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/ripple/platform\/ripple/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/widget\"/\"platform\/widget\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/sitemap/\"platform\/sitemap/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/slug/\"platform\/slug/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/seo-helper/\"platform\/seo-helper/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/revision/\"platform\/revision/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/analytics/\"platform\/analytics/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/social-login/\"platform\/social-login/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/captcha/\"platform\/captcha/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/translation/\"platform\/translation/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/\{\-name\}/\"platform\/\{\-name\}/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"platform\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/impersonate/\"platform\/impersonate/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/payment/\"platform\/payment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/newsletter/\"platform\/newsletter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/mollie/\"platform\/mollie/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/paystack/\"platform\/paystack/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/razorpay/\"platform\/razorpay/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/square/\"platform\/square/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/simple-slider/\"platform\/simple-slider/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/get-started/\"platform\/get-started/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/ecommerce/\"platform\/ecommerce/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/ads/\"platform\/ads/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/faq/\"platform\/faq/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/location/\"platform\/location/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/paypal/\"platform\/paypal/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/shippo/\"platform\/shippo/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/sslcommerz/\"platform\/sslcommerz/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/stripe/\"platform\/stripe/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/testimonial/\"platform\/testimonial/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/career/\"platform\/career/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/real-estate/\"platform\/real-estate/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/flex-home/\"platform\/flex-home/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/rss-feed/\"platform\/rss-feed/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/code-highlighter/\"platform\/code-highlighter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/log-viewer/\"platform\/log-viewer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/maintenance-mode/\"platform\/maintenance-mode/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/my-style/\"platform\/my-style/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/post-scheduler/\"platform\/post-scheduler/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../platform/ -type f -name '*.xml' -print0 | xargs -0 $PERL -i -pe 's/Botble Test Suite/Laravel CMS Test Suite/g')

if [ -d "$SCRIPT_PATH/../public/storage" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/storage/ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/botble.test/laravel-cms.demo.fsofts.com/g')
fi

############################ END: make sure all botble.com domain already have replaced by fsofts.com
#

## REMOVE JS
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../storage/ -type f -print0 | xargs -0 $PERL -i -pe 's/workspace\/botble/workspace\/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../storage/ -type f -print0 | xargs -0 $PERL -i -pe 's/botble\.test/laravel-cms\.test/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.widget/apps\.widget/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables\./AppVars\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables/AppVars/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.show/Apps\.show/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.hide/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.handle/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.init/Apps\.init/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL\./APP_MEDIA_URL\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/filter_table_id\=botble/filter_table_id\=platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/class\=Botble/class\=Platform/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_footprints_cookie/platform_footprints_cookie/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_footprints_cookie_data/platform_footprints_cookie_data/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/typeof Botble/typeof Apps/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/typeof Botble/typeof Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/user\/botble\/portfolio/user\/vswb\/portfolio/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble Media/Apps Media/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables\./AppVars\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables/AppVars/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/export default class Botble/export default class Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/import Botble from/import Apps from/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/class Botble/class Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/new Botble/new Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.botbleCookieConsent/window\.appsCookieConsent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble \= Botble/window\.Apps \= Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble/window\.Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\;/Apps\;/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\./Apps\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL\./APP_MEDIA_URL\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble ckeditor/Laravel ckeditor/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Created by Botble/Created by Laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/user\/john-smith/user\/fsofts/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/user\/botble\/portfolio/user\/vswb\/portfolio/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble \= Botble/window\.Apps \= Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble/window\.Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/Botble\.show/Apps\.show/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/Botble\.hide/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/Botble\.handle/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/Botble\./Apps\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL\./APP_MEDIA_URL\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables\./AppVars\./g')

## END REMOVE JS

## REMOVE RV MEDIA
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/RvMedia\"/AppMedia\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/RvMedia\:\:/AppMedia\:\:/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RvMedia\:\:/AppMedia\:\:/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rvMedia\:\:/AppMedia\:\:/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RvMediaFacade\:\:/AppMediaFacade\:\:/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/class RvMediaFacade/class AppMediaFacade/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/class RvMedia/class AppMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/use RvMedia\;/use AppMedia\;/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Platform\\Media\\RvMediaFacade/Platform\\Media\\AppMediaFacade/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Platform\\Media\\RvMedia/Platform\\Media\\AppMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RvMedia/AppMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_CONFIG/APP_MEDIA_CONFIG/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_WATERMARK_/APP_MEDIA_WATERMARK_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_UPLOAD_CHUNK/APP_MEDIA_UPLOAD_CHUNK/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_DEFAULT/APP_MEDIA_DEFAULT/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_SIDEBAR/APP_MEDIA_SIDEBAR/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_DOCUMENT_/APP_MEDIA_DOCUMENT_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_ALLOWED/APP_MEDIA_ALLOWED/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv_media_handle_upload/app_media_handle_upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv_media_modal/app_media_modal/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/\#rv_media_/\#app_media_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/id\=\"rv_media_/id\=\"app_media_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/id\=\"rv_action_/id\=\"app_action_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-action/app-action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-media/app-media/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-dropdown/app-dropdown/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-clipboard/app-clipboard/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-modals/app-modals/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-upload/app-upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-table/app-table/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-form/app-form/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/rv-btn/app-btn/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.rvMedia\./window\.appMedia\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.rvMedia/window\.appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/fn\.rvMedia/fn\.appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\.rvMedia/\.appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\= rvMedia/\= appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\$rvMediaContainer/\$appMediaContainer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rvMediaContainer/appMediaContainer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rvMedia\;/appMedia;/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/class rvMedia/class appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/new rvMedia/new appMedia/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/new RvMediaStandAlone/new AppMediaStandAlone/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window.RvMediaStandAlone/window.AppMediaStandAlone/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_CONFIG/APP_MEDIA_CONFIG/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_WATERMARK_/APP_MEDIA_WATERMARK_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_UPLOAD_CHUNK/APP_MEDIA_UPLOAD_CHUNK/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_DEFAULT/APP_MEDIA_DEFAULT/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_SIDEBAR/APP_MEDIA_SIDEBAR/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_DOCUMENT_/APP_MEDIA_DOCUMENT_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv_media_handle_upload/app_media_handle_upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv_media_modal/app_media_modal/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\#rv_media_/\#app_media_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\#rv_action/\#app_action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv_action/app_action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv_media_/app_media_/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-action/app-action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-media/app-media/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-dropdown/app-dropdown/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-clipboard/app-clipboard/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-modals/app-modals/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-upload/app-upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-table/app-table/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-form/app-form/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/rv-btn/app-btn/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/\#rv_media_/\#app_media_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/\#rv_media_/\#app_media_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-media/app-media/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-media/app-media/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv_action/app_action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv_action/app_action/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-dropdown/app-dropdown/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-dropdown/app-dropdown/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-clipboard/app-clipboard/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-clipboard/app-clipboard/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-modals/app-modals/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-modals/app-modals/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-upload/app-upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-upload/app-upload/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-table/app-table/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-table/app-table/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-form/app-form/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-form/app-form/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/rv-btn/app-btn/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/rv-btn/app-btn/g')

## Must run at the of block
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL/APP_MEDIA_URL/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL/APP_MEDIA_URL/g')
## END REMOVE RV MEDIA

if [ -f $SCRIPT_PATH/../platform/core/media/src/RvMedia.php ]; then
  $RM -f $SCRIPT_PATH/../platform/core/media/src/AppMedia.php
  (LC_ALL=C $MV $SCRIPT_PATH/../platform/core/media/src/RvMedia.php $SCRIPT_PATH/../platform/core/media/src/AppMedia.php)
  echo -e "$BLUE Renamed RvMedia > AppMedia $NORMAL"
else
  echo -e "$COL_RED Could not found RvMedia $NORMAL"
fi

if [ -f $SCRIPT_PATH/../platform/core/media/src/Facades/RvMedia.php ]; then
  $RM -f $SCRIPT_PATH/../platform/core/media/src/Facades/AppMediaFacade.php
  (LC_ALL=C $MV $SCRIPT_PATH/../platform/core/media/src/Facades/RvMedia.php $SCRIPT_PATH/../platform/core/media/src/Facades/AppMedia.php)
  echo -e "$BLUE Renamed Facades/RvMedia > Facades/AppMedia $NORMAL"
else
  echo -e "$COL_RED Could not found Facades/RvMedia $NORMAL"
fi
## END REMOVE RV MEDIA

## ($CD $SCRIPT_PATH/../ && LC_ALL=C $ZIP -r botble.zip . -x \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.md \*.MD \*.log \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat bin/delivery.sh bin/remove-botble.sh readme.html composer.lock wp-config.secure.php \*.yml\* \*.editorconfig\* \*.rnd\*)

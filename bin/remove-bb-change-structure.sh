################################################################
## Shell script : remove author information with shell,
## This script will be remove author information, namespace (use Dev). No change other application's structure anymore!
##
## Author: Weber Team!
## Copy Right: @2011 Weber Team!
################################################################

## B1: Download mã nguồn gốc về, giải nén, xóa folder "vendor"
## B2: Copy hết mọi thứ TRỪ folder "platform", paste qua thư mục dự án laravel-cms
## B3: Mở folder platform/core/* Copy hết mọi thứ bên trong, paste qua thư mục dự án laravel-cms/dev/core/
## B4: Mở folder platform/packages/* Copy hết mọi thứ bên trong, paste qua thư mục dự án laravel-cms/dev/libs/
## B5: Mở folder platform/plugins/* Copy hết mọi thứ bên trong, paste qua thư mục dự án laravel-cms/dev/plugins/
## B6: Copy folder platform/themes, paste qua thư mục dự án laravel-cms/dev (trước đó có thể tồn tại folder platform/ui, cần xóa đi, shell sẽ tự động replace platform/themes/[botble-theme] > platform/themes/ui)
## B7: chạy lệnh bash bin/remove-bb-change-structure.sh -e d
## B8: revert lại vài dòng quan trọng của root/composer.json và kiểm tra / tìm kiếm từ khóa botble trong toàn dụ án xem có phát sinh mới ở đâu không

## DONE

#!/bin/bash
os='unknown'

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
  os='macosx'
elif [[ "$os" == 'msys' ]]; then
  os='window'
elif [[ "$os" == 'linux' ]]; then
  os='linux'
fi
echo -e "$ROUGE You are using $os $NORMAL"

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
[ ! -d $SCRIPT_PATH/../bootstrap/cache ] && $ECHO "No cache directory found" || $RM -rf $SCRIPT_PATH/../bootstrap/cache/*.php
[ ! -f "$SCRIPT_PATH/../composer.lock" ] && $ECHO "No composer.lock directory found" || $RM -rf $SCRIPT_PATH/../composer.lock
[ ! -f "$SCRIPT_PATH/../composer.phar" ] && $ECHO "No composer.phar directory found" || $RM -rf $SCRIPT_PATH/../composer.phar

if [ -d "$SCRIPT_PATH/../lang" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../lang/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/version of Botble/version of Dev/g')
fi

if [ -f "$SCRIPT_PATH/../database.sql" ]; then
  ### SuperAdmin in Botble CMS
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$10\$GB\.Fw1a\/osntfrkiyX72cO5BxfgMDhg80XpdFHh5joj1udK\/cgAU6/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$\/TFkWFGqoi8ghH8FTOjM4ucqge2KXuZRZ\/4Mv3klr4ZAYxU500ctW/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$LQ4\/xO2jnhCKQwoIrhGdnepKXy\/2fOPdkkVz6v7xdGk5AxICb2BlC/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$AjaffJm\/SgRqIkEq\.Hw6lOiKhKDhvYyaTmaohTHLM9thXe1AhMt3q/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$t\.LS\.QjivLPruXccnl8B0uuy9U8V4k\.6GRcRNJ70qUwfc3\/xtI2Yu/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$K9JNFf8YtY6GqYOxtwHLhOSxFcLEVL7efcp0214\.\/Gr04\/WyNgPk2/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$K9JNFf8YtY6GqYOxtwHLhOSxFcLEVL7efcp0214\.\/Gr04\/WyNgPk2/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$b1nNB4TPBiFcNgUHpVqt5OXhHi9vPRsewXIT9dkV4527QFeeARGOm/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ### SuperAdmin in Flexhome
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$HYEUN4HLrjx5mXO8M1JfBOcqH\.gXdQVl\/qqqJp\/N2d8DHFjtLhaui/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$3ouZBNvZ8yOPcxXxEKJVQuEoMGrK\/QVtpA6FRX2LZwMMAK4Vi\/0Oe/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$TIf84jZuSeuYTPOWpH7rR\.fv0zt4F4ZTDEeCkzNsum2OTvWy9Lcoe/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ### SuperAdmin in Shopwise
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$10\$Y1n8whq\/bq2jjp8WC6kM6evQ2RZwOWxXxTierjBu0i8wtkQjVNHgW/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$fJN4S29g\/mCY133gMhJIRuKJgLfTQS8rwF53rTz\.eE1RmQb7bBUKa/\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\$2y\$12\$bpqcdnX08YKYYWGniJuJ\/e2zuhHdOB2Tmdxikzyn32byRuBJBvbg\./\$2y\$10\$kXdnGd6ihMDut\/f9rm8xQOXg0CG0V1VgyzBa3nrcC5rOVCgBSe7rS/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/kyra\.orn\@ohara.info/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/okeefe\@swaniawski\.biz/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/super\@botble\.com/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/admin\@botble\.com/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/user\@botble\.com/user\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/valentine\.stiedemann\@funk\.com/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/alphonso22\@keebler\.info/superadmin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/lboyle\@jones\.com/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/toni93\@weber\.org/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/zokeefe\@swaniawski\.biz/admin\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/admin\@botble.com - 159357/superadmin\@fsofts\.com - It\@\@246357/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble - 159357/superadmin\@fsofts\.com - It\@\@246357/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/A young team in Vietnam/Laravel is the best/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/dev-botble/dev-laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/1\.envato\.market\/LWRBY/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/botble-cms-php-platform-based-on-laravel-framework\/16928182/fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Database\: botble/Database\: laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.ticksy.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble, botble team, botble platform/development team, dev features/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/cms\.botble\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.local/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble.technologies/laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Platform/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble-cms/laravel-cms/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minhsang2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minsang2603/toan\.lehuy/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyen\.info/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Nghia Minh/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\//\"dev\//g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/84988606928/84943999819/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/nghiadev\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/The Botble/The Laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangplus\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Dev\\\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Dev\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Dev\\\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Dev\\/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble/Laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\/cms/laravel\/cms/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\=botble/\=laravel/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Nghia Minh/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Sang Nguyen/Developer Team/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/support\@company\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.test/cms\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/shopwise\.test/laravel-ecommerce\.demo\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/flex-home\.test/laravel-realestate\.demo\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
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
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/flex-home\.cms\.fsofts\.com/laravel-realestate\.demo\.fsofts\.com/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/shopwise-/master-/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Shopwise/Master/g' $SCRIPT_PATH/../database.sql)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/shopwise/master/g' $SCRIPT_PATH/../database.sql)
else
  echo -e "$COL_RED Could not found database.sql $NORMAL"
fi

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/vendor/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\[Botble/\[Dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/vendor/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\#botble/\#dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/vendor/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble-ecommerce/dev-ecommerce/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\[Botble/\[Dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble-ecommerce/dev-ecommerce/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb\/dev-comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\#botble/\#dev/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/\(Botble/\(Dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble community/Laravel community/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble_cookie_newsletter/apps_cookie_newsletter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_cookie_consent/apps_cookie_consent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\/translations/vswb\/translations/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble_cookie_newsletter/apps_cookie_newsletter/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev-botble/dev-laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-my-style/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\@botble\/core/\@dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\@botble\/media/\@dev\/media/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-my-style/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble-my-style/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble My Style/My Style/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble core/Dev core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble Marketplace/Laravel Marketplace/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble IP Blocker/Laravel IP Blocker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble URL/Laravel URL/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/baoboine\/botble-comment/vswb\/dev-comment/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble\.com\/storage\/uploads\/1/https\:\/\/cms\.fsofts\.com\/images\/analytics/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\` - \`159357\`/superadmin\@fsofts\.com - It\@\@246357/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\`/superadmin\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`159357\`/It\@\@246357/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/user\/botble/fsofts\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\`botble\/plugin-management\`/\`dev\/plugin-management\`/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/whats-new-in-botble-cms-33/whats-new-in-laravel-cms-33/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/github\.com\/botble\/issues\/issues\/1/https\:\/\/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\/vendor\/botble\/menu/\/vendor\/dev\/menu/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble-ip-blocker/dev-ip-blocker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Ngo Quoc Dat/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Tuoitresoft developers/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Friends Of Botble/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Friends of Botble/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Binjuhor from XDevLabs Team/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/binjuhor.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github.com\/FriendsOfBotble/github.com\/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github.com\/nivianh/github.com\/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Anh Ngo/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Nawras Bukhari/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github.com\/NawrasBukhari\/postpay-botble/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble /Core /g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/ngoquocdat.dev/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/1\.envato\.market\/LWRBY/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/botble-cms-php-platform-based-on-laravel-framework\/16928182/https\:\/\/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\/botble\//\/vswb\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble plugin/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/composer require botble/composer require dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/marketplace.botble.com/marketplace.fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble\/git-commit-checker/dev\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/datlechin/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Botble/Core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Tuoitre Soft/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/alnovate.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/dev\.com/https\:\/\/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/tuoitresoft.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/Alnovate Digital/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/friendsofbotble/dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/\/fob-/\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/FOB //g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '.env.example' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/repos\/botble/repos\/vswb/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble\/location/github\.com\/vswb\/locations/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/_botble_member/_dev_member/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/_botble_contact/_dev_contact/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\/\{/Dev\/\{/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\/example-plugin/dev\/example-plugin/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble/https\:\/\/fsofts/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble\//cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble\//cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/botble\//cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/baoboine\//cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/baoboine\/botble-comment/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-comment/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/fob-comment/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/fob-//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FOB //g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/nivianh\//cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Martfury/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/codecanyon\.net\/item\/martfury-multipurpose-laravel-ecommerce-system\/29925223/https\:\/\/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/nivianh\//cms\.fsofts\.com\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/github\.com\/FriendsOfBotble\//cms\.fsofts\.com\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"FriendsOfBotble\"/\"Laravel CMS\"/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\:\:log\-viewer/dev\:\:log\-viewer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/_botble_/_apps_/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/BotBle CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/flex-home.com/laravel-realestate\.demo\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Try to reinstall botble\/git-commit-checker package/Try to reinstall dev\/git-commit-checker package/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs.botble.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/1.envato.market\/LWRBY/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Just another Botble CMS site/Just another Laravel CMS Website/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/john.smith\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/support\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble.com\/go\/download-cms/mailto\:contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/https\:\/\/botble.com/mailto\:contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-2fa/2fa/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-activator/laravel-activator/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-activator-main/laravel-activator-main/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/shaqi\/botble-activator/vswb\/laravel-activator/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BotbleCMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-plugin/plugin/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble BOT/Anonymous BOT/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_session/apps_session/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Team/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Ex: botble/Ex: your-key/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/amazonaws.com\/botble/amazonaws.com\/your-key/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Marketplace/Laravel Marketplace/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/friends-of-botble/dev/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Nghĩa Nè/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Phạm Viết Nghĩa/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/nghiane.com/fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-2fa/2fa/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-plugin/plugin/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/friendsofbotble/dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble/dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\/fob-/\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/FOB //g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\"/\"Laravel Framework\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble cms/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Facebook Reaction for Botble/Facebook Reaction for Laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble assets/Laravel Assets/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble git commit checker/Git Commit Checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite Technologies/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Archi Elite/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Tuoitre Soft/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/tuoitresoft.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/archielite.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.ticksy.com/cms\.fsofts\.com/g')
#
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/development team, dev features/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/development team, dev features/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble, botble team, botble platform/development team, dev features/g')
#
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/cms\.botble\.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.local/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.local/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.local/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble Platform/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble.technologies/laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/twitter\.com\/botble/twitter\.com\/laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/version of Botble/version of Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble-cms/laravel-cms/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minsang2603/toan\.lehuy/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyen\.info/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble since v2.0/Laravel CMS since v2.0/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"dev\//g')
#($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"dev\//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/\"botble\//\"dev\//g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/84988606928/84943999819/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/docs\.botble\.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe "s/'botble'/'contact\@fsofts\.com'/g")

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/admin\@botble\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble\.cms\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/nghiadev\.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/The Botble/The Laravel/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Nghia Minh/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Sang Nguyen/Developer Team/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangnguyenplus\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/minhsang2603\@gmail\.com/contact\@fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/sangplus\.com/cms\.fsofts\.com/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\\\/Dev\\\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Dev\\\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../resources/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.env' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.env' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel CMS/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FriendsOfBotble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\\\/Dev\\\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\\/Dev\\/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/support\@company\.com/support\@fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/customer\@botble.com/customer\@fsofts\.com/g')
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
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/nghiane.com/fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../database/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Flex Home/Shop Zone/g')

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
if [ -f "$SCRIPT_PATH/../dev/plugins/ecommerce/src/Database/Seeders/ReviewSeeder.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble/Laravel/g' $SCRIPT_PATH/../dev/plugins/ecommerce/src/Database/Seeders/ReviewSeeder.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/BOTBLE/Laravel/g' $SCRIPT_PATH/../dev/plugins/ecommerce/src/Database/Seeders/ReviewSeeder.php)
fi
if [ -f "$SCRIPT_PATH/../database/seeders/WidgetSeeder.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble/Dev/g' $SCRIPT_PATH/../database/seeders/WidgetSeeder.php)
fi
if [ -f "$SCRIPT_PATH/../_ide_helper.php" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\/Dev\\/g' $SCRIPT_PATH/../_ide_helper.php)
fi

## Hack license +1k years
## ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/return \$response\-\>setError\(\)\-\>setMessage\(\'Your license is invalid, please contact support\'\)\;/\/\/ return \$response\-\>setError\(\)\-\>setMessage\(\'Your license is invalid, please contact support.\'\)\;/g")

############################ VERY IMPORTANT: Below lines MUST BE run at the end of ABOVE process
############################ BEGIN: make sure all botble.com domain already have replaced by fsofts.com
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g')

## BEGIN: Assets & Git Commit Checker Package Processing
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/assets\"\: \"\^1\.0\"/\"dev\/assets\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/form-builder\"\: \"\^1\.0\"/\"dev\/form-builder\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/data-synchronize\"\: \"\^1\.0\"/\"dev\/data-synchronize\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/assets/\"dev\/assets/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/form-builder/\"dev\/form-builder/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/data-synchronize/\"dev\/data-synchronize/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble-package/\"package/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/api\"\: \"\^2\.0\.0\"/\"dev\/api\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool\"\: \"\^1\.0\.2\"/\"dev\/dev-tool\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool\"\: \"\^2\.0\"/\"dev\/dev-tool\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"dev\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^1\.0\"/\"dev\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^2\.0\"/\"dev\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker\"\: \"\^2\.1\"/\"dev\/git-commit-checker\"\: \"\*\@dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"dev\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-vnpayment-plugin/vnpayment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-2fa/2fa/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-ip-blocker/ip-blocker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble-plugin/plugin/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble api/dev api/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble dev tools/dev dev tools/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Botble CMS/Laravel Dev CMS/g')
## END: Assets & Git Commit Checker Package Processing

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name 'LICENSE' -print0 | xargs -0 $PERL -i -pe 's/contact\@botble.com/contact\@fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name 'LICENSE' -print0 | xargs -0 $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name 'LICENSE' -print0 | xargs -0 $PERL -i -pe 's/Friends Of Botble/Laravel Technologies/g')

if [ -f "$SCRIPT_PATH/../composer.lock" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble\\\\/Dev\\\\/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\//\"dev\//g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/github\.com\/botble/github\.com\/vswb/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/github\.com\/repos\/botble/github\.com\/repos\/vswb/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.com/cms\.fsofts\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/botble\.ticksy\.com/vswb\.ticksy\.com/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Sang Nguyen/Developer Team/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Technologies/Laravel Technologies/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble CMS/Laravel CMS/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Botble Platform/Laravel CMS/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble/\"dev/g' $SCRIPT_PATH/../composer.lock)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/sangnguyenplus\@gmail.com/admin\@fsofts.com/g' $SCRIPT_PATH/../composer.lock)
fi

($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/data-synchronize/\"dev\/data-synchronize/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/get-started/\"dev\/get-started/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/installer/\"dev\/installer/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/git-commit-checker/\"dev\/git-commit-checker/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/comment/\"dev\/comment/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/api/\"dev\/api/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/menu/\"dev\/menu/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/optimize/\"dev\/optimize/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/page/\"dev\/page/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/platform/\"dev\/dev/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/shortcode/\"dev\/shortcode/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/theme\"/\"dev\/theme\"/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/theme-generator\"/\"dev\/theme-generator\"/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/plugin-management/\"dev\/plugin-management/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/dev-tool/\"dev\/dev-tool/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/plugin-generator/\"dev\/plugin-generator/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/widget-generator/\"dev\/widget-generator/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/revision/\"dev\/revision/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/sitemap/\"dev\/sitemap/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/slug/\"dev\/slug/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/seo-helper/\"dev\/seo-helper/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/widget/\"dev\/widget/g' $SCRIPT_PATH/../composer.json)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\"botble\/packages/\"dev\/libs/g' $SCRIPT_PATH/../composer.json)

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/\{-module\}/\"dev\/\{-module\}/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/audit-log/\"dev\/audit-log/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/backup/\"dev\/backup/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/block/\"dev\/block/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/blog/\"dev\/blog/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/contact/\"dev\/contact/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/cookie-consent/\"dev\/cookie-consent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/custom-fields/\"dev\/custom-fields/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/gallery/\"dev\/gallery/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/language/\"dev\/language/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/language-advanced/\"dev\/language-advanced/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/member/\"dev\/member/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/request-log/\"dev\/request-log/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/get-started/\"dev\/get-started/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/installer/\"dev\/installer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"dev\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/comment/\"dev\/comment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"dev\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/api\"/\"dev\/api\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/menu\"/\"dev\/menu\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/optimize\"/\"dev\/optimize\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/page\"/\"dev\/page\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/platform\"/\"dev\/dev\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/shortcode\"/\"dev\/shortcode\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/theme\"/\"dev\/theme\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/theme-generator\"/\"dev\/theme-generator\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/plugin-management/\"dev\/plugin-management/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/dev-tool/\"dev\/dev-tool/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/plugin-generator/\"dev\/plugin-generator/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/widget-generator\"/\"dev\/widget-generator\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/\{\-theme\}/dev\/\{\-theme\}/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/widget\"/\"dev\/widget\"/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/sitemap/\"dev\/sitemap/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/slug/\"dev\/slug/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/seo-helper/\"dev\/seo-helper/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/revision/\"dev\/revision/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/analytics/\"dev\/analytics/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/social-login/\"dev\/social-login/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/captcha/\"dev\/captcha/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/translation/\"dev\/translation/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/\{\-name\}/\"dev\/\{\-name\}/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/git-commit-checker/\"dev\/git-commit-checker/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/impersonate/\"dev\/impersonate/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/payment/\"dev\/payment/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/newsletter/\"dev\/newsletter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/mollie/\"dev\/mollie/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/paystack/\"dev\/paystack/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/razorpay/\"dev\/razorpay/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/square/\"dev\/square/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/simple-slider/\"dev\/simple-slider/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/get-started/\"dev\/get-started/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/ecommerce/\"dev\/ecommerce/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/ads/\"dev\/ads/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/faq/\"dev\/faq/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/location/\"dev\/location/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/paypal/\"dev\/paypal/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/shippo/\"dev\/shippo/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/sslcommerz/\"dev\/sslcommerz/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/stripe/\"dev\/stripe/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/testimonial/\"dev\/testimonial/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/career/\"dev\/career/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/real-estate/\"dev\/real-estate/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/flex-home/\"dev\/flex-home/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/rss-feed/\"dev\/rss-feed/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/code-highlighter/\"dev\/code-highlighter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/log-viewer/\"dev\/log-viewer/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/maintenance-mode/\"dev\/maintenance-mode/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/my-style/\"dev\/my-style/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/edit-lock/\"dev\/edit-lock/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/\"botble\/post-scheduler/\"dev\/post-scheduler/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/ngoquocdat.dev/fsofts.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Ngo Quoc Dat/Developer Team/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Friends Of Botble/Laravel Technologies/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Friends of Botble/Laravel Technologies/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.xml' -print0 | xargs -0 $PERL -i -pe 's/Botble Test Suite/Laravel CMS Test Suite/g')

if [ -d "$SCRIPT_PATH/../public/storage" ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../public/storage/ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/botble.test/laravel-cms.demo.fsofts.com/g')
fi

############################ END: make sure all botble.com domain already have replaced by fsofts.com
#

## REMOVE JS
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../storage/ -type f -print0 | xargs -0 $PERL -i -pe 's/workspace\/botble/workspace\/laravel-cms/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../storage/ -type f -print0 | xargs -0 $PERL -i -pe 's/botble\.test/cms\.fsofts\.com/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\.widget/apps\.widget/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables\./AppVars\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/BotbleVariables/AppVars/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.show/Apps\.show/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.hide/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.handle/Apps\.handle/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Botble\.init/Apps\.init/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/RV_MEDIA_URL\./APP_MEDIA_URL\./g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/filter_table_id\=botble/filter_table_id\=dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/class\=Botble/class\=Dev/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_footprints_cookie/dev_footprints_cookie/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble_footprints_cookie_data/dev_footprints_cookie_data/g')
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
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.botbleCookieNewsletter/window\.appsCookieNewsletter/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.botbleCookieConsent/window\.appsCookieConsent/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble \= Botble/window\.Apps \= Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/window\.Botble/window\.Apps/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\;/Apps\;/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\.show/Apps\.show/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\.hide/Apps\.hide/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Botble\.handle/Apps\.handle/g')
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
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.vue' -print0 | xargs -0 $PERL -i -pe 's/Botble\.handle/Apps\.handle/g')
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
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Platform\\Media\\RvMediaFacade/Dev\\Media\\AppMediaFacade/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Platform\\Media\\RvMedia/Dev\\Media\\AppMedia/g')
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
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/fob-//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/FOB //g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/fob-//g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.css' -print0 | xargs -0 $PERL -i -pe 's/fob-//g')
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

if [ -f $SCRIPT_PATH/../dev/core/media/src/RvMedia.php ]; then
  $RM -f $SCRIPT_PATH/../dev/core/media/src/AppMedia.php
  (LC_ALL=C $MV $SCRIPT_PATH/../dev/core/media/src/RvMedia.php $SCRIPT_PATH/../dev/core/media/src/AppMedia.php)
  echo -e "$BLUE Renamed RvMedia > AppMedia $NORMAL"
else
  echo -e "$COL_RED Could not found RvMedia $NORMAL"
fi

if [ -f $SCRIPT_PATH/../dev/core/media/src/Facades/RvMedia.php ]; then
  $RM -f $SCRIPT_PATH/../dev/core/media/src/Facades/AppMediaFacade.php
  (LC_ALL=C $MV $SCRIPT_PATH/../dev/core/media/src/Facades/RvMedia.php $SCRIPT_PATH/../dev/core/media/src/Facades/AppMedia.php)
  echo -e "$BLUE Renamed Facades/RvMedia > Facades/AppMedia $NORMAL"
else
  echo -e "$COL_RED Could not found Facades/RvMedia $NORMAL"
fi
## END REMOVE RV MEDIA

## ABSOLUTE PATH PROCESSING
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/core/\`dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/plugins/\`dev\/plugins/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/core/\`dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/plugins/\`dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/themes/\`dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/packages/\`dev\/libs/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe "s/'packages'/'libs'/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/platform\/\$/dev\/\$/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/\$/dev\/\$/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/platform\/\*/dev\/\*/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.yml' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.yml' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.yml' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.yml' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')

## do not move below line's position
if [ -d $SCRIPT_PATH/../dev/libs/dev-tool ]; then
  ($CD $SCRIPT_PATH/../dev/libs/dev-tool && LC_ALL=C $FIND $SCRIPT_PATH/../dev/libs/dev-tool -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/'packages'/'libs'/g")
else
  echo -e "$COL_RED Could not found packages $NORMAL"
fi
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/packages\/theme/libs\/theme/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/packages\/data-synchronize/libs\/data-synchronize/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/packages\/api/libs\/api/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/'packages\./'libs./g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe "s/'packages\//'libs\//g")

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe "s/packages\/theme/libs\/theme/g")
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/platform\/core/dev\/core/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/platform\/plugins/dev\/plugins/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/platform\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/platform\/packages/dev\/libs/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.md' -print0 | xargs -0 $PERL -i -pe 's/botble\/dev-tool/dev\/dev-tool/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/public\/themes/public\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/botble\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/dev\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/vendor\/themes/vendor\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/vendor\/packages/vendor\/libs/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/vendor\/core\/packages/vendor\/core\/libs/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/public\/themes/public\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev\/themes/dev\/ui/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'themes'/'ui'/g" $SCRIPT_PATH/../dev/libs/theme/config/general.php)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/\('themes/\('ui/g" $SCRIPT_PATH/../dev/libs/theme/helpers/helpers.php)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/\('themes/\('ui/g" $SCRIPT_PATH/../dev/libs/theme/src/Manager.php)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/\('themes/\('ui/g" $SCRIPT_PATH/../dev/libs/theme/src/Services/ThemeService.php)

($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/\`platform\/themes/\`dev\/ui/g' $SCRIPT_PATH/../webpack.mix.js)
($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'themes'/'ui'/g" $SCRIPT_PATH/../webpack.mix.js)

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/public\/themes/public\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/dev\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/vendor\/core\/packages/vendor\/core\/libs/g')

($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/botble\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/dev\/themes/dev\/ui/g')
($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.stub' -print0 | xargs -0 $PERL -i -pe 's/public\/themes/public\/ui/g')

if [ -f $SCRIPT_PATH/../dev/core/base/src/Traits/LoadAndPublishDataTrait.php ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/platform\//dev\//g' $SCRIPT_PATH/../dev/core/base/src/Traits/LoadAndPublishDataTrait.php)
else
  echo -e "$COL_RED Could not found LoadAndPublishDataTrait.php $NORMAL"
fi

if [ -f $SCRIPT_PATH/../dev/core/base/helpers/common.php ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'platform'/'dev'/g" $SCRIPT_PATH/../dev/core/base/helpers/common.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'packages'/'libs'/g" $SCRIPT_PATH/../dev/core/base/helpers/common.php)
else
  echo -e "$COL_RED Could not found dev/core/base/helpers/common.php $NORMAL"
fi

if [ -f $SCRIPT_PATH/../dev/core/acl/src/Models/Role.php ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'packages'/'libs'/g" $SCRIPT_PATH/../dev/core/acl/src/Models/Role.php)
else
  echo -e "$COL_RED Could not found dev/core/acl/src/Models/Role.php $NORMAL"
fi

if [ -f $SCRIPT_PATH/../dev/core/base/src/Supports/Helper.php ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe "s/'packages'/'libs'/g" $SCRIPT_PATH/../dev/core/base/src/Supports/Helper.php)
else
  echo -e "$COL_RED Could not found dev/core/base/src/Supports/Helper.php $NORMAL"
fi

if [ -f $SCRIPT_PATH/../dev/libs/assets/config/assets.php ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/packages\/bootstrap\/css\/bootstrap.min.css/public\/ui\/master\/plugins\/bootstrap\/css\/bootstrap.min.css/g' $SCRIPT_PATH/../dev/libs/assets/config/assets.php)
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/vendor\/core\/packages\/modernizr\/modernizr.min.js/public\/vendor\/core\/core\/base\/libraries\/modernizr\/modernizr.min.js/g' $SCRIPT_PATH/../dev/libs/assets/config/assets.php)
else
  echo -e "$COL_RED Could not found assets.php $NORMAL"
fi

if [ -d $SCRIPT_PATH/../dev/packages ]; then
  $RM -rf $SCRIPT_PATH/../dev/libs && (LC_ALL=C $MV $SCRIPT_PATH/../dev/packages $SCRIPT_PATH/../dev/libs)
  echo -e "$BLUE Renamed packages > libs $NORMAL"
else
  echo -e "$COL_RED Could not found packages $NORMAL"
fi
## END ABSOLUTE PATH PROCESSING

echo -e "$COL_RED BEGIN THEME GENERAL PROCESSING $NORMAL"
## 1. BEGIN THEME GENERAL PROCESSING
if [ -d $SCRIPT_PATH/../lang/vendor/packages ]; then
  echo -e "$BLUE The 'lang/vendor/packages' is existed, renaming lang/vendor/packages to lang/vendor/libs $NORMAL"
  $RM -rf $SCRIPT_PATH/../lang/vendor/libs && (LC_ALL=C $MV $SCRIPT_PATH/../lang/vendor/packages $SCRIPT_PATH/../lang/vendor/libs)
  echo -e "$BLUE Renamed lang:vendor/packages > lang:vendor/libs $NORMAL"
else
  echo -e "$COL_RED Could not found public:vendor/packages $NORMAL"
fi
if [ -d $SCRIPT_PATH/../public/vendor/core/packages ]; then
  echo -e "$BLUE The 'public/vendor/core/packages' is existed, renaming public/vendor/core/packages to public/vendor/core/libs $NORMAL"
  $RM -rf $SCRIPT_PATH/../public/vendor/core/libs && (LC_ALL=C $MV $SCRIPT_PATH/../public/vendor/core/packages $SCRIPT_PATH/../public/vendor/core/libs)
  echo -e "$BLUE Renamed public:vendor/core/packages > public:vendor/core/libs $NORMAL"
else
  echo -e "$COL_RED Could not found public:vendor/core/packages $NORMAL"
fi

if [ -d $SCRIPT_PATH/../public/themes ]; then
  echo -e "$BLUE The 'public/themes' is existed, renaming public/themes to public/ui $NORMAL"
  $RM -rf $SCRIPT_PATH/../public/ui && (LC_ALL=C $MV $SCRIPT_PATH/../public/themes $SCRIPT_PATH/../public/ui)
  echo -e "$BLUE Renamed public:themes > public:ui $NORMAL"
else
  echo -e "$COL_RED Could not found public:themes $NORMAL"
fi
if [ -d $SCRIPT_PATH/../dev/themes ]; then
  echo -e "$BLUE The 'dev/themes' is existed, remove dev/ui first then renaming dev/themes to dev/ui $NORMAL"
  $RM -rf $SCRIPT_PATH/../dev/ui && (LC_ALL=C $MV $SCRIPT_PATH/../dev/themes $SCRIPT_PATH/../dev/ui)
  echo -e "$BLUE Renamed dev:themes > dev:ui $NORMAL"
else
  echo -e "$COL_RED Could not found dev:themes $NORMAL"
fi

if [ -d $SCRIPT_PATH/../dev/ui ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/package\/theme/libs\/theme/g')

  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/botble\/themes/dev\/ui/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/dev\/themes/dev\/ui/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`public\/themes/\`public\/ui/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/\`platform\/themes/\`dev\/ui/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/themes/ui/g')

else
  echo -e "$COL_RED Could not found dev/ui $NORMAL"
fi
## END THEME GENERAL PROCESSING

## 1.1 BEGIN RENAME THEME RIPPLE
if [ -d $SCRIPT_PATH/../public/*/ripple ]; then
  echo -e "$BLUE The 'public/*/ripple' is existed, remove public/*/master first then renaming public/*/ripple to public/*/master $NORMAL"
  $RM -rf $SCRIPT_PATH/../public/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/ripple $SCRIPT_PATH/../public/ui/master)
  echo -e "$BLUE Renamed public:ui:ripple > public:ui:master $NORMAL"
else
  echo -e "$COL_RED Could not found public/*/ripple $NORMAL"
fi

if [ -d $SCRIPT_PATH/../dev/*/ripple ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/ripple/dev\/master/g')
  if [ -f "$SCRIPT_PATH/../database.sql" ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/ripple/master/g' $SCRIPT_PATH/../database.sql)
  else
    echo -e "$COL_RED Could not found database.sql $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/*/ripple ]; then
    echo -e "$BLUE The 'dev/*/ripple' is existed, remove dev/*/master and renaming dev/*/ripple to dev/*/master $NORMAL"
    $RM -rf $SCRIPT_PATH/../dev/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/ripple $SCRIPT_PATH/../dev/ui/master)
    echo -e "$BLUE Renamed dev:ui:ripple > dev:ui:master $NORMAL"
  else
    echo -e "$COL_RED Could not found dev:*:ripple $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/ui ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/ripple/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev\/ripple/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Ripple\\/Master\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Ripple/Master/g')

    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Ripple\\/Master\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Ripple/Master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/ripple.js/master.js/g')

    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Ripple/Master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/ripple.js/master.js/g')

    ###
    if [ -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/RippleController.php ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/RippleController.php $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php)
      echo -e "$BLUE Renamed RippleController > MasterController $NORMAL"
    else
      echo -e "$COL_RED Could not found RippleController $NORMAL"
    fi
    ###

    if [ -f $SCRIPT_PATH/../dev/ui/master/public/js/ripple.js ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/public/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/public/js/ripple.js $SCRIPT_PATH/../dev/ui/master/public/js/master.js)
      echo -e "$BLUE Renamed ripple.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi

    if [ -f $SCRIPT_PATH/../public/ui/master/js/ripple.js ]; then
      $RM -f $SCRIPT_PATH/../public/ui/master/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/master/js/ripple.js $SCRIPT_PATH/../public/ui/master/js/master.js)
      echo -e "$BLUE Renamed ripple.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi
  else
    echo -e "$COL_RED Could not found dev/ui $NORMAL"
  fi
else
  echo -e "$COL_RED Could not found dev/*/ripple $NORMAL"
fi
## END RENAME THEME RIPPLE

## 1.2 BEGIN RENAME THEME SHOPWISE
if [ -d $SCRIPT_PATH/../public/*/shopwise ]; then
  echo -e "$BLUE The 'public/*/shopwise' is existed, remove public/*/master first then renaming public/*/shopwise to public/*/master $NORMAL"
  $RM -rf $SCRIPT_PATH/../public/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/shopwise $SCRIPT_PATH/../public/ui/master)
  echo -e "$BLUE Renamed public:ui:shopwise > public:ui:master $NORMAL"
else
  echo -e "$COL_RED Could not found public/*/shopwise $NORMAL"
fi

if [ -d $SCRIPT_PATH/../dev/*/shopwise ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/shopwise/dev\/master/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/Shopwise/Master/g')
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../ -type f -name '*.scss' -print0 | xargs -0 $PERL -i -pe 's/Bestwebcreator/Master/g')

  if [ -f "$SCRIPT_PATH/../database.sql" ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/-shopwise-/-master-/g' $SCRIPT_PATH/../database.sql)
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Shopwise/Master/g' $SCRIPT_PATH/../database.sql)
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/shopwise/master/g' $SCRIPT_PATH/../database.sql)
  else
    echo -e "$COL_RED Could not found database.sql $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/*/shopwise ]; then
    echo -e "$BLUE The 'dev/*/shopwise' is existed, remove dev/*/master and renaming dev/*/shopwise to dev/*/master $NORMAL"
    $RM -rf $SCRIPT_PATH/../dev/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/shopwise $SCRIPT_PATH/../dev/ui/master)
    echo -e "$BLUE Renamed dev:ui:shopwise > dev:ui:master $NORMAL"
  else
    echo -e "$COL_RED Could not found dev:*:shopwise $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/ui ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/shopwise/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev\/shopwise/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Shopwise\\/Master\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Shopwise/Master/g')

    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Shopwise\\/Master\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Shopwise/Master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/shopwise.js/master.js/g')

    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/Shopwise/Master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/shopwise.js/master.js/g')

    ###
    if [ -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/ShopwiseController.php ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/ShopwiseController.php $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php)
      echo -e "$BLUE Renamed ShopwiseController > MasterController $NORMAL"
    else
      echo -e "$COL_RED Could not found ShopwiseController $NORMAL"
    fi
    ###

    if [ -f $SCRIPT_PATH/../dev/ui/master/public/js/shopwise.js ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/public/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/public/js/shopwise.js $SCRIPT_PATH/../dev/ui/master/public/js/master.js)
      echo -e "$BLUE Renamed shopwise.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi

    if [ -f $SCRIPT_PATH/../public/ui/master/js/shopwise.js ]; then
      $RM -f $SCRIPT_PATH/../public/ui/master/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/master/js/shopwise.js $SCRIPT_PATH/../public/ui/master/js/master.js)
      echo -e "$BLUE Renamed shopwise.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi
  else
    echo -e "$COL_RED Could not found packages $NORMAL"
  fi
else
  echo -e "$COL_RED Could not found dev/*/shopwise $NORMAL"
fi
## END RENAME THEME SHOPWISE

## 1.3 BEGIN RENAME THEME FLEXHOME
if [ -d $SCRIPT_PATH/../public/*/flex\-home ]; then
  echo -e "$BLUE The 'public/*/flex-home' is existed, remove public/*/master first then renaming public/*/flex-home to public/*/master $NORMAL"
  $RM -rf $SCRIPT_PATH/../public/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/flex-home $SCRIPT_PATH/../public/ui/master)
  echo -e "$BLUE Renamed public:ui:flex-home > public:ui:master $NORMAL"
else
  echo -e "$COL_RED Could not found public/*/flex-home $NORMAL"
fi
if [ -d $SCRIPT_PATH/../dev/*/flex\-home ]; then
  ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/flex-home/dev\/master/g')

  if [ -f "$SCRIPT_PATH/../database.sql" ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/flex-home/master/g' $SCRIPT_PATH/../database.sql)
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $PERL -i -pe 's/Flex Home/Shop Zone/g' $SCRIPT_PATH/../database.sql)
  else
    echo -e "$COL_RED Could not found database.sql $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/*/flex\-home ]; then
    echo -e "$BLUE The 'dev/*/flex-home' is existed, remove dev/*/master and renaming dev/*/flex-home to dev/*/master $NORMAL"
    $RM -rf $SCRIPT_PATH/../dev/ui/master && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/flex-home $SCRIPT_PATH/../dev/ui/master)
    echo -e "$BLUE Renamed dev:ui:flex-home > dev:ui:master $NORMAL"
  else
    echo -e "$COL_RED Could not found dev:ui:flex-home $NORMAL"
  fi

  if [ -d $SCRIPT_PATH/../dev/ui ]; then
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/botble\/flex-home/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/dev\/flex-home/dev\/master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/FlexHome\\\\/Master\\\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.json' -print0 | xargs -0 $PERL -i -pe 's/Flex Home/Shop Zone/g')

    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FlexHome\\\\/Master\\\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FlexHome\\/Master\\/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/FlexHome/Master/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/Flex Home/Shop Zone/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.php' -print0 | xargs -0 $PERL -i -pe 's/flex-home.js/master.js/g')
    ($CD $SCRIPT_PATH/../ && LC_ALL=C $FIND $SCRIPT_PATH/../dev/ui/ -type f -name '*.js' -print0 | xargs -0 $PERL -i -pe 's/flex-home.js/master.js/g')

    ###
    if [ -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/FlexHomeController.php ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/FlexHomeController.php $SCRIPT_PATH/../dev/ui/master/src/Http/Controllers/MasterController.php)
      echo -e "$BLUE Renamed FlexHomeController > MasterController $NORMAL"
    else
      echo -e "$COL_RED Could not found FlexHomeController $NORMAL"
    fi
    ###

    if [ -f $SCRIPT_PATH/../dev/ui/master/public/js/flex-home.js ]; then
      $RM -f $SCRIPT_PATH/../dev/ui/master/public/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../dev/ui/master/public/js/flex-home.js $SCRIPT_PATH/../dev/ui/master/public/js/master.js)
      echo -e "$BLUE Renamed flex-home.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi

    if [ -f $SCRIPT_PATH/../public/ui/master/js/flex-home.js ]; then
      $RM -f $SCRIPT_PATH/../public/ui/master/js/master.js && (LC_ALL=C $MV $SCRIPT_PATH/../public/ui/master/js/flex-home.js $SCRIPT_PATH/../public/ui/master/js/master.js)
      echo -e "$BLUE Renamed flex-home.js > master.js $NORMAL"
    else
      echo -e "$COL_RED Could not found master $NORMAL"
    fi
  else
    echo -e "$COL_RED Could not found packages $NORMAL"
  fi
else
  echo -e "$COL_RED Could not found dev/*/flex-home $NORMAL"
fi
## END RENAME THEME FLEXHOME

## ($CD $SCRIPT_PATH/../ && LC_ALL=C $ZIP -r botble.zip . -x \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.md \*.MD \*.log \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat bin/delivery.sh bin/remove-botble.sh readme.html composer.lock wp-config.secure.php \*.yml\* \*.editorconfig\* \*.rnd\*)

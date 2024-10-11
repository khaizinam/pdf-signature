Git global setup
====

```
git config --global user.name "Gitlab"
git config --global user.email "gitlab@visualweber.net"
git config --get core.excludesfile # to show global excludes files by default
```

* Ignore Symbolic links

`find . -type l | sed -e s'/^\.\///g' >> .gitignore`

Create a new repository
====

```
We using develop as default branch
git clone ssh://git@git.visualweber.net:1506/viweb-dev/celesta.git -b develop
cd /home/dev/htdocs/celesta/
touch README.md
git add README.md
git commit -m "add README"
git push -u origin master
```

Existing folder or Git repository
====

```
cd /home/dev/htdocs/celesta/
git init
git remote add origin ssh://git@git.visualweber.net:1506/viweb-dev/celesta.git
git fetch --all
git checkout develop
git add .
git commit -am "your comment here"
git push -u origin master
```

Find and restore a deleted file/folder in a Git repository
====

https://stackoverflow.com/questions/953481/find-and-restore-a-deleted-file-in-a-git-repository
https://stackoverflow.com/questions/30875205/restore-a-deleted-folder-in-a-git-repo

Find the last commit that affected the given path. As the file isn't in the HEAD commit, this commit must have deleted it.
`git rev-list -n 1 HEAD -- <file_path>`

Then checkout the version at the commit before, using the caret (^) symbol:
`git checkout <deleting_commit>^ -- <file_path>`

Or in one command, if $file is the file in question.
`git checkout $(git rev-list -n 1 HEAD -- "$file")^ -- "$file"`

Example:
`git checkout 1e0eab3^ -- library/Entity/Connector.php`
`git checkout COMMIT_ID -- path/to/deleted/folder`

Create Project In Redmine
===

```
curl -v -user "username:password -H "Content-Type: application/json" -X POST -d '{"project": {"name": "your project name", "identifier":"project-identifier", "description":"project description if need"} }' https://redmine.visualweber.net/projects.xml
curl -v -H "X-Redmine-API-Key: $REDMINE_API_KEY" -X POST -H "Content-Type: application/json" https://redmine.visualweber.net/projects.xml -d '{"project": {"name": "$PROJECT_NAME", "identifier":"$PROJECT_IDENTIFIER"} }'
```

Setup vHost (Apache)
====

OR Quick running with `php -S localhost:8000 -t public`
Then, just access with this link: `http://localhost:8000`

```
<VirtualHost *:80>
    ServerAdmin admin@celesta.gistensal.com
    ServerName celesta.gistensal.com
    ServerAlias www.celesta.gistensal.com
    SetEnv APPLICATION_ENV "development"
    SetEnv ENVIRONMENT "development"
    SetEnv ENV "development"

    ErrorLog "/home/dev/logs/celesta-error_log"
    DocumentRoot "/home/dev/htdocs/celesta/"
    <Directory "/home/dev/htdocs/celesta/">
        Options ExecCGI FollowSymLinks
        AllowOverride all
        Allow from all
        Order allow,deny
    </Directory>
</VirtualHost>
```
Or

```
<VirtualHost *:443>
    ServerAdmin admin@celesta.gistensal.com
    ServerName celesta.gistensal.com
    ServerAlias www.celesta.gistensal.com
    SetEnv APPLICATION_ENV "development"
    SetEnv ENVIRONMENT "development"
    SetEnv ENV "development"

    ErrorLog "/home/dev/logs/celesta-error_log"
    DocumentRoot "/home/dev/htdocs/celesta/"
    SSLEngine On
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
    # SSLCertificateFile "/etc/letsencrypt/live/jobsin.asia/fullchain.pem"
    # SSLCertificateKeyFile "/etc/letsencrypt/live/jobsin.asia/privkey.pem"

    ## Reserve Proxy
    # ProxyRequests off
    # SSLProxyEngine on
    # ProxyPreserveHost on
    # RewriteCond %{REQUEST_URI}  ^/socket.io            [NC]
    # RewriteCond %{QUERY_STRING} transport=polling    [NC]
    # RewriteCond %{QUERY_STRING} transport=websocket  [NC]
    # RewriteRule /(.*)$  http://127.0.0.1:6000/$1 [P,L]
    # <Location /socket.io>
    #     ProxyPass        https://127.0.0.1:6000/socket.io
    #     ProxyPassReverse https://127.0.0.1:6000/socket.io
    # </Location>

    <Directory "/home/dev/htdocs/celesta/">
        Options All
        AllowOverride All
        order allow,deny
        allow from all
    </Directory>
</VirtualHost>
```

Project information
====

##### Domain: http://celesta.gistensal.com or https://celesta.gistensal.com

```
HTTP Authentication
- Username: default
- Password: default
```

##### HOME DIRECTORY & DELIVERY

`/home/dev/htdocs/celesta/`

Just run this file, then you will have the delivery files

```
$ bash /home/dev/htdocs/celesta/delivery.sh
```

- http://celesta.gistensal.com/celesta.zip
- http://celesta.gistensal.com/celesta.sql
- Done!

##### Mysql Database: http://visualweber.net/pma

```
- Mysql Host: 127.0.0.1
- Mysql DB default user: dev (do not use)
- Mysql DB default password: ******** (do not use)

- Mysql DB Name: dev_celestarise_home
- Mysql DB User: userdb.dev.celestarise_home
- Mysql DB Password: B1hgYtu5Nikl0bcE
```
##### MongoDB Database:

```
- Mongo DB Name: dev_celestarise_home
- Mongo DB User: userdb.dev.celestarise_home
- Mongo DB Password: B1hgYtu5Nikl0bcE
```

##### SMTP settings (General projects):
```
- SMTP account: f08816f9ad7b71
- SMTP App password: 966c936e2f2605
- SMTP Port: 2525
- SMTP ENCRYPTION: uncomment
- SMTP Server: smtp.mailtrap.io or ssl://smtp.mailtrap.io:465

Example
# MAIL_DRIVER=smtp
# MAIL_HOST=smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=f08816f9ad7b71
# MAIL_PASSWORD=966c936e2f2605
# ## MAIL_ENCRYPTION=ssl # uncomment
# MAIL_FROM_NAME="Viweb Developer"
# MAIL_FROM_ADDRESS="dev@visualweber.com"
# MAIL_SUBJECT="Mail from Viweb Developer"


OR

- SMTP account: cs.team.services@gmail.com
- SMTP App password: jupjrbzghbeybcae
- SMTP Port: 587 (TLS) / 465 (SSL)
- SMTP Server: smtp.gmail.com or ssl://smtp.gmail.com:465
```
OR

```
- SMTP account: cs.team.services1@gmail.com
- SMTP App password: mzvdhdouendopscw
- SMTP Port: 587 (TLS) / 465 (SSL)
- SMTP Server: smtp.gmail.com or ssl://smtp.gmail.com:465
```

Tutorial dapp with Solidity, Truffle, Web3 and Javascript
===

### Install and Deploy your first contract
Tutorial dapp with Solidity, Truffle, Web3 and Javascript

#### Install environment
1. Install truffle (truffle is a solidity framework support to write a smart contract)
2. Truffle instruction: https://truffleframework.com/docs
3. Install personal ethereum blockchain
- 3.1 "Ganache" (or you can use testrpc), https://truffleframework.com/docs/ganache/using
- 3.2 TestRPC: npm install -g ethereumjs-testrpc then just type "testrpc" from your commandline interface.
4. Install pet-shop tutorials
- https://www.youtube.com/watch?v=9FYGSYZSJYg
- https://truffleframework.com/tutorials/pet-shop
5. Write your code follow above example
6. Compile your code with truffle command-line : "truffle compile"
7. Write your migration script to deployment contracts
8. Migration. After you have successfully compiled your contract. lets migrate them to the blockchain with "truffle migrate"
9. Continue with pet-shop.
10. Run webserver with nodejs application, navigate to ./src (see the port), type "npm run dev". Automatically open browser with localhost:3000
11. Try to "adopt" something and open Ganache client to see the transaction.
12. Thats it.

#### Best practices
1. If you want to rebuild, you have to remove ./build/contracts/**
` rm -Rf ./build/contracts/* && clear && truffle compile && truffle migrate --network development -f 1 --reset `
2. Specific an account to deploy your contract, need to unlock first.

```
truffle.js
module.exports = {
  // See <http://truffleframework.com/docs/advanced/configuration>
  // for more about customizing your Truffle configuration!
  networks: {
    development: {
      host: "127.0.0.1",
      port: 8545,
      network_id: "*" // Match any network id
    },
    vultr: {
      host: "127.0.0.1",
      port: 8545,
      network_id: "*", // Match any network id
      from: "0xd41CcE67AA90B169bfA8857c83F859206572e1DA" // Unlocked Address
    }
  }
};
```

#### Results:

```
Anonymouss-MacBook-Pro:pet-shop Anonymous$ truffle compile
Compiling ./contracts/JAsiaToken.sol...
Compiling ./contracts/Migrations.sol...
Writing artifacts to ./build/contracts
```
```
Anonymouss-MacBook-Pro:pet-shop Anonymous$truffle migrate
Using network 'development'.

Running migration: 1_initial_migration.js
  Deploying Migrations...
  ... 0x87d45bec405950afe56767afd3f4962cc8aaa080c07cf5fe095207a92abb0572
  Migrations: 0x0df79d8469f4403c8b207558b87934d9c37ffb9f
Saving successful migration to network...
  ... 0x099bfb9133ddeabab1c008edda31801ac5488d14e43183e20e9a8674ff433622
Saving artifacts...
Running migration: 2_deploy_contracts.js
  Deploying JAsiaToken...
  ... 0x4745c03f4fc7c794cc1a9d09161a821f20c0bfe88bda2249eea5813a76d99c81
  JAsiaToken: 0x89ad31cbfe79ef733e63895a3dfa3370b70132dd
Saving successful migration to network...
  ... 0xf27df9f06d89ea3f77248f678d2731ca7d7d1b8d2e7a7620c2149dc509536e8b
Saving artifacts...
```
```
vultr server
truffle migrate --network vultr
Using network 'vultr'.

Running migration: 1_initial_migration.js
  Deploying Migrations...
  ... 0x083122d531621867c6cb81b09f577839c6b57006374f9050baa711a9df425600
  Migrations: 0x6ea657475cc17f44af60e9ba40fec6aa16e963a2
Saving successful migration to network...
  ... 0xd9001880b10a781bf39178679b0c33bc6ceeab1dd585749bf909769a74e19750
Saving artifacts...
Running migration: 2_deploy_contracts.js
  Deploying Adoption...
  ... 0x603f196d7fa146c8adc3f92c6d42494aa38948624b8952142503f826fb9d37aa
  Adoption: 0xdae66a0f166974a68166408174b4ee0e23246ba4
Saving successful migration to network...
  ... 0xd1067adff4f4d3ae3c098b38c255d8403239a802062b9a50c7a805401efc152c
Saving artifacts...
root@vultr:/var/www/html/contracts/pet-shop#
```

### Website references
#### CoinVest Channel

### Solidity basically:
1. https://solidity.readthedocs.io/en/develop/index.html

### Best practices & example channel
- https://www.reddit.com/r/Coinvest/
- https://medium.com/@CoinvestHQ
- https://github.com/CoinvestHQ
- https://github.com/chiro-hiro/part-time-dapp
- https://github.com/MineFIL/mfil-erc20-smart-contract
- https://github.com/adilharis2001/ERC865Demo
- https://www.youtube.com/watch?v=3e_P5OdMMdM&feature=youtu.be
- https://github.com/ethereum/EIPs/issues/865
- https://medium.com/@CoinvestHQ/coinvest-token-swap-strategy-and-details-788112cff35
- https://medium.com/@CoinvestHQ/coin-protocol-and-smart-contracts-v2-0-d69a44eea538
- https://ethereum.stackexchange.com/questions/10160/truffle-migrations-account-locked-error-with-network-command
- https://medium.com/coinmonks/transfer-ethereum-tokens-without-ether-an-erc20-improvement-to-seriously-consider-90bebd447bb
- https://github.com/ethereum/EIPs/issues/865
- ---> ERC20 token smart contract that implement the BokkyPooBah's Token Teleportation Service (BTTS) interface provides Ethereum accounts with the ability to transfer the ERC20 tokens without having to pay for the Ethereum network transaction fees in ethers (ETH). Instead, the account pays for the token transfer fees in the token being transferred https://github.com/bokkypoobah/BokkyPooBahsTokenTeleportationServiceSmartContract/blob/master/contracts/BTTSTokenFactory.sol#L365-L395
- https://github.com/bokkypoobah/MakerDAOSaiContractAudit/blob/master/DEVELOPING.md

### Demo transfer erc20 token withouts ether:
- https://etherless.coinve.st/
- http://www.cryptocentral.info/topic/2097/coinvest-the-world-s-first-decentralized-investment-trading-market-for-cryptocurrencies/16
- http://www.cryptocentral.info/topic/2097/coinvest-the-world-s-first-decentralized-investment-trading-market-for-cryptocurrencies
- https://github.com/RobertMCForster/CoinvestV2Audit

SETUP Facebook Webhook step by step
===

-  https://developers.facebook.com/docs/graph-api/webhooks/getting-started
-  Important: https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration/
-  https://developers.facebook.com/docs/marketing-api/guides/lead-ads/testing-troubleshooting#debug-real-time-update-integration
-  https://developers.facebook.com/tools/lead-ads-testing

- 1: Set up your FB Application
- 2: Create Webhook URL: https://domain.com/web-hook-uri
- 3: Make the api call to create subscription
  ```
  Ref: https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration/
  Ex: curl -F "object=page" -F "callback_url=<https://www.yourcallbackurl.com>" -F "fields=leadgen" -F "verify_token=abc123" -F "access_token=<APP_ACCESS_TOKEN>" "https://graph.facebook.com/<API_VERSION>/<APP_ID>/subscriptions"
  Ex: curl -F "object=page" -F "callback_url=https://facebook-sync.visualweber.net/facebook-webhook/706933179695177" -F "fields=leadgen" -F "verify_token=706933179695177" -F "access_token=706933179695177|_T4BHS1AlVH-HHQJAVPtUllzT0E"  "https://graph.facebook.com/v2.11/706933179695177/subscriptions"
  ```
- 4: Subscribe the Page to Your App
  - 4.1
  ```
  Ref: https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration/
  Ex: curl -F "access_token=<PAGE_ACCESS_TOKEN>" "https://graph.facebook.com/<API_VERSION>/<PAGE_ID>/subscribed_apps"
  Ex: curl -F "access_token=EAAFIXUXYJlQBANWVZBnVHPdcnZBiUSu99GZAIPXISdjRrI84VZAiispZA7odOeRjzcccgNFOeo1O0DIIJHhU4mZCopZBZA3Qg1upkuGXVs6cMI6HtS4d0UZCajZCIeWgAzZB9fh611S4V5IM6HqkW8SiRGuX6ZCidrQDVtapmHUWxmSK4AZDZD" "https://graph.facebook.com/v2.11/510457199292268/subscribed_apps"
  ```
  - 4.2 Verify the Subscription
  ```
  Ex: curl  -G -d "access_token=EAAFIXUXYJlQBANWVZBnVHPdcnZBiUSu99GZAIPXISdjRrI84VZAiispZA7odOeRjzcccgNFOeo1O0DIIJHhU4mZCopZBZA3Qg1upkuGXVs6cMI6HtS4d0UZCajZCIeWgAzZB9fh611S4V5IM6HqkW8SiRGuX6ZCidrQDVtapmHUWxmSK4AZDZD" "https://graph.facebook.com/v2.11/510457199292268/subscribed_apps"
  ```
- 5: For coding: Setup some API and Secret Keys as below, please read the source code.

How to Build APK (debug vs release) and IPA (debug)
===
##### Clean all cached and re-install node_modules

- 1: `rm -rf node_modules && rm -rf ~/.rncache/* && yarn && npm install`
- 2: `rm -fr $TMPDIR/react-*`
- 3: `react-native link`

OR

```
watchman watch-del-all; rm -rf ios/build; kill $(lsof -t -i:8081); rm -rf ios/build; rm -rf android/build; rm -rf android/app/build; rm -rf $TMPDIR/react* ; rm -f ios/main.jsbundle; rm -rf node_modules; rm -rf ~/.rncache/* && yarn; npm cache verify; npm install; rm -fr $TMPDIR/react-*; react-native link; rm -f yarn.lock || true; yarn cache clean;
```

`https://www.youtube.com/watch?v=8lDYD1nJlFw&index=1&list=PLSOI0fqCqm70DpwGtf3IQxcvnLKr9pW4R`

##### Build Android (APK)
- Notes: If you can not build with commandline, you should install Android Studio.

- 1. Goto `ROOT/android/`, type command : `gradlew clean` or `./gradlew clean`
- 2. Goto `ROOT/`, type :
- 3. `react-native bundle --dev false --platform android --entry-file index.android.js --bundle-output ./android/app/build/intermediates/assets/debug/index.android.bundle --assets-dest ./android/app/build/intermediates/res/merged/debug`
- 4. Or try with `react-native bundle --platform android --dev false --entry-file index.android.js --bundle-output android/app/src/main/assets/index.android.bundle --sourcemap-output android/app/src/main/assets/index.android.map --assets-dest android/app/src/main/res/`
- 5. Waiting for completed, then, lead to android folder, and type as number #6 or #7, it s belong to your purpose:
- 6. Goto `ROOT/android/` type command : `gradlew assembleDebug` or `./gradlew assembleDebug`
- 7. Or build for release : `gradlew assembleRelease` or `./gradlew assembleRelease`
- 8. After that, you will have a APK file in `ROOT/android/app/build/outputs/apk`

##### Build iOS (IPA)
- 1. Register an Apple account, create App Ids, Certificates, Provisioning Profiles, Devices, ...
- 2. Modifye `AppDelegate.m` (if need): `jsCodeLocation = [[NSBundle mainBundle] URLForResource:@"main" withExtension:@"jsbundle"];`
- 3. Run this command before build: `react-native bundle --entry-file index.ios.js --platform ios --dev false --bundle-output ios/main.jsbundle --assets-dest ios`
- 4. OR `rm -rf node_modules && npm install && rm -fr $TMPDIR/react-* && react-native link && react-native bundle --entry-file index.ios.js --platform ios --dev false --bundle-output ios/main.jsbundle --assets-dest ios`
- 5. Archive with XCode
- 6. Done

Letscrypt Installation
===
`https://www.digitalocean.com/community/tutorials/how-to-secure-nginx-with-let-s-encrypt-on-centos-7`

##### Remove a Certificate
```
/usr/bin/certbot delete --cert-name celesta.gistensal.com
```

##### Installing the Certbot Let's Encrypt Client
- Once the repository has been enabled, you can obtain the certbot-nginx package by typing:
`sudo yum install certbot-nginx`
- The certbot Let's Encrypt client is now installed and ready to use.

##### Obtaining a Certificate
- Certbot provides a variety of ways to obtain SSL certificates, through various plugins. The Nginx plugin will take care of reconfiguring Nginx and reloading the config whenever necessary:

```
/usr/bin/certbot renew --pre-hook "service nginx stop" --post-hook "service nginx start" --quiet
```

```
sudo certbot --authenticator standalone --installer nginx -d celesta.gistensal.com -d www.celesta.gistensal.com --pre-hook "service nginx stop" --post-hook "service nginx start"
```

- This runs certbot with the --nginx plugin, using -d to specify the names we'd like the certificate to be valid for.
- If this is your first time running certbot, you will be prompted to enter an email address and agree to the terms of service. After doing so, certbot will communicate with the Let's Encrypt server, then run a challenge to verify that you control the domain you're requesting a certificate for.
-If that's successful, certbot will ask how you'd like to configure your HTTPS settings:

```
Output
Please choose whether HTTPS access is required or optional.
-------------------------------------------------------------------------------
1: Easy - Allow both HTTP and HTTPS access to these sites
2: Secure - Make all requests redirect to secure HTTPS access
-------------------------------------------------------------------------------
Select the appropriate number [1-2] then [enter] (press 'c' to cancel):
```

- Select your choice then hit ENTER. The configuration will be updated, and Nginx will reload to pick up the new settings. certbot will wrap up with a message telling you the process was successful and where your certificates are stored:

```
Output
IMPORTANT NOTES:
 - Congratulations! Your certificate and chain have been saved at
   /etc/letsencrypt/live/celesta.gistensal.com/fullchain.pem. Your cert will
   expire on 2017-10-23. To obtain a new or tweaked version of this
   certificate in the future, simply run certbot again with the
   "certonly" option. To non-interactively renew *all* of your
   certificates, run "certbot renew"
 - Your account credentials have been saved in your Certbot
   configuration directory at /etc/letsencrypt. You should make a
   secure backup of this folder now. This configuration directory will
   also contain certificates and private keys obtained by Certbot so
   making regular backups of this folder is ideal.
 - If you like Certbot, please consider supporting our work by:

   Donating to ISRG / Let's Encrypt:   https://letsencrypt.org/donate
   Donating to EFF:                    https://eff.org/donate-le
```

- Your certificates are downloaded, installed, and loaded. Try reloading your website using https:// and notice your browser's security indicator. It should represent that the site is properly secured, usually with a green lock icon.

##### Updating Diffie-Hellman Parameters
- If you test your server using the SSL Labs Server Test now, it will only get a B grade due to weak Diffie-Hellman parameters. This effects the security of the initial key exchange between our server and its users. We can fix this by creating a new dhparam.pem file and adding it to our server block.
- Create the file using openssl: `sudo openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048`

##### LetsEncrypt Setting Up Auto Renewal
`sudo crontab -e`

```
. . .
15 3 * * * /usr/bin/certbot renew --pre-hook "service nginx stop" --post-hook "service nginx start" --quiet
```
- The 15 3 * * * part of this line means "run the following command at 3:15 am, every day". You may choose any time.
- The renew command for Certbot will check all certificates installed on the system and update any that are set to expire in less than thirty days. --quiet tells Certbot not to output information or wait for user input.
- cron will now run this command daily. All installed certificates will be automatically renewed and reloaded when they have thirty days or less before they expire.

Coding Standards
===

```
-` https://framework.zend.com/manual/2.4/en/ref/coding.standard.html`
- `http://www.php-fig.org/psr`
```

Compression and Extract
===

* Compression zip / tar a directory / files

```
zip -r project-name.zip . -x \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.md \*.MD \*.log \*.zip \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat delivery.sh *.sh readme.html composer.lock wp-config.secure.php

-- without symlink
zip -r4uy project-name.zip . -x \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.md \*.MD \*.log \*.zip \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat delivery.sh *.sh readme.html composer.lock wp-config.secure.php
```

* Compress Multiple Directories or Files at Once

```
tar -czvf archive.tar.gz /home/username/Downloads /usr/local/stuff /home/username/Documents/notes.txt
tar -czvf archive.tar.gz /home/username --exclude=/home/username/Downloads --exclude=/home/username/.cache --exclude=*.mp4

```

> 1. -c: Create an archive.
> 1. -z: Compress the archive with gzip.
> 1. -v: Display progress in the terminal while creating the archive, also known as “verbose” mode. The v is always optional in these commands, but it’s helpful.
> 1. -f: Allows you to specify the filename of the archive.


* Extract an Archive

```
unzip -o xyz.zip
tar -xzvf archive.tar.gz
tar -xzvf archive.tar.gz -C /tmp

```

> 1. -o : Overwrite
> 1. -z : If the file is a bzip2-compressed file, replace the “z” in the above commands with a “j”.

SVN commandline basic
===

* Remove missing files

```
svn st | grep ^! | awk '{print " --force "$2}' | xargs svn rm
```

* Relocate - switch

```
svn switch --relocate http://svn.visualweber.net/[from-url]  http://svn.visualweber.net/[to-url] ./
```

* External svn

```
svn propset svn:externals 'cli/scripts http://svn.visualweber.net/trunk/cli/scripts'
svn propset svn:externals 'cli/scripts http://svn.visualweber.net/trunk/cli/scripts' . property 'svn:externals' set on '.'

```

* General

```
svn import visualweber.net/svn/tcprint.visualweber.net/ http://www.svn.visualweber.net/tcprint
svn import /home/USER/path/to/source file:///home/USER/path/to/repository --message="Importing Project"
svn update visualweber.net/svn/hcpaper.visualweber.net/
svn checkout http://svn.visualweber.net/jfoto jfoto.visualweber.net
svnadmin dump path-to-repo | gzip > dumpfile.gz
svn commit -m "Your change log notes"
svn update
svn add * --force / svn add --force *
svn merge -r 303:302 http://svn.example.com/repos/calc/trunk
svn diff
svn propset --recursive  svn:global-ignores '*' media/catalog/product/cache

```

Find, Copy, Move and Remove
===

* Find

```
find -name .svn -exec rm -fdr {} \;
find -name "\.svn" -exec rm -rf {} \;
find -name "*.log" -exec rm -rf {} \;
find -name "*.zip" -o -name "*.gz" -o -name "*.log"  -exec rm -rf {} \;
find . -name "\*\.php" | xargs grep xyzxyz
find . -type f -name "*.php" -ctime -30
find . -type f -name '*.php' -exec grep -l xyzxyz {} + 2>/dev/null
```

* Find & Replace

```
find . -type f -name "\*\.php" | xargs -n 1 sed -i '' -e 's/search/replace/g' -e 's/search2/replace2/g'
find . -type f -name '\*\.php' -exec sed -i '' "s/oldstr/newstr/g" {} \;
find . -depth -name "*.ss" -exec sh -c 'mv "$1" "${1%.ss}.png"' _ {} \;
```

* Find - Mac
```
find . -name 'Icon?' -type f -delete
find . -name '.DS_Store' -type f -delete
```

```
find . -iname '*.php' -type f -print0 |xargs -0 sed -i '' -e 's/<?\n/<?php \n/g' -e 's/<? /<?php /g' -e 's/<?\/\//<?php \/\//g' -e 's/<?\/\*/<?php \/\*/g' -e 's/<?\=/<?php echo/g' -e 's/echo\$/echo \$/g'

```

The above command convers
```
"<?" to "<?php"
"<?=" to "<?php echo"
"<?//" to "<?php //"
"<?/*" to "<?php /*"
```

* Copy

```
cp -R /path/source-file.txt /path/destination-file.txt
yes | cp -R /path/* /path/destination-folder

Source: user-b
Target: user-a
rsync -azxvuiW --progress -e "ssh -p 1506 -i /home/user-a/.ssh/id_rsa" user-b@146.196.65.76:/home/user-b/public_html/v3.0/web/uploads/media/ /home/user-a/htdocs/jobsinzf/web/uploads/media/
rsync -av --exclude='path1/to/exclude' --exclude='path2/to/exclude' source destination
rsync -rv --exclude=.git sourcefolder /destinationfolder



scp [user@]from-host:]source-file [user@]to-host:][destination-file]
scp *.txt dev@10.0.0.2:/home/dev/hosting-local
scp -r folder-name user-name@server:/home/user-name/destination-folder
scp -r ubuntu@10.0.0.2:/home/username/ centos@10.0.0.3:/home/centos/
scp -i ~/.ssh/id_rsa -r /var/lib/elasticsearch/elasticsearch root@my-server:/
scp -i ~/.ssh/id_rsa somefile.txt root@my-server:/
```

* Remove specials characters

```
grep -rl $'\xEF\xBB\xBF' domains/
Use vi ./filename
:set nobomb
:wq

```

Mysql basic commandline
===

* Backup your MySQL Database

```
mysqldump  -hlocalhost -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE dev_celestarise_home > dev_celestarise_home.sql
mysqldump  -uuserdb.dev.celestarise_home -p dev_celestarise_home > dev_celestarise_home.sql
mysqldump  -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE dev_celestarise_home | gzip -9 > dev_celestarise_home.sql.gz
mysqldump  -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE --default-character-set utf8 dev_celestarise_home  > dev_celestarise_home.mysql
```

* Restoring your MySQL Database

```
mysql -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE dev_celestarise_home < dev_celestarise_home.sql
mysql -h127.0.0.1 -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE --default-character-set utf8 dev_celestarise_home < dev_celestarise_home.sql


If you need to restore a database that already exists, you'll need to use mysqlimport command. The syntax for mysqlimport is as follows
mysqlimport -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE dev_celestarise_home < dev_celestarise_home.sql

To restore compressed backup files you can do the following:
gunzip < dev_celestarise_home.sql.gz | mysql -uuserdb.dev.celestarise_home -pB1hgYtu5Nikl0bcE dev_celestarise_home

Restore from FILE:
mysql.exe --defaults-file="c:\users\anonym~1\appdata\local\temp\tmpn3ytli.cnf"  --protocol=tcp --host=127.0.0.1 --user=userdb.dev.celestarise_home --port=3306 --default-character-set=utf8 --comments  < "E:\\dev_celestarise_home.sql"

Convert table and all column to UTF8
SELECT DISTINCT CONCAT( 'alter table ', TABLE_SCHEMA, '.', TABLE_NAME, '  CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;' )
FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = dev_celestarise_home;
```

Mongo basic commandline
===

* Backup your MongoDB Database

```
- Mongo DB Name: dev_celestarise_home
- Mongo DB User: userdb.dev.celestarise_home
- Mongo DB Password: B1hgYtu5Nikl0bcE

sudo mongodump --host localhost:27017 -u userdb.dev.celestarise_home -p B1hgYtu5Nikl0bcE --db dev_celestarise_home --out mongodb-2017-04-09.json
```

* Restore your MongoDB Database

```
sudo mongorestore --host localhost:27017 -u userdb.dev.celestarise_home -p B1hgYtu5Nikl0bcE --db dev_celestarise_home --drop /home/jobsin/mongodb-2017-04-09.json/dev_celestarise_home
```

* Create users
- http://www.tutorialspoint.com/mongodb/mongodb_create_database.htm

```
$ mongo --host visualweber.net --port 2727
$ db.dropUser("username")

$ use admin
$ db
$ db.createUser( { user: "root",pwd: "your-password",roles: [ "userAdmin"] } )

$ use dev_celestarise_home
$ db.createUser( { user: "userdb.dev.celestarise_home",pwd: "B1hgYtu5Nikl0bcE",roles: [ {role:"readWrite",db:"dev_celestarise_home"}] } )
```

* Rockmongo

```
$MONGO["servers"][$i]["mongo_name"] = "localhost";//mongo server name
//$MONGO["servers"][$i]["mongo_sock"] = "/var/run/mongo.sock";//mongo socket path (instead of host and port)
$MONGO["servers"][$i]["mongo_host"] = "localhost";//mongo host
$MONGO["servers"][$i]["mongo_port"] = "27017";//mongo port
$MONGO["servers"][$i]["mongo_timeout"] = 0;//mongo connection timeout
$MONGO["servers"][$i]["username"] = "";//mongo connection timeout
$MONGO["servers"][$i]["password"] = "";//mongo connection timeout
```

Useful commandline
===

* Fix bugs composer install / update
Cannot update packages anymore "Fatal error: Out of memory (allocated 1392771072) (tried to allocate 268435456 bytes)"

```
sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
chmod 0600 /var/swap.1
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1
```

* Checking port

```
sudo netstat -plnt | grep ':80'
```

* List all size of each folders

```
- https://www.tecmint.com/find-top-large-directories-and-files-sizes-in-linux/

sudo du -hS * | sort -rh | head -5
sudo ls -1d */ |xargs du -sh && du -sh
```

* Recursively counting files in a Linux directory

```
find -type f -name *.gif -o -name *.jpg -o -name *.bmp
To get the count, you can append | wc -l.
find -type f -name *.gif -o -name *.jpg -o -name *.bmp | wc -l
find .//. ! -name . -print | grep -c //
find DIR_NAME -type f | wc -l
```

* Chmod files and folders

```
find . -type f -exec chmod -R 0644 {} \;
find . -type d -exec chmod -R 0755 {} \;
```

* Convert private key: PPK to PEM

```
puttygen key.ppk  -O private-openssh -o key.pem
```

* Login commandline with private key

```
ssh -p 1506 -i /path/.ssh/id_rsa user@192.168.0.2
```

Install Redmine
===

```
bundle install --path /home/username/.bundle/ --without development test && bundle exec rake redmine:plugins:migrate RAILS_ENV=production && bundle exec rake tmp:cache:clear tmp:sessions:clear RAILS_ENV=production && service redmine restart
```

Install RVM
===
```
gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3 7D2BAF1CF37B13E2069D6956105BD0E739499BDB
\curl -sSL https://get.rvm.io | bash
```

Gitlab-shell + rvm
===

I just worked 3 hours on this problem, here is a more adequate solution.
In `/etc/ssh/sshd_config`

`PermitUserEnvironment yes`

This setting allow the use of ~/.ssh/environment to set environment variables.

Then in ~git/.ssh/environment:
```
PATH="/home/git/bin:/usr/local/rvm/gems/ruby-1.9.3-p392/bin:/usr/local/rvm/gems/ruby-1.9.3-p392@global/bin:/usr/local/rvm/rubies/ruby-1.9.3-p392/bin:/usr/local/rvm/bin:/usr/local/bin:/usr/bin:/bin:/usr/local/games:/usr/games"
GEM_HOME="/usr/local/rvm/gems/ruby-1.9.3-p392"
GEM_PATH="/usr/local/rvm/gems/ruby-1.9.3-p392:/usr/local/rvm/gems/ruby-1.9.3-p392@global"
MY_RUBY_HOME="/usr/local/rvm/rubies/ruby-1.9.3-p392"
IRBRC="/usr/local/rvm/rubies/ruby-1.9.3-p392/.irbrc"
```
Of course the content of this file must be adapted with regard to your rvm configuration.
Now the correct ruby is run by gitlab-shell, without modifying bin/gitlab-shell.
This solution is ok if you can modify sshd configuration.
Hope this helps.

##### Update
The following command excuted as git user in rvm environment produces the correct configuration :
```
env | grep -E "^(GEM_HOME|PATH|RUBY_VERSION|MY_RUBY_HOME|GEM_PATH)=" > ~/.ssh/environment
```

Switch RUBY version with RVM
====
```
rvm reset
rvm use system
rvm use 2.1.1
rvm --default use 2.1.1
```

Remove Malware with Google Ads
===

- Submit review: `https://support.google.com/adwords/contact/site_policy?utm_source=policyhc&utm_medium=contact_site_policy&utm_campaign=1308246`
- Request a Review: `https://developers.google.com/webmasters/hacked/docs/request_review`
- Diagnostic: `https://www.google.com/transparencyreport/safebrowsing/diagnostic/index.html#url=domain.com`
- Check status: `http://www.google.com/safebrowsing/diagnostic?site=domain.com`

```
https://www.google.com/webmasters/tools/removals
https://www.google.com/webmasters/tools/googlebot-fetch?hl=en-GB&siteUrl=http://domain.com/
https://safebrowsing.google.com/safebrowsing/report_error/?hl=en
https://support.google.com/adwordspolicy/answer/1704383?hl=en&ref_topic=1308266
https://support.google.com/adwords/answer/1704381
https://www.stopbadware.org/clearinghouse/search?url=http://vinhomesgreenbay.com/
https://www.stopbadware.org/clearinghouse/search?ip=116.193.76.91
https://aw-snap.info/articles/may-be-hacked.php
https://aw-snap.info/file-viewer/
```

Laravel Setup and Security
===

- Quick running with `php -S localhost:8000 -t public`
We don't need to create a `virtual host`

- Encryption - Laravel - The PHP Framework For Web Artisans
`php artisan key:generate`

- Create Symbolic link `public/storage`
`php artisan storage:link`

- Fix bug connection refused with github repository
`git config --global url."https://".insteadOf git://` OR `git config --global url.https://github.com/.insteadOf git://github.com/`

- Clear all caches in Laravel
`php artisan cache:clear && php artisan config:clear && php artisan view:clear`

- Migrate in Laravel
`php artisan migrate` OR `php artisan migrate:install`
`php artisan migrate:status`

Wordpress Setting and Security
===

*** WP-CONFIG.PHP

```
/**** SECURITY WP
* Add before require_once(ABSPATH . 'wp-settings.php');
****/
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

define('EM_WMPL_FORCE_RECURRENCES', true);
define('WP_SITEURL', '//' . $_SERVER['SERVER_NAME']);
define('WP_HOME', '//' . $_SERVER['SERVER_NAME']);

define('WP_CONTENT_FOLDERNAME', 'apps');
define('WP_CONTENT_DIR', ABSPATH . WP_CONTENT_FOLDERNAME) ;
define('WP_CONTENT_URL', WP_SITEURL . '/' . WP_CONTENT_FOLDERNAME);
define('WP_TEMP_DIR', WP_CONTENT_DIR .  '/uploads');

define('WP_POST_REVISIONS', 10); // define('WP_POST_REVISIONS', false);
define('WP_DEBUG_DISPLAY', false);

// define('ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'apps-admin' );
define('USER_COOKIE', 'appsuser_' . COOKIEHASH);
define('PASS_COOKIE', 'appspass_' . COOKIEHASH);
define('AUTH_COOKIE', 'apps_' . COOKIEHASH);
define('SECURE_AUTH_COOKIE', 'apps_sec_' . COOKIEHASH);
define('LOGGED_IN_COOKIE', 'apps_logged_in_' . COOKIEHASH);
define('TEST_COOKIE', 'apps_test_cookie');

/**** SECURITY WP ****/
```

Server configure - best practices
===

* .htaccess

```
<IfModule dir_module>
    DirectoryIndex index.php index.html index.htm index.shtml index.php5 index.php4 index.php3 index.phtml index.cgi
</IfModule>
############################################
## EXPIRES CACHING ##
<ifModule mod_gzip.c>
    mod_gzip_on Yes
    mod_gzip_dechunk Yes
    mod_gzip_item_include file .(html?|txt|css|js|php|pl)$
    mod_gzip_item_include handler ^cgi-script$
    mod_gzip_item_include mime ^text/.*
    mod_gzip_item_include mime ^application/x-javascript.*
    mod_gzip_item_exclude mime ^image/.*
    mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
</ifModule>
<IfModule mod_headers.c>
    ## Header set X-Frame-Options SAMEORIGIN
    Header set Connection keep-alive
    # 2 HOURS
    #<filesMatch "*">
        Header set Cache-Control "max-age=7200, must-revalidate"
    #</filesMatch>

    # 1 DAY
    <filesMatch "\.(css)$">
        Header set Cache-Control "max-age=86400, public, must-revalidate"
        #Header set Cache-Control "max-age=0, public, must-revalidate"
    </filesMatch>

    # 2 DAYS
    <filesMatch "\.(xml|txt)$">
        Header set Cache-Control "max-age=172800, public, must-revalidate"
    </filesMatch>

    # 2 HOURS
    # Cache HTML files for a couple hours
    <filesMatch "\.(html|htm)$">
        Header set Cache-Control "max-age=7200, private, must-revalidate"
    </filesMatch>

    # Cache specified files for 31 days
    <filesMatch ".(ico|pdf|flv|jpg|jpeg|png|gif|css|swf|eot|woff|otf|ttf|svg)$">
        #Header append Cache-Control "public"
        Header set Cache-Control "max-age=2678400, public"
    </FilesMatch>
    # Cache Javascripts for 31 days
    <filesmatch "\.(js)$">
        Header set Cache-Control "max-age=2678400, private"
    </filesmatch>
    <filesMatch "\.(x?html?|php)$">
        Header set Cache-Control "private, must-revalidate"
    </filesMatch>
</IfModule>
# BEGIN Expire headers
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresDefault "access plus 5 seconds"
    ExpiresByType image/x-icon "access plus 2592000 seconds"
    ExpiresByType image/jpeg "access plus 2592000 seconds"
    ExpiresByType image/png "access plus 2592000 seconds"
    ExpiresByType image/gif "access plus 2592000 seconds"
    ExpiresByType application/x-shockwave-flash "access plus 2592000 seconds"
    ExpiresByType text/css "access plus 604800 seconds"
    ExpiresByType text/javascript "access plus 216000 seconds"
    ExpiresByType application/javascript "access plus 216000 seconds"
    ExpiresByType application/x-javascript "access plus 216000 seconds"
    ExpiresByType text/html "access plus 600 seconds"
    ExpiresByType application/xhtml+xml "access plus 600 seconds"
</ifModule>
# END Expire headers

<ifmodule mod_deflate.c>
    SetOutputFilter DEFLATE
    #AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript
    #BrowserMatch ^Mozilla/4 gzip-only-text/html
    #BrowserMatch ^Mozilla/4\.0[678] no-gzip
    #BrowserMatch \bMSIE !no-gzip !gzip-only-text/html

    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</ifmodule>

## EXPIRES CACHING ##

```

Linux commandline basic
===

# Snapaper Backend
The PHP Back-end of Snapaper

<br/>

## Usage
```bash
git clone git@github.com:Snapaper/snapaper-backend.git
```

<br/>

Make sure composer has been installed before you continue.
<br/>
```bash
cd src
composer install
```

<br/>

After you've done steps above, properly edit your Nginx server vhost configuration .conf file. An example .conf file is included at nginx/vhost.conf.
<br/>
```bash
nginx -s reload
```
<br/>
Hopefully your app will be working by now.


<br/>


## Notice
The cases API sources files from local directories, make sure files are uploaded before making the API available.
# Snapaper Backend
The PHP Back-end of Snapaper

<br/>

## Usage
```bash
git clone git@github.com:Snapaper/snapaper-backend.git
```

```bash
cd src
composer install
```
<br/>
After you've done steps above, properly edit your Nginx server vhost configuration .conf file and
```bash
nginx -s reload
```
<br/>
Hopefully your app will be working

<br/>

Notice that cases API sources files from local directory, make sure files are uploaded before making the API available
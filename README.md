# Magento 2 With Docker

### Automated command
You can run this command to put the store up and it does the configuration
for you.
```bash
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/onelinesetup | bash -s -- magento.test 2.4.2
```

#### Or clone this repository
You will need to config the /etc/hosts to allow the nginx to redirect to the
url, in this case is magento2.test
If on linux or macos you can do the following:
```bash
sudo echo "127.0.0.1 ::1 magento.test" >> /etc/hosts
```

* If you don't have the permissions run 
```bash
sudo su
echo "127.0.0.1 ::1 magento.test" >> /etc/hosts
```

In the cmd of the folder run:
```bash
bin/magento start
```
It is equal to:
```bash
docker-compose up -d
```


## Credits
[Markshust](https://github.com/markshust/docker-magento)

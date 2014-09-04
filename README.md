NSS User Authentication for OwnCloud
====================================

User authentication with the output of `getent passwd` and `getent shadow`.

Requires `sudo` to be installed and the following line to be present in the sudoers file:
```
www-data ALL= NOPASSWD: /usr/bin/getent passwd, /usr/bin/getent shadow
```

Inside the `appinfo/info.xml` file I specified that the minimum required OwnCloud version is version 7.0. This is just because it's the only version of OwnCloud I've tested this on. It'll probably work on older versions just fine.
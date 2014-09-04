NSS User Authentication for OwnCloud
====================================

User authentication with the output of `getent passwd` and `getent shadow`.

Requires `sudo` to be installed and the following line to be present in the sudoers file:
```
www-data ALL= NOPASSWD: /usr/bin/getent passwd, /usr/bin/getent shadow
```
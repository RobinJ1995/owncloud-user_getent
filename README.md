NSS User Authentication for OwnCloud
====================================

User authentication with the output of `getent passwd` and `getent shadow`.

Requires `sudo` to be installed and the following line to be present in the sudoers file:
```
www-data ALL= NOPASSWD: /usr/bin/getent shadow, /usr/bin/getent passwd
```

Inside the `appinfo/info.xml` file I specified that the minimum required OwnCloud version is version 7.0. This is just because it's the only version of OwnCloud I've tested this on. It'll probably work on older versions just fine.

Warning!
========

Do *not* use this unless you know what you are doing! Never should this be used on a multi-user server!
A possible solution here is something like `mpm-itk`, but that might bring its own security implications with it.

I am not responsible if you choose to ignore this warning (or even if you don't) and get your server hacked.

## If you want create a new https, for example, in case the domain change

```bash
openssl req -new -key private.key -out certificate.csr -subj "/C=US/ST=State/L=City/O=Organization/OU=Organizational Unit/CN=<your-domain>"
```
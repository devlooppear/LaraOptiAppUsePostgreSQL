## Generatin by zero:

1. Generate a new private key:

```bash
openssl genpkey -algorithm RSA -out private.key
```
2. Generate a certificate signing request (CSR) using the private key:

```bash
openssl req -new -key private.key -out certificate.csr
```
3. Generate a self-signed certificate using the CSR and private key:

```bash
openssl x509 -req -days 365 -in certificate.csr -signkey private.key -out certificate.crt
```


## If you want create a new https, for example, in case the domain change

```bash
openssl req -new -key private.key -out certificate.csr -subj "/C=US/ST=State/L=City/O=Organization/OU=Organizational Unit/CN=159.223.200.61"
```
AuthLiaisonAgent
================

An agent system (or module) that provides access authorisarion for a web program where a typical authentication system can not run on the same server. For example, when there is no database system on the server and no write access to files that can be used to store user account data or access log.

The system consists of two parts:
1. Backend Agent
   Run on the target server to allow access to the website.
2. Frontend Agent
   Run on an intermediate server to provide a login mechanism to open an authorised accesss to the target server.
   
Usage:
1. Patch the authorisation agent to the target website to block non authorisation accesses.
2. Incorporate a working authentication system for the authentication agent to authenticate users.

Note:
The system uses encryption certificates. The source code is provided with two certificates for example purposes only. To run in a producton system, you have to generate the certificates by running these commands below.
Private key:
openssl genrsa -des3 -out authagent-private.pem 1024
Public key:
openssl rsa -in authagent-private.pem -out authagent-public.pem -outform PEM -pubout

Author: Ori Novanda (cargmax-at-gmail.com)

License: GNU LGPL v3

Revision History:
20140920 Beta release.
20140913 Initial build. Tested againts a patched PHPProxyImproved.
#!/bin/bash/env python3

import random

plain = "*******************"
n=4
l=len(plain)

k=l%n
if(k!=0):
	plain = plain + " " + plain[0:n-k-1]
l=len(plain)

tr=""
s = (int)(l/n)
for i in range(0,s):
	for j in range(0,n):
		tr+=plain[n*(i+1)-(j+1)]

random.seed()
iv = random.randint(0,9)

cipher=[]
for i in range(0,l):
	p = iv
	if(i==0):
		key=p
		cipher.append(ord(tr[i])^(key))
	else:
		p=key%10
		key=ord(tr[i-1])+p
		cipher.append(ord(tr[i])^(key))

print(cipher)
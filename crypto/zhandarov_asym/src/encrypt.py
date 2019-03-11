#!/bin/bash/env python3

table = [4, 1, 8, 0, 3, 11, 2, 9, 6, 14, 7, 5, 10, 12, 13]

priv =  #0..9

plain = input("Enter plaintext: ")
l = len(plain)
t = len(table)
lt = int(l%t)
if(lt!=0):
	for i in range(0,t-lt):
		plain += plain[(l-1)-i]

l = len(plain)
count = int(l/t)
tr=""
for i in range(0,count):
	for j in range(0,t):
		tr+=plain[i*t+table[j]]

sub=""
for i in range(0,l):
	if(i+4<l):
		sub+=tr[i+4]
	else:
		sub+=tr[(i+4)%l]

cipher = []
o = []
for i in range(0, l):
	cipher.append(int(ord(sub[i])/priv))
	o.append(ord(sub[i])%priv)

cipher_tr=[]
for i in range(0,count):
	for j in range(0,t):
		cipher_tr.append(cipher[t*i+table[j]])

cipher = cipher_tr

print(cipher)
print(o)
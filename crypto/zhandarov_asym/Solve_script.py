#!/bin/bash/env python3

table = [4, 1, 8, 0, 3, 11, 2, 9, 6, 14, 7, 5, 10, 12, 13] # Таблица перестановок

priv = 6 # Закрытый ключ

# Шифротекст
cipher = [20, 19, 19, 20, 16, 18, 11, 17, 18, 16, 19, 18, 16, 20, 18, 19, 17, 16, 16, 18, 16, 16, 16, 17, 20, 18, 16, 16, 20, 18, 16, 18, 19, 16, 17, 16, 16, 18, 18, 11, 17, 16, 16, 14, 18]
# Открытый ключ
o = [3, 0, 4, 5, 1, 1, 1, 1, 2, 3, 3, 2, 1, 3, 1, 5, 3, 2, 3, 2, 1, 1, 3, 4, 4, 5, 4, 5, 3, 5, 5, 3, 1, 1, 4, 2, 3, 3, 2, 2, 5, 1, 0, 1, 1]

# Для того, чтобы произвести обратную перестановку, нужна обратная таблица
tbl=[]
t = len(table)
for i in range(0,t):
	for j in range(0,t):
		if(table[j]==i):
			tbl.append(j)
			break

# Делаем перестановку в шифротексте
tr = []
l = len(cipher)
count = (int)(l/t)
for i in range(0,count):
	for j in range(0,t):
		tr.append(cipher[t*i+tbl[j]])

# Расшифровываем текст, используя оба ключа
sub=""
for i in range(0,l):
	sub+=chr(tr[i]*priv+o[i])

# Делаем сдвиг полученного сообщения
tr = ""
for i in range(0,l):
	if((i-4)<0):
		tr+=sub[i-4+l]
	else:
		tr+=sub[i-4]

# Снова перестановка
sub = ""
for i in range(0,count):
	for j in range(0,t):
		sub+=tr[t*i+tbl[j]]

# Избавляемся от дополнения
plain=sub[0:2]
for i in range(2,l-1):
	if(sub[i]==sub[i-1] and sub[i+1]==sub[i-2]):
		break
	plain+=sub[i]

print(plain)
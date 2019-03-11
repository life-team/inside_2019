import hashlib

alph = ['abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{}']
SHIFRPREDL = 'ЧТО ТУТ?'
k = []
stroka = ''
for i in range(len(SHIFRPREDL)):
    k.append(bin(ord(SHIFRPREDL[i]) ^ len(SHIFRPREDL)))
for i in range(len(k)):
    stroka += hashlib.md5(k[i].encode('utf-8')).hexdigest()
print(k)
print(stroka)

#To_4To_Hy>|<Ho_PaCLLIUFPOBATb = "df8ac1e42c35bb8682443693331a26a821e19e578c27a88623c01d426d90b302713c833f7269636bec634638885f3e5fa29b4a3e3b8ac8289eae011ecb2ef5e08bcbef48d55dd249b07a66ed6580fd73799b00cda1b8d8f9eec753b361c9a3e140d36950dc96207c9b2c80a636f9c92beb253cb84e7b317b30c51896c91b9599799b00cda1b8d8f9eec753b361c9a3e1ce9b8bf619fc9b0429d0dbdaf29456de98d27bde125a4847513c3c459412c8b8792d352044da78d2775a15c8aefffc6fe696d0acb4969f648a62558e33939a666e540a140b57a2a3069cdd32a3d138c6b9580444b0823e53a35b26c32e47eb1ddf82e8a0697ed77697f1b63d15a0d6c4fd77c0e0e12e893871deb09df97f13a3"
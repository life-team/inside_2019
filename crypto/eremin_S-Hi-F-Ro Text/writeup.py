import hashlib

alph = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','{','}']
for i in range(1,len(alph)):
    chislo = bin(ord('C')^i)
    if (hashlib.md5(chislo.encode('utf-8')).hexdigest() == "df8ac1e42c35bb8682443693331a26a8"):
        xorchislo = i
        break
print(i)

Rash = ['df8ac1e42c35bb8682443693331a26a8','21e19e578c27a88623c01d426d90b302','713c833f7269636bec634638885f3e5f',
        'a29b4a3e3b8ac8289eae011ecb2ef5e0','8bcbef48d55dd249b07a66ed6580fd73','799b00cda1b8d8f9eec753b361c9a3e1',
        '40d36950dc96207c9b2c80a636f9c92b','eb253cb84e7b317b30c51896c91b9599','799b00cda1b8d8f9eec753b361c9a3e1',
        'ce9b8bf619fc9b0429d0dbdaf29456de','98d27bde125a4847513c3c459412c8b8','792d352044da78d2775a15c8aefffc6f',
        'e696d0acb4969f648a62558e33939a66','6e540a140b57a2a3069cdd32a3d138c6','b9580444b0823e53a35b26c32e47eb1d',
        'df82e8a0697ed77697f1b63d15a0d6c4','fd77c0e0e12e893871deb09df97f13a3']

m = []
for i in range(len(Rash)):
    for k in range(len(alph)):
        chislo = bin(ord(alph[k])^xorchislo)
        if (hashlib.md5(chislo.encode('utf-8')).hexdigest() == Rash[i]):
            m.append(alph[k])
print(m)
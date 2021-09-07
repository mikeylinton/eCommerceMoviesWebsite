file = open('Surveys.csv', 'r')
Columns=file.readline().strip().split(',')
for i in range(2,8):
    vars()["TopChurn"+Columns[i]]=[None,0]
    vars()["Churn"+Columns[i]]={}
    vars()["Top"+Columns[i]]=[None,0]
    vars()[Columns[i]]={}
for line in file:
    line=line.strip().split(',')
    if float(line[1])<0.6:
#        print(float(line[1]))
        for i in range(2,8):
            try:
                vars()[Columns[i]][line[i]]+=1
            except KeyError:
                vars()[Columns[i]][line[i]]=1
    else: 
        for i in range(2,8):
            try:
                vars()["Churn"+Columns[i]][line[i]]+=1
            except KeyError:
                vars()["Churn"+Columns[i]][line[i]]=1
file.close() #close fil
#print("Non-Churn")
for i in range(2,8):
#    print(Columns[i],vars()[Columns[i]])
    for key in vars()[Columns[i]]:
        if int(vars()[Columns[i]][key])>vars()["Top"+Columns[i]][1]:
            vars()["Top"+Columns[i]][0]=key
            vars()["Top"+Columns[i]][1]=int(vars()[Columns[i]][key])
#print("Churn")
for i in range(2,8):
#    print(Columns[i],vars()["Churn"+Columns[i]])
    for key in vars()["Churn"+Columns[i]]:
        if int(vars()["Churn"+Columns[i]][key])>vars()["TopChurn"+Columns[i]][1]:
            vars()["TopChurn"+Columns[i]][0]=key
            vars()["TopChurn"+Columns[i]][1]=int(vars()["Churn"+Columns[i]][key])
print("Churn")
for i in range(2,8): print(vars()["TopChurn"+Columns[i]])
print("Non-Churn")
for i in range(2,8): print(vars()["Top"+Columns[i]])

tChurn=0
tNonChurn=0
for key in sAge: tNonChurn+=int(sAge[key])
for key in ChurnsAge: tChurn+=int(ChurnsAge[key])
total=tChurn+tNonChurn
pChurn=str(round((tChurn/total)*100,2))
print(pChurn+'%',"Total Customer Churn Rate")
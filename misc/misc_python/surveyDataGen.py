from random import *
Genre=[
    "'Action'",
    "'Adventure'",
    "'Animation'",
    "'Biography'",
    "'Crime'",
    "'Comedy'",
    "'Documentary'",
    "'Drama'",
    "'Family'",
    "'Fantasy'",
    "'Film-Noir'",
    "'Horror'",
    "'History'",
    "'Mystery'",
    "'Music'",
    "'Musical'",
    "'News'",
    "'Romance'",
    "'Sci-Fi'",
    "'Short'",
    "'Sport'",
    "'Thriller'",
    "'War'",
    "'Western'"
]
Age=["'18-24'","'25-34'","'35-44'","'45-54'","'55-64'","'65<'","NULL"]
Income=["'15000>'","'15000-34999'","'35000-49999'","'50000-74999'","'74999-99999'","'100000<'","NULL"]
Gender=["'Feamle'","'Male'","'Non-binary'","'Other'","NULL"]
Employment=["'Full'","'Part'","'Self'","'Student'","'None'","NULL"]
Relationship=["'Single'","'Married'","'Partnered'","'Seperated'","NULL"]
csvOut=[
'cID,sChurn,sAge,sIncome,sGender,sEmployment,sRelationship,sGenre,sSelection,sPricing,sSuggestions,sUsability,sRecommend\n'
]
for cID in range(1,1001):
    Selection=randint(0, 10);Pricing=randint(0, 10);Suggestions=randint(0, 10);Usability=randint(0, 10);Recommend=randint(0, 10)
    Churn=str((100-((Selection+Pricing+Suggestions+Usability+Recommend)*2))/100)
    Selection=str(Selection);Pricing=str(Pricing);Suggestions=str(Suggestions);Usability=str(Usability);Recommend=str(Recommend)
    rAge=Age[randint(0, 6)]
    rIncome=Income[randint(0, 6)]
    rGender=Gender[randint(0, 4)]
    rEmployment=Employment[randint(0, 5)]
    rRelationship=Relationship[randint(0, 4)]
    rGenre=Genre[randint(0, 22)]
    csvOut.append(str(cID)+','+Churn+','+rAge.strip("'")+','+rIncome.strip("'")+','+rGender.strip("'")+','+rEmployment.strip("'")+','+rRelationship.strip("'")+','+rGenre.strip("'")+','+Selection+','+Pricing+','+Suggestions+','+Usability+','+Recommend+'\n')
    print(
        "INSERT INTO Surveys (cID, sChurn, sAge, sIncome, sGender, sEmployment, sRelationship, sGenre, sSelection, sPricing, sSuggestions, sUsability, sRecommend) VALUES ('"+
        str(cID)+"', '",
        Churn+"',",
        rAge+",",
        rIncome+",",
        rGender+",",
        rEmployment+",",
        rRelationship+",",
        rGenre+", '"+
        Selection+"', '"+
        Pricing+"', '"+
        Suggestions+"', '"+
        Usability+"', '"+
        Recommend+
        "');"
    )
file = open('surveyData.csv', 'w') #write to file 
for line in csvOut:
     file.write(line)
file.close() #close file

import sys, json, csv


def convertCSVToMySQL(inputFile, outputFile):

    r = list(csv.reader(open(inputFile, 'r')))
    line_split = list(r)
    line_split = r[1:]  # ignore title row

    with open(outputFile, 'w') as f:
        for line in line_split:
            if int(line[0]) > 601:
                # print(line[0])
                line[0] = str(int(int(line[0]) / 2))
                # print(line[0]) 
            f.writelines("INSERT INTO Transactions (mID, CID, tDate, tTime) VALUES (\'" + line[0] + "\',\'" + line[1] + "\',\'" + line[2] + "\',\'" + line[3] + "\');\n")
        f.close()

    # print(json.dumps(line_split, indent=4))
    # print(output_data)

if __name__ == '__main__':
    convertCSVToMySQL('transactions-test.csv', 'transactions.sql')
    
import csv, os, json


def splitDate(inputFile, outputFile):
    date_split = []

    r = list(csv.reader(open(inputFile, 'r')))
    for item in r:
        line = []
        line.append(item[0])
        line.append(item[1])
        split = item[2].split(' ')
        for thing in split:
            line.append(thing)
        date_split.append(line)        

    f = csv.writer(open(outputFile, 'w', newline=''))
    for item in date_split:
        f.writerow(item)
    
    # print(json.dumps(date_split, indent=4))

if __name__ == '__main__':
    splitDate('transactions.csv', 'transactions-test.csv')
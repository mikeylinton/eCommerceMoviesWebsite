import csv
import json
import random


def fix_users(inputfile, outputfile):

    lines = []
    with open(inputfile, 'r') as f:
        reader = csv.reader(f)
        next(reader)
        mid = 0
        for line in reader:
            if mid != line[0]:
                mid = line[0]
                nums = random.sample(range(1, 10), 4)
                num = nums.pop()
                lines.append([line[0], num, line[2], line[3], line[4]])
            else:
                num = nums.pop()
                lines.append([line[0], num, line[2], line[3], line[4]])

    with open(outputfile, 'w', newline='') as f:
        csv_write = csv.writer(f, delimiter=',')
        for line in lines:
            csv_write.writerow(line)


if __name__ == '__main__':
    fix_users('Reviews.csv', 'reviews-fixed.csv')

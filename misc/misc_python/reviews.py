import sys, json, csv, random, re


def reviews(inputFile, inputFile2, outputFile):

    r = list(csv.reader(open(inputFile, 'r', encoding='latin1')))
    reviews = list(r)
    reviews = r[1:]  # ignore title rows

    s = csv.reader(open(inputFile2, 'r'))
    topMovies = {row[0]:row[1] for row in s}

    for review in reviews:
        if review[0] in topMovies.keys():
            review.append(topMovies[review[0]])

    with open(outputFile, 'w', encoding='latin1') as f:
        # cid = random.sample(range(1, 1000), 200)
        cid = random.randint(1, 50)
        for review in reviews:
            try:
                f.writelines("INSERT INTO Reviews (mID, CID, rTitle, rBody, rRating) VALUES (\'" + review[5] + "\',\'" + str(cid.pop()) + "\',\'" + re_sub(review[1]) + "\',\'" + re_sub(review[3]) + "\',\'" + review[2] + "\');\n")
            except (IndexError):
                print("\n" + str(review[0]))
        f.close()

def re_sub(instring) -> str:
    return re.sub(r'([\'\"])', r'\\\1', instring)


if __name__ == '__main__':
    reviews('test-2.csv', 'top-100-movies.csv', 'reviews.sql')
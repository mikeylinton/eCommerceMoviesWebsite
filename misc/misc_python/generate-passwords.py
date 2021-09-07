import secrets, string, hashlib, csv


def create_passwords(outputFile1, outputFile2):
    text_passwords = []
    passwords = []
    for i in range(1000):
        password = ''.join((secrets.choice(string.ascii_letters) for i in range(5)))
        text_passwords.append(password)
        encrypted = hashlib.sha1(password.encode())
        passwords.append(encrypted.hexdigest())

    with open(outputFile1, 'w', encoding='latin1') as f:
        for i in range(len(passwords)):
            f.writelines("UPDATE Customers SET cPass = \'" + passwords[i] + "\' WHERE cID = " + str(i + 1) + ";\n")
        f.close()

    with open(outputFile2, 'w', newline='') as f:
        csv_write = csv.writer(f, delimiter=',')
        for i in range(len(passwords)):
            line = [text_passwords[i], passwords[i]]
            # print(line)
            csv_write.writerow(line)


if __name__ == '__main__':
    create_passwords('passwords.sql', 'passwords.csv')

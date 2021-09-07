import csv

from sqlalchemy import create_engine

from predict_churn import decision_tree_churn_survey
from churn_from_order import churn_from_order


def retention_email_list(mysql_url, selector='survey') -> list:

    if selector in ['survey', 'order']:
        engine = create_engine(mysql_url)
        connection = engine.connect()
        churn_rates = []

        if selector == 'survey':
            customer_ids = connection.execute("SELECT * FROM Customers")
            for customer_id in customer_ids:
                try:
                    churn_rate = decision_tree_churn_survey(customer_id[0], mysql_url)
                    if churn_rate == 1:
                        churn_rates.append([customer_id[0], str(customer_id[1] + customer_id[2]), customer_id[4]])
                except ValueError:
                    continue

        elif selector == 'order':
            churn_rate = churn_from_order(mysql_url)
            churn_rate = [list(a) for a in zip(churn_rate.index.values.tolist(), churn_rate['churn'].tolist())]
            for item in churn_rate:
                if item[1] == 1:
                    result = connection.execute("SELECT cID, cForename, cSurname, cEmail FROM Customers WHERE cID =" + str(item[0]))
                    customer_info = list(result.all()[0])
                    customer_info[1:3] = [' '.join(customer_info[1:3])]
                    churn_rates.append(customer_info)

        return churn_rates

    else:
        print("Choose either survey or order")


def write_to_csv(filename, input_list):
    f = csv.writer(open(filename, 'w', newline=''))
    for item in input_list:
        f.writerow(item)


if __name__ == '__main__':
    email_list = retention_email_list('mysql://ml96@mysql-server-1"/ml96', 'order')
    #("mysql-server-1", "ml96", "8@AM1TgJEbT", "ml96");
    print(email_list)

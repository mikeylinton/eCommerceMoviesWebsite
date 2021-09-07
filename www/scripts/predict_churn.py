# Scikit-Learn ≥0.20 is required
import pandas as pd
import argparse
import sklearn
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.tree import DecisionTreeClassifier
from sqlalchemy import create_engine

assert sklearn.__version__ >= "0.20"


def decision_tree_churn_survey(cid, db_connection_str) -> int:
    # Start MySQL connection
    # Please change the string below to connect our sever
    # db_connection_str = 'mysql+pymysql://sql4399167:VMAJwNlAix@sql4.freesqldatabase.com/sql4399167'
    # db_connection_str = 'mysql://root@localhost/tm224'
    db_connection = create_engine(db_connection_str)

    # Import surveys table for modelling
    ux = pd.read_sql_table('Surveys', con=db_connection)

    # Remove the unnecessary column
    clean_ux = ux = ux.drop('cID', axis=1)
    clean_ux = ux = ux.drop('sAge', axis=1)
    clean_ux = ux = ux.drop('sIncome', axis=1)
    clean_ux = ux = ux.drop('sGender', axis=1)
    clean_ux = ux = ux.drop('sEmployment', axis=1)
    clean_ux = ux = ux.drop('sRelationship', axis=1)
    clean_ux = ux = ux.drop('sGenre', axis=1)

    # Scale the cleaned data
    X_U = clean_ux.drop('sChurn', axis=1)
    y_U = clean_ux['sChurn']
    # Standardizing/scaling the features
    X_U = StandardScaler().fit_transform(X_U)

    # Split the data into 50% training and 50% testing (with the highest accuracy)
    ux_train, ux_test, uy_train, uy_test = train_test_split(X_U, y_U, test_size=0.2, random_state=42)

    # Create Decision Tree classifier object
    uclf = DecisionTreeClassifier()

    # Train Decision Tree Classifier
    uclf = uclf.fit(ux_train, uy_train)

    # Predict the response for test dataset
    uy_pred = uclf.predict(ux_test)

    # pred_udf = pd.read_sql('SELECT * FROM Surveys ORDER BY cID desc limit 1', con=db_connection)
    pred_udf = pd.read_sql('SELECT * FROM Surveys WHERE cID =' + str(cid), con=db_connection)

    # Remove the unnecessary column
    clean_pred = pred_udf = pred_udf.drop('cID', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sAge', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sIncome', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sGender', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sEmployment', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sRelationship', axis=1)
    clean_pred = pred_udf = pred_udf.drop('sGenre', axis=1)

    # Scale the cleaned data
    new_pred = clean_pred.drop('sChurn', axis=1)
    result = uclf.predict(new_pred)
    # Churn = 1, remain = 0
    return result[0]


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Returns churn rate for customer ID')
    parser.add_argument('customer_id', type=str, help='Customer ID number')
    args = parser.parse_args()
    print(decision_tree_churn_survey(args.cusomter_ID, 'mysql://ml96@mysql-server-1"/ml96'))

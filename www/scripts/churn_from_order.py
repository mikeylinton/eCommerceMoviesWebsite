import pandas as pd
from lifetimes import BetaGeoFitter
from lifetimes.utils import *
from sqlalchemy import create_engine


def churn_from_order(db_connection_str):
    # db_connection_str = 'mysql+pymysql://sql4399167:VMAJwNlAix@sql4.freesqldatabase.com/sql4399167'
    # db_connection_str = 'mysql://root@localhost/tm224'
    db_connection = create_engine(db_connection_str)

    orders = pd.read_sql_table('transactions', con=db_connection)
    items = pd.read_sql_table('movies', con=db_connection)

    # merge tables
    transaction_data = pd.merge(orders, items, 'inner', 'mID')

    # Generate the transaction data and summary for analysis
    transaction_data = transaction_data[['cID', 'tID', 'tDate', 'mPrice']]
    transaction_data['date'] = pd.to_datetime(transaction_data['tDate']).dt.date
    transaction_data = transaction_data.drop('tDate', axis=1)

    summary = summary_data_from_transaction_data(transaction_data, 'cID', 'date', monetary_value_col='mPrice', )
    summary[summary['frequency'] > 0].head()

    # Apply Beta Geo Fitter from lifetime package
    bgf = BetaGeoFitter(penalizer_coef=0.01)
    bgf.fit(summary['frequency'], summary['recency'], summary['T'])

    # we would like to observe the trend with half a year.
    summary_cal_holdout = calibration_and_holdout_data(transaction_data, 'cID', 'date',
                                                       calibration_period_end='2020-01-30',
                                                       observation_period_end='2020-12-30')

    bgf.fit(summary_cal_holdout['frequency_cal'], summary_cal_holdout['recency_cal'], summary_cal_holdout['T_cal'])

    df = summary[summary['frequency'] > 0]
    df['prob_alive'] = bgf.conditional_probability_alive(df['frequency'], df['recency'], df['T'])
    df['churn'] = [1 if p < .1 else 0 for p in df['prob_alive']]
    df['churn'][(df['prob_alive'] >= .1) & (df['prob_alive'] < .2)] = "risk"
    df['churn'].value_counts()

    # index = df.index.get_loc(cid)

    return df


if __name__ == '__main__':
    # churn_from_order(1, 'mysql://root@localhost/tm224')
    print(churn_from_order('mysql://root@localhost/tm224'))

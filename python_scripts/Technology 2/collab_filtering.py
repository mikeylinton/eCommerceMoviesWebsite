import pandas as pd
import argparse
from sqlalchemy import create_engine
from scipy.sparse import csr_matrix
from sklearn.neighbors import NearestNeighbors


def knn_recommender(movie_name, neighbours=6) -> list:
    engine = create_engine('mysql://root@localhost/tm224')
    connection = engine.connect()
    reviews = connection.execute("SELECT * FROM Reviews")

    ratings_data = pd.DataFrame(reviews)
    ratings_data.columns = reviews.keys()

    movies = connection.execute("SELECT * FROM Movies")
    movies_names = pd.DataFrame(movies)
    movies_names.columns = movies.keys()

    # Merge movies and reviews
    movie_data = pd.merge(ratings_data, movies_names, on='mID')

    # sort by ratings
    movie_data.groupby('mName')['rRating'].mean().sort_values(ascending=False).head()

    # add the mean of each movie to ratings_mean_count
    ratings_mean_count = pd.DataFrame(movie_data.groupby('mName')['rRating'].mean())

    # then add the count for each movie
    ratings_mean_count['rating_counts'] = pd.DataFrame(movie_data.groupby('mName')['rRating'].count())

    # create pivot table with movie names as index and customer IDs as columns, replace nulls with zeros
    user_movie_rating_pivot = movie_data.pivot(index="mName", columns="cID", values="rRating").fillna(0)

    # create a csr_matrix based on the pivot
    user_movie_rating_matrix = csr_matrix(user_movie_rating_pivot.values)

    # hyperparameters for the KNN
    model_knn = NearestNeighbors(metric="cosine", algorithm="brute")
    model_knn.fit(user_movie_rating_matrix)

    query_index = user_movie_rating_pivot.index.get_loc(movie_name)

    if type(neighbours) == int:
        neighbours += 1

    distances, indices = model_knn.kneighbors(user_movie_rating_pivot.iloc[query_index, :].values.reshape(1, -1), n_neighbors=neighbours)

    recommended = []

    for i in range(0, len(distances.flatten())):
        # if i == 0:
        #     print("Recommendation for {0}:\n".format(user_movie_rating_pivot.index[query_index]))
        # else:
        #     print("{0}: {1}, with distance of {2}".format(i, user_movie_rating_pivot.index[indices.flatten()[i]], distances.flatten()[i]))
        recommended.append([[user_movie_rating_pivot.index[indices.flatten()[i]], distances.flatten()[i]]])

    return recommended


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Returns K nearest neighbours of inputted movie')
    parser.add_argument('title', type=str, help='Movie name is required')
    parser.add_argument('neighbours', type=int, nargs='?', help='Number of neighbours')
    args = parser.parse_args()
    knn_recommender(args.title, args.neighbours)

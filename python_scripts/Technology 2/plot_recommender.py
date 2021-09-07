import pandas as pd
import argparse
from sqlalchemy import create_engine
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel


def plot_recommender(mysql_url, movie_title):
    engine = create_engine(mysql_url)
    connection = engine.connect()
    movies_query = connection.execute("SELECT * FROM Movies")

    movies = pd.DataFrame(movies_query)
    movies.columns = movies_query.keys()

    # removes all english stop words
    tfidf = TfidfVectorizer(stop_words='english')

    # replace NaN with an empty string
    movies['mDescription'] = movies['mDescription'].fillna('')

    # Construct the required TF-IDF matrix by fitting and transforming the data
    tfidf_matrix = tfidf.fit_transform(movies['mDescription'])

    # Compute the cosine similarity matrix
    cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)

    # Construct a reverse map of indices and movie titles
    indices = pd.Series(movies.index, index=movies['mName']).drop_duplicates()

    # Get the index of the movie that matches the title
    idx = indices[movie_title]

    # Get the pairwise similarity scores of all movies with that movie
    sim_scores = list(enumerate(cosine_sim[idx]))

    # Sort the movies based on the similarity scores
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

    # Get the scores of the 10 most similar movies
    sim_scores = sim_scores[1:11]

    # Get the movie indices
    movie_indices = [i[0] for i in sim_scores]

    # Return the top 10 most similar movies
    return movies['mName'].iloc[movie_indices]


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Returns movies with similar plots')
    parser.add_argument('title', type=str, help='Movie name is required')
    args = parser.parse_args()
    print(plot_recommender('mysql://root@localhost/tm224', args.title))

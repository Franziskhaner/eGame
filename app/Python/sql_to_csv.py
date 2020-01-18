import pymysql
import pandas

conn = pymysql.connect(host='localhost',
                             user='root',
                             password='',
                             db='egame',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
cursor = conn.cursor()

ratings_query = 'select user_id, article_id, score, created_at from ratings'
ratings = pandas.read_sql_query(ratings_query, conn)
ratings.to_csv("C:/wamp64/www/eGame/app/Python/ratings.csv", index=False)

articles_query = 'select id, name from articles'
articles = pandas.read_sql_query(articles_query, conn)
articles.to_csv("C:/wamp64/www/eGame/app/Python/articles.csv", index=False)


import sys
import pandas as pd
import numpy as np
import json
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.metrics import pairwise_distances

# Con sys.argv[] obtenemos el argumento pasado al método constructor de Proccess
# en la clase CollaborativeFilteringController, en éste caso el user_id: 

user = int(sys.argv[1]);

# En primer lugar obtenemos nuestro Dataset (fuente de datos), de la que se alimentará el sistema de recomendaciones,
# para ello necesitaremos las valoraciones de los usuarios, así como los juegos existentes en la tienda:
articles = pd.read_csv("C:/wamp64/www/eGame/app/Python/articles.csv", encoding = "Latin1")
Ratings = pd.read_csv("C:/wamp64/www/eGame/app/Python/ratings.csv")

# Renombramos la columna 'id' de la tabla 'articles' por 'article_id' para poder hacer uso del método merge()
# más adelante.
articles = articles.rename(columns={"id": "article_id"})

# Para utilizar la función Similitud del Coseno más adelante, es necesario realizar un preprocesamiento
# y limpiar los datos, también es importante normalizar las calificaciones de los usuarios:
Mean = Ratings.groupby(by="user_id", as_index=False)['score'].mean()
Rating_avg = pd.merge(Ratings, Mean, on='user_id')
Rating_avg['adg_score'] = Rating_avg['score_x'] - Rating_avg['score_y']

check = pd.pivot_table(Rating_avg, values='score_x', index='user_id', columns='article_id')

# A continuación generamos la tabla que contendrá la relación de las valoraciones hechas por cada usuario a cada
# juego, muchas celdas estarán vacías (valores NaN), sobre todo al registrarse un usuario, ya que no habrá realizado
# ninguna valoración (Problema del Cold Start):
final = pd.pivot_table(Rating_avg, values='adg_score', index='user_id', columns='article_id')

# Para sustituir esos valores NaN o nulos, hemos utilizado dos métodos distintos:

# Promedio del artículo sobre la columna
final_article = final.fillna(final.mean(axis=0))

# Promedio del usuario sobre la fila
final_user = final.apply(lambda row: row.fillna(row.mean()), axis=1)

# El siguiente paso es calcular la similitud entre los usuarios por medio de estos dos promedios:

# Similitud de usuario al reemplazar NaN por la media de los usuarios
b = cosine_similarity(final_user)
np.fill_diagonal(b, 0 )
similarity_with_user = pd.DataFrame(b, index=final_user.index)
similarity_with_user.columns = final_user.index

# Similitud de usuario al reemplazar NaN por la media de los artículos (juegos) 
cosine = cosine_similarity(final_article)
np.fill_diagonal(cosine, 0 )
similarity_with_article = pd.DataFrame(cosine, index=final_article.index)
similarity_with_article.columns=final_user.index

# Para mejorar la eficiencia del algoritmo, sobre todo si la base de datos de usuarios es demasiado grande, nos
# quedamos sólo con los n usuarios más cercanos (vecinos). Establecemos 6 vecinos por defecto dado que el proyecto es
# de carácter didáctico:

def find_n_neighbours(df,n):
    order = np.argsort(df.values, axis=1)[:, :n]
    df = df.apply(lambda x: pd.Series(x.sort_values(ascending=False)
           .iloc[:n].index, 
          index = ['top{}'.format(i) for i in range(1, n+1)]), axis=1)
    return df

# top 6 vecinos por cada usuario usando el promedio del usuario
sim_user_6_u = find_n_neighbours(similarity_with_user, 6)

# top 6 vecinos por cada usuario usando el promedio del artículo
sim_user_6_m = find_n_neighbours(similarity_with_article, 6)

"""
Ha continuación definimos la Función de Puntuaciones, la cual se encargará de predecir una puntuación sobre un juego
en concreto respecto a un usuario dado, representando con qué intensidad le puede gustar dicho juego a dicho usuario.

La puntuación será igual a la suma de las calificaciones que cada usuario le dió a ese juego, restando la calificación
promedio de este usuario multiplicada por un peso, el cual dependerá de cómo de similar es este usuario respecto a
otro o de cuánto se supone que debe contribuir a las predicciones de otro usuario. Para calcular este peso se ha utilizado
la Similitud de Coseno.

Para que el algoritmo sea más eficiente aún, sólo comparamos las puntuaciones con los n vecinos más cercanos,
en lugar de hacerlo con todos.

"""

Rating_avg = Rating_avg.astype({"article_id": str})
Article_user = Rating_avg.groupby(by='user_id')['article_id'].apply(lambda x:','.join(x))

def get_predicted_articles(user):
    Article_seen_by_user = check.columns[check[check.index==user].notna().any()].tolist()
    a = sim_user_6_m[sim_user_6_m.index==user].values
    b = a.squeeze().tolist()
    d = Article_user[Article_user.index.isin(b)]
    l = ','.join(d.values)
    Article_seen_by_similar_users = l.split(',')
    Articles_under_consideration = list(set(Article_seen_by_similar_users)-set(list(map(str, Article_seen_by_user))))
    Articles_under_consideration = list(map(int, Articles_under_consideration))
    score = []
    for item in Articles_under_consideration:
        c = final_article.loc[:,item]
        d = c[c.index.isin(b)]
        f = d[d.notnull()]
        avg_user = Mean.loc[Mean['user_id'] == user,'score'].values[0]
        index = f.index.values.squeeze().tolist()
        corr = similarity_with_article.loc[user,index]
        fin = pd.concat([f, corr], axis=1)
        fin.columns = ['adg_score','correlation']
        fin['score'] = fin.apply(lambda x:x['adg_score'] * x['correlation'], axis=1)
        nume = fin['score'].sum()
        deno = fin['correlation'].sum()
        final_score = avg_user + (nume/deno)
        score.append(final_score)
    data = pd.DataFrame({'article_id':Articles_under_consideration,'score':score})
    top_6_recommendation = data.sort_values(by='score', ascending=False).head(6)
    Article_ID = top_6_recommendation.merge(articles, how='inner', on='article_id')
    Article_IDs = json.dumps(Article_ID.article_id.values.tolist())
    return Article_IDs

#Y finalmente, devolvemos las predicciones de los 5 mejores artículos para el usuario recibido por parámetro:

predicted_articles = get_predicted_articles(user)
print(predicted_articles)

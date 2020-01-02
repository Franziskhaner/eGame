<?php declare(strict_types=1);

namespace App;

use Exception;

class ContentBasedFiltering
{
    protected $articles = [];
    protected $priceWeight;
    protected $genderWeight;
    protected $platformWeight;
    protected $priceHighRange = 100;

    public function __construct(array $articles)
    {
        $this->articles       = $articles;
        $this->priceHighRange = max(array_column($articles, 'price'));  /*Nos quedamos con el precio del juego más caro*/
    }

    public function setPlatformWeight(float $weight): void
    {
        $this->platformWeight = $weight;
    }

    public function setPriceWeight(float $weight): void
    {
        $this->priceWeight = $weight;
    }

    public function setGenderWeight(float $weight): void
    {
        $this->genderWeight = $weight;
    }

    public function calculateSimilarityMatrix(): array
    {
        $matrix = [];

        foreach ($this->articles as $article) {

            $similarityScores = [];

            foreach ($this->articles as $_article) {
                if ($article['id'] === $_article['id']) {
                    continue;
                }
                $similarityScores['article_id_' . $_article['id']] = $this->calculateSimilarityScore($article, $_article);
            }
            $matrix['article_id_' . $article['id']] = $similarityScores;
        }
        return $matrix;
    }

    public function getArticlesSortedBySimilarity(int $articleId, array $matrix): array
    {
        $similarities   = $matrix['article_id_' . $articleId] ?? null;
        $sortedarticles = [];

        if (is_null($similarities)) {
            throw new Exception('Cant find article with that ID.');
        }
        arsort($similarities);  //Ordena el array en orden inverso manteniendo la asociación de índices

        foreach ($similarities as $articleIdKey => $similarity) {
            $id       = intval(str_replace('article_id_', '', $articleIdKey)); /*Reemplazamos el 'article_id' de cada artículo dentro del vector de similitudes ($similarities) por un string vacío '', y guardamos su valor como entero, osea su ID.*/
            $articles = array_filter($this->articles, function ($article) use ($id) { return $article['id'] === $id; });/* */
            if (! count($articles)) {
                continue;
            }
            $article  = $articles[array_keys($articles)[0]]; /*Nos quedamos con la clave del elemento 0 del array $articles*/
            $article['similarity'] = $similarity; /*Añadimos la propiedad 'Similarity' a cada artículo y le asignamos su valor correspondiente ya calculado en la función calculateSimilarityScore()*/
            $sortedarticles[] = $article;
        }
        return $sortedarticles;
    }

    protected function calculateSimilarityScore($articleA, $articleB)
    {
        return array_sum([
            (Similarity::euclidean(
                Similarity::minMaxNorm([$articleA['price']], 0, $this->priceHighRange),
                Similarity::minMaxNorm([$articleB['price']], 0, $this->priceHighRange)
            ) * $this->priceWeight),
            (Similarity::jaccard($articleA['platform'], $articleB['platform']) * $this->platformWeight),
            (Similarity::jaccard($articleA['gender'], $articleB['gender']) * $this->genderWeight)
        ]) / ($this->platformWeight + $this->priceWeight + $this->genderWeight);
    }
}
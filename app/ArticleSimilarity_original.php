<?php declare(strict_types=1);

namespace App;

use Exception;

class ArticleSimilarity
{
    protected $articles       = [];
    protected $featureWeight  = 1;
    protected $priceWeight    = 1;
    protected $categoryWeight = 1;
    protected $priceHighRange = 1000;

    public function __construct(array $articles)
    {
        $this->articles       = $articles;
        $this->priceHighRange = max(array_column($articles, 'price'));
    }

    public function setFeatureWeight(float $weight): void
    {
        $this->featureWeight = $weight;
    }

    public function setPriceWeight(float $weight): void
    {
        $this->priceWeight = $weight;
    }

    public function setCategoryWeight(float $weight): void
    {
        $this->categoryWeight = $weight;
    }

    public function calculateSimilarityMatrix(): array
    {
        $matrix = [];

        foreach ($this->articles as $article) {

            $similarityScores = [];

            foreach ($this->articles as $_article) {
                if ($article->id === $_article->id) {
                    continue;
                }
                $similarityScores['article_id_' . $_article->id] = $this->calculateSimilarityScore($article, $_article);
            }
            $matrix['article_id_' . $article->id] = $similarityScores;
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
            $id       = intval(str_replace('article_id_', '', $articleIdKey));
            $articles = array_filter($this->articles, function ($article) use ($id) { return $article->id === $id; });
            if (! count($articles)) {
                continue;
            }
            $article = $articles[array_keys($articles)[0]];
            $article->similarity = $similarity;
            $sortedarticles[] = $article;
        }
        return $sortedarticles;
    }

    protected function calculateSimilarityScore($articleA, $articleB)
    {
        $articleAFeatures = implode('', get_object_vars($articleA->features));
        $articleBFeatures = implode('', get_object_vars($articleB->features));

        return array_sum([
            (Similarity::hamming($articleAFeatures, $articleBFeatures) * $this->featureWeight),
            (Similarity::euclidean(
                Similarity::minMaxNorm([$articleA->price], 0, $this->priceHighRange),
                Similarity::minMaxNorm([$articleB->price], 0, $this->priceHighRange)
            ) * $this->priceWeight),
            (Similarity::jaccard($articleA->categories, $articleB->categories) * $this->categoryWeight)
        ]) / ($this->featureWeight + $this->priceWeight + $this->categoryWeight);
    }
}
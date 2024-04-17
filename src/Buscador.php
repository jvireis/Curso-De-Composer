<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador 
{
    private $crawler;
    private $httpClient;
    public function __construct(CLientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }
    public function buscar(string $url): array 
    {
        $resposta = $this->httpClient->request('GET', $url);
        $html = $resposta->getBody();

        $crawler = new Crawler();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }

}
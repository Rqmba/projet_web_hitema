<?php

namespace App\Twig\Runtime;

use App\Repository\ArticleRepository;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    // public function __construct(ArticleRepository $articleRepository)
    // {
    //     $this->$articleRepository = $articleRepository;
    // }

    // public function getCodeBlock(String $value):string
    // {
    //     $value = preg_replace('#<#', '&lt', $value);
    //     $value = preg_replace('#>#', '&gt', $value);
    //     return "<pre><code>
    //         $value
    //     </code></pre>";
    // }
}

<?php

use Geekco\CmsBundle\Services\Slugify;
use PHPUnit\Framework\TestCase;

class SlugifyTest extends TestCase
{
    public function testSlugify()
    {
        $slugify = new Slugify();
        $result = $slugify->slugify('"les caractères accentués sont interdits, de même que les espaces et les caractères spéciaux. 1, 2... autorisés"');

        $this->assertEquals('les-cateres-accentues-sont-interdits-de-meme-que-les-espaces-et-les-caracteres-speciaux-1-2-autorises', $result);
    }
}

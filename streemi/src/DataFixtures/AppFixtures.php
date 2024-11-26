<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Language;
use Symfony\Component\Yaml\Yaml;
use App\Entity\Media;
use App\Enum\MediaTypeEnum;

class AppFixtures extends Fixture
{
    public function loadCategories(ObjectManager $manager)
    {

        $fixturesPath = Yaml::parseFile(__DIR__ .'/../../fixtures/categories.yaml');

        foreach ($fixturesPath['categories'] as $data) {
            $entity = new Categorie();
            $entity->setName($data['name']);
            $entity->setLabel($data['description']);
        
            $manager->persist($entity);
        }
        
        $manager->flush();
    }
    public function loadLanguage(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/language.yaml');


        $fixturesPath = Yaml::parseFile($filePath);
        
        foreach ($fixturesPath['language'] as $data) {
            $entity = new Language();
            $entity->setName($data['name']);
            $entity->setCode($data['code']);
        
            $manager->persist($entity);
        }
        
        $manager->flush();
    }

    public function loadMedia(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/media.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/media.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['media'] as $data) {
            $media = new Media();
            $media->setTitle($data['title']);
            $media->setMediaType(MediaTypeEnum::from($data['mediaType']));
            $media->setShortDescription($data['shortDescription']);
            $media->setLongDescription($data['longDescription']);
            $media->setReleaseDate(new \DateTime($data['releaseDate']));
            $media->setCoverImage($data['coverImage']);
            $media->setStaff($data['staff']);
            $media->setCasting($data['casting']);

            $manager->persist($media);
        }

        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadLanguage($manager);
        $this->loadMedia($manager);
    }
}
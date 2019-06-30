<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Pet;
use App\Entity\Status;
use App\Entity\Photo;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        // statuses
        $availableStatus = new Status();
        $availableStatus->setName('available');
        $manager->persist($availableStatus);

        $pendingStatus = new Status();
        $pendingStatus->setName('pending');
        $manager->persist($pendingStatus);

        $soldStatus = new Status();
        $soldStatus->setName('sold');
        $manager->persist($soldStatus);

        // categories
        $dogCategory = new Category();
        $dogCategory->setName('Dogs');
        $manager->persist($dogCategory);

        $catCategory = new Category();
        $catCategory->setName('Cats');
        $manager->persist($catCategory);

        // tags
        $smallTag = new Tag();
        $smallTag->setName('Small');
        $manager->persist($smallTag);

        $largeTag = new Tag();
        $largeTag->setName('Large');
        $manager->persist($largeTag);

        $friendlyTag = new Tag();
        $friendlyTag->setName('Friendly');
        $manager->persist($friendlyTag);

        // photos
        $dogPhoto = new Photo();
        $dogPhoto->setUrl('https://66.media.tumblr.com/af814842429c9f109f50bee4e451b069/tumblr_omd7h45Ums1w73ry4o1_640.jpg');

        $catPhoto = new Photo();
        $catPhoto->setUrl('https://i.imgur.com/ohGIDqqx.jpg');

        // pets
        $doggo = new Pet();
        $doggo->setName('Doggo')
            ->setCategory($dogCategory)
            ->addTag($largeTag)
            ->addTag($friendlyTag)
            ->addPhoto($dogPhoto)
            ->setStatus($availableStatus);
        $manager->persist($doggo);

        $kitty = new Pet();
        $kitty->setName('Kitty')
            ->setCategory($catCategory)
            ->addTag($smallTag)
            ->addPhoto($catPhoto)
            ->setStatus($pendingStatus);
        $manager->persist($kitty);

        $manager->flush();
    }
}

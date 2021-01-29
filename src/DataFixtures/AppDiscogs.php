<?phpnamespace App\DataFixtures;use App\Entity\Artist;use App\Entity\Product;use Discogs\ClientFactory;use Doctrine\Bundle\FixturesBundle\Fixture;use Doctrine\Persistence\ObjectManager;class AppDiscogs extends Fixture{    public function load(ObjectManager $manager)    {        $discogs = ClientFactory::factory([            'defaults' => [                'query' => [                    'token' => 'mYZEwjHtHWJqtNyfdZSSgwyWSQIAVBPqRlDbVBha',                ],            ]        ]);            for ($i = 1; $i <= 9 ; $i++) {                    $artist = new Artist();                    $artist->setName($discogs->getArtist(['id' => $i ])['name']);                    $manager->persist($artist);                $albums = $discogs->getArtistReleases(['id' => $i ])['releases'];                foreach ($albums as $album) {                    $product = new Product();                    $product->setName($album['title'])                            ->setReleaseAt(new \DateTime())                            ->setPrice(10)                            ->setStyle($album['type'])                            ->setImage($album['thumb'])                            ->setArtist($artist);                    $manager->persist($product);                }            }        $manager->flush();    }}
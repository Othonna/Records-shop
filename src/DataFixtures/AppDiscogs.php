<?phpnamespace App\DataFixtures;use App\Entity\Product;use Discogs\ClientFactory;use Doctrine\Bundle\FixturesBundle\Fixture;use Doctrine\Persistence\ObjectManager;class AppDiscogs extends Fixture{    public function load(ObjectManager $manager)    {        $discogs = ClientFactory::factory([            'defaults' => [                'query' => [                    'token' => 'PfcoZEOmGOPSsOjglLzExkOTyKRcWSkqkQsKiTdm',                ],            ]        ]);        for ($i = 1; $i <= 100; $i++) {            $artist = $discogs->getArtist(['id' => $i ]);            $information = $discogs->getRelease(['id' => $i]);            $product = new Product();            $product->setName($artist['name'])                    ->setDescription($artist['profile'])                    ->setPrice($information['num_for_sale'])                    ->setReleaseAt($information('released'))                    ->setStyle($information['genres'])                    ->setImage(($information['images']));            $manager->persist($product);        }        $manager->flush();    }}
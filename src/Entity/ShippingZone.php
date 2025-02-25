namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ShippingZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Courier::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Courier $courier = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $shippingZoneName = '';

    #[ORM\ManyToMany(targetEntity: ShippingRate::class, mappedBy: 'shippingZones')]
    private iterable $shippingRates; // Many ShippingRates

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function getShippingZoneName(): ?string
    {
        return $this->shippingZoneName;
    }

    public function getShippingRates(): iterable
    {
        return $this->shippingRates;
    }
}

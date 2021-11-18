<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="group", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Configuration", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="group_configuration",
     *     joinColumns={
     *          @ORM\JoinColumn(name="group", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="configuration", referencedColumnName="id")
     *     }
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $configurations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Feature", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="group_feature",
     *     joinColumns={
     *          @ORM\JoinColumn(name="group", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="feature", referencedColumnName="id")
     *     }
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $features;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->configurations = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Group
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param User $user
     * @return Group
     */
    public function addUser(User $user): self
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function removeUser(User $user): bool
    {
        return $this->users->removeElement($user);
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @return array|null
     */
    public function getConfigurations(): ?array
    {
        return $this->configurations->toArray();
    }

    /**
     * @param Collection $configurations
     * @return Group
     */
    public function setConfigurations(Collection $configurations):self
    {
        $this->configurations = $configurations;

        return $this;
    }

    /**
     * @param Configuration $configuration
     * @return Group
     */
    public function addConfiguration(Configuration $configuration):self
    {
        $this->configurations->add($configuration);

        return $this;
    }

    /**
     * @param Configuration $configuration
     * @return bool
     */
    public function removeConfiguration(Configuration $configuration): bool
    {
        return $this->configurations->removeElement($configuration);
    }

    /**
     * @return array|null
     */
    public function getFeatures(): ?array
    {
        return $this->features->toArray();
    }

    /**
     * @param Collection $features
     * @return Group
     */
    public function setFeatures(Collection $features):self
    {
        $this->features = $features;

        return $this;
    }

    /**
     * @param Feature $feature
     * @return Group
     */
    public function addFeature(Feature $feature):self
    {
        $this->features->add($feature);

        return $this;
    }

    /**
     * @param Feature $feature
     * @return bool
     */
    public function removeFeature(Feature $feature): bool
    {
        return $this->features->removeElement($feature);
    }
}


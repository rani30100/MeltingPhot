<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Assert\GroupSequence(["custom", "length", "regex", "NotBlank","User"])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
//Contraintes de validation

#[Assert\NotBlank(
    message :"Le nom d'utilisateur ne peut pas être vide."
    )]

#[Assert\Length(
    min: 2,
    max: 25,
    minMessage: "Le nom d'utilisateur doit comporter au moins {{ limit }} caractères.",
    maxMessage: "Le nom d'utilisateur doit comporter au maximum {{ limit }} caractères.",
)]

#[Assert\Regex(
    pattern:"/^[a-zA-Z]+\d*$/",
    message:"Le nom d'utilisateur ne peut contenir que des lettres et des chiffres, et les chiffres sont autorisés uniquement à la fin.", groups:["regex"]
)]

#[Assert\Callback(
    callback:"validateUsername", groups:["custom"]
)]

// Table User dans la base de donnée
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER', 'ROLE_ADMIN','ROLE_SUPER_ADMIN'];
    

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(min: 6,max: 4096,minMessage:"Votre mot de passe doit contenir au moins {{ limit }} characters")]
    private ?string $password = null;
    
    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Posts::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\Column]
    private $username;
    
    #[ORM\ManyToMany(targetEntity: Newsletter::class, mappedBy: 'user_id')]
    private Collection $newsletters;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Video::class)]
    private Collection $created_at;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->newsletters = new ArrayCollection();
        $this->created_at = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    #[Assert\Callback]
    public function validateUsername(ExecutionContextInterface $context, $payload)
    {
        // Check for spaces in the username
        if (strpos($this->username, ' ') !== false) {
            $context->buildViolation("Le nom d'utilisateur ne doit pas contenir d'espaces.")
                ->atPath('username')
                ->addViolation();
        }
        if (strpos($this->password, ' ') !== false) {
            $context->buildViolation("Le nom d'utilisateur ne doit pas contenir d'espaces.")
                ->atPath('username')
                ->addViolation();
        }

        if (strlen($this->password) < 6) {
            $context->buildViolation('Le mot de passe doit contenir au minimum 6 caractères')
                ->atPath('password')
                ->addViolation();
        }

        // Check for alphanumeric characters only
        if (!ctype_alnum($this->username)) {
            $context->buildViolation("Le nom d'utilisateur ne peut utiliser que des chiffres et lettres.")
                ->atPath('username')
                ->addViolation();
        }

             // Check for alphanumeric characters only
             if (!ctype_alnum($this->password)) {
                $context->buildViolation("Le nom d'utilisateur ne peut utiliser que des chiffres et lettres.")
                    ->atPath('username')
                    ->addViolation();
            }

        // Check for numbers only at the end of the username
        if (!preg_match('/^[a-zA-Z]+[0-9]*$/', $this->username)) {
            $context->buildViolation("Les seuls chiffres du nom d'utilisateur doivent être à la fin.")
                ->atPath('username')
                ->addViolation();
        }

        // // Check for minimum length of the username
        // if (strlen($this->username) < 2) {
        //     $context->buildViolation("Le nom d'utilisateur doit comporter au moins {{ limit }} caractères.")
        //         ->atPath('username')
        //         ->setParameter('{{ limit }}', 2)
        //         ->addViolation();
        // }
    }




    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */


    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Posts>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUserId($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUserId() === $this) {
                $post->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Newsletter>
     */
    public function getNewsletters(): Collection
    {
        return $this->newsletters;
    }

    public function addNewsletter(Newsletter $newsletter): self
    {
        if (!$this->newsletters->contains($newsletter)) {
            $this->newsletters->add($newsletter);
            $newsletter->addUserId($this);
        }

        return $this;
    }

    public function removeNewsletter(Newsletter $newsletter): self
    {
        if ($this->newsletters->removeElement($newsletter)) {
            $newsletter->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getCreatedAt(): Collection
    {
        return $this->created_at;
    }

    public function addCreatedAt(Video $createdAt): self
    {
        if (!$this->created_at->contains($createdAt)) {
            $this->created_at->add($createdAt);
            $createdAt->setUser($this);
        }

        return $this;
    }

    public function removeCreatedAt(Video $createdAt): self
    {
        if ($this->created_at->removeElement($createdAt)) {
            // set the owning side to null (unless already changed)
            if ($createdAt->getUser() === $this) {
                $createdAt->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setUserId($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUserId() === $this) {
                $image->setUserId(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


}

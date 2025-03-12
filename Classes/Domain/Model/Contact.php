<?php

declare(strict_types=1);

namespace Remind\Contacts\Domain\Model;

use Sabre\VObject\Component\VCard;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Contact extends AbstractEntity
{
    protected string $firstName = '';

    protected string $lastName = '';

    protected string $middleName = '';

    protected int $salutation = 0;

    protected string $title = '';

    protected string $phone = '';

    protected string $email = '';

    protected string $mobile = '';

    protected string $address = '';

    protected string $slug = '';

    protected string $position = '';

    /**
     * @var ObjectStorage<Group> $groups
     */
    protected ObjectStorage $groups;

    protected ?FileReference $image = null;

    public function getDisplayName(): string
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'contacts'
        );
        $propertyNames = $settings['displayNameFields'];
        $properties = [];
        foreach (GeneralUtility::trimExplode(',', $propertyNames, true) as $propertyName) {
            if ($this->_hasProperty($propertyName)) {
                $properties[] = $this->_getProperty($propertyName);
            }
        }
        return implode(' ', array_filter($properties));
    }

    public function getVCard(): VCard
    {
        $photo = $this->image?->getOriginalResource()?->getContents();
        $vCard = new VCard([
            'VERSION' => '4.0',
        ]);
        if ($photo) {
            $vCard->add(
                'PHOTO',
                base64_encode($photo),
                ['ENCODING' => 'BASE64', 'VALUE' => 'TEXT']
            );
        }
        $vCard->add(
            'N',
            [
                $this->lastName,
                $this->firstName,
                $this->middleName,
                $this->title,
            ],
            ['CHARSET' => 'ISO-8859-1']
        );
        $vCard->add('EMAIL', $this->email, ['TYPE' => 'WORK']);
        $vCard->add('TEL', $this->mobile, ['TYPE' => 'CELL']);
        $vCard->add('TEL', $this->phone, ['TYPE' => 'WORK']);
        $vCard->add('TITLE', $this->position, ['CHARSET' => 'ISO-8859-1']);
        return $vCard;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getSalutation(): int
    {
        return $this->salutation;
    }

    public function setSalutation(int $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addGroup(Group $group): void
    {
        $this->groups->attach($group);
    }

    public function removeGroup(Group $group): void
    {
        $this->groups->detach($group);
    }

    /**
     * @return ObjectStorage<Group>
     */
    public function getGroups(): ObjectStorage
    {
        return $this->groups;
    }

    /**
     * @param ObjectStorage<Group> $groups
     */
    public function setGroups(ObjectStorage $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     */
    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    /**
     */
    public function setImage(FileReference $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }
}
